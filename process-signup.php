<?php
session_start();

// Client-side validation bypassed, perform server-side checks
if (empty($_POST["first_name"])) {
    die("First name is required");
}

if (empty($_POST["last_name"])) {
    die("Last name is required");
}

if (empty($_POST["about"])) {
    die("About is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("A valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters long");
}

if (!preg_match("/[a-z]/i", $_POST['password'])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST['password'])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] != $_POST["password_confirmation"]) {
    die("Passwords must match");
}

if (!isset($_FILES["image"])) {
    die("Profile image field is not set.");
}

// if (empty($_POST["image"])) {
//     die("Profile image is required.");
// }



// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$activation_token = bin2hex(random_bytes(16));

$activation_token_hash = hash("sha256", $activation_token);

$mysqli = require __DIR__ . "/includes/database.inc.php";


$finfo = new finfo(FILEINFO_MIME_TYPE);

if (!isset($finfo)) {
    $mime_type = $finfo->file($_FILES["image"]["tmp_name"]);

    $mime_types = ["image/gif", "image/png", "image/jpeg"];

    if (! in_array($mime_type, $mime_types)) {
        exit("Invalid file type");
    }
    // Replace any characters not \w- in the original filename
    $pathinfo = pathinfo($_FILES["image"]["name"]);

    $base = $pathinfo["filename"];

    $base = preg_replace("/[^\w-]/", "_", $base);

    $filename = $base . "." . $pathinfo["extension"];

    $destination = __DIR__ . "/upload/" . $filename;

    // Add a numeric suffix if the file already exists
    $i = 1;

    while (file_exists($destination)) {

        $filename = time() . '.jpg';
        $destination = __DIR__ . "/upload/" . $filename;

        $i++;
    }


    if (! move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {

        exit("Can't move uploaded file");
    }

    echo "File uploaded successfully.";
}







// Insert data into pending_users table
$sql = "INSERT INTO users (first_name, last_name, about, email, password_hash, profile_image, account_activation_hash) VALUES (?, ?, ?, ?, ?, ?, ?)";

try {
    // Prepare the statement
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        throw new Exception("SQL ERROR: " . $mysqli->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "sssssss",
        $_POST["first_name"],
        $_POST["last_name"],
        $_POST["about"],
        $_POST["email"],
        $password_hash,
        $filename,
        $activation_token_hash
    );

    // Execute the statement
    $stmt->execute();

    // Send activation email
    $mail = require __DIR__ . "/forget-password/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($_POST["email"]);
    $mail->Subject = "Account activation";
    $mail->Body = <<<END
    Click <a href="http://localhost/web-project/activate-account.php?token=$activation_token">here</a> 
    to Activate your password.
    END;

    try {
        $mail->send();

        echo "Message sent, please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit();
    }

    $_SESSION['user_email'] = $_POST['email']; // Store the email
    $_SESSION['signup_token'] = bin2hex(random_bytes(16)); // Generate a temporary token


    header("Location: signup-success.php");
    exit;

    //mysqli_sql_exception is a subclass of Exception specifically designed for database-related errors in MySQLi.
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        die("Email already taken. Please use another email.");
    } else {
        echo "Error: " . $e->getMessage() . " (Error Code: " . $e->getCode() . ")";
    }

    // Exception is more general and will catch all types of exceptions, not the MySQL-specific details.
} catch (Exception $e) {
    // Handle any other exceptions
    echo "Error: " . $e->getMessage();
}
