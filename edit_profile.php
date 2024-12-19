<?php

// // echo $_GET['id'];
// session_start();

// if (isset($_SESSION["user_id"])) {

//     $mysqli =  require __DIR__ . "../includes/database.php";

//     $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

//     $result = $mysqli->query($sql);

//     $user = $result->fetch_assoc();



//     if ($_SERVER["REQUEST_METHOD"] === "POST") {

//         $first_name = $_POST["first_name"];
//         $last_name = $_POST["last_name"];
//         $about = $_POST["about"];
//         // $email = $_POST["email"];
//         $current_password = $_POST["current_password"];
//         $new_password = $_POST["new_password"];
//         $confirm_password = $_POST["password_confirmation"];

//         // Check if current password matches
//         if (!password_verify($current_password, $user["password_hash"])) {
//             die("Current password is incorrect.");
//         }

//         // Check if new passwords match
//         if ($new_password !== $confirm_password) {
//             die("New passwords do not match confirm password.");
//         }

//         // Validate password strength (optional, add your own criteria)
//         if (strlen($new_password) < 8) {
//             die("New password must be at least 8 characters long.");
//         }

//         // Hash the new password
//         $new_password_hashed = password_hash($confirm_password, PASSWORD_DEFAULT);

//         $update_sql = "UPDATE users SET first_name = ?, last_name = ?, about = ?,  password_hash = ?  WHERE id = ?";
//         $stmt = $mysqli->prepare($update_sql);
//         $stmt->bind_param(
//             "ssssi",
//             $first_name,
//             $last_name,
//             $about,
//             // $email,
//             $new_password_hashed,
//             $user["id"]
//         );

//         if ($stmt->execute()) {
//             header("Location: user-profile.php");
//             exit();
//         } else {
//             die("Error updating profile: " . $mysqli->error);
//         }
//     }
// } else {
//     header("location: index.php");
// }
// 
?>

<?php

// echo $_GET['id'];
require __DIR__ . "../includes/sessions.inc.php";

$mysqli = require __DIR__ . "../includes/database.inc.php";

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {


    // initialize arrays empty
    $updates = [];
    $params = [];
    $types = "";

    // Check each field and add it to the update query if provided
    if (!empty($_POST["first_name"])) {
        $updates[] = "first_name = ?";
        $params[] = $_POST["first_name"];
        $types .= "s";
    }

    if (!empty($_POST["last_name"])) {
        $updates[] = "last_name = ?";
        $params[] = $_POST["last_name"];
        $types .= "s";
    }

    if (!empty($_POST["about"])) {
        $updates[] = "about = ?";
        $params[] = $_POST["about"];
        $types .= "s";
    }

    // Handle password updates
    $current_password = $_POST["current_password"] ?? null;
    $new_password = $_POST["new_password"] ?? null;
    $confirm_password = $_POST["password_confirmation"] ?? null;

    if (!empty($current_password)) {


        // Check if current password matches
        if (!password_verify($current_password, $user["password_hash"])) {
            die("Current password is incorrect.");
        }
        // Require new password and confirmation if current password is provided
        if (empty($new_password) || empty($confirm_password)) {
            die("Please provide both new password and confirmation.");
        }

        // Check if new passwords match
        if ($new_password !== $confirm_password) {
            die("New passwords do not match.");
        }

        // Validate password strength
        if (strlen($new_password) < 8) {
            die("New password must be at least 8 characters long.");
        }

        // Hash the new password
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $updates[] = "password_hash = ?";
        $params[] = $new_password_hashed;
        $types .= "s";
    }

    // If no fields to update, do nothing
    if (empty($updates)) {
        die("No fields to update.");
    }

    // Prepare the final SQL query
    $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
    $params[] = $_SESSION["user_id"];
    $types .= "i";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='user-profile.php';</script>";
        exit();
    } else {
        die("Error updating profile: " . $mysqli->error);
    }
}

?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">

    <title>Signup Form</title>
    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            const validation = new JustValidate('#signup', {
                errorLabelStyle: {
                    color: 'rgb(190 18 60)', // Tailwind's red-400 equivalent (or use any color code)
                    fontSize: '0.875rem', // Equivalent to Tailwind's `text-sm`
                    marginTop: '0.25rem', // Equivalent to `mt-1`
                },
            });

            validation
                .addField('#first_name', [{
                        rule: 'required',
                        errorMessage: 'First name is required'
                    },

                ])
                .addField('#last_name', [{
                        rule: 'required',
                        errorMessage: 'Last name is required'
                    },

                ])
                .addField('#about', [{
                        rule: 'required',
                        errorMessage: 'About is required'
                    },

                ])
                .addField('#email', [{
                        rule: 'required',
                        errorMessage: 'Email is required',
                    },
                    {
                        rule: 'email',
                        errorMessage: 'Email is not valid',
                    },
                    {
                        validator: (value) => () => {
                            // This line sends an HTTP request to the validate-email.php file, passing the email value in the URL.
                            return (
                                fetch("validate-email.php?email=" + encodeURIComponent(value))
                                // This converts the response into JSON format
                                .then(function(response) {
                                    return response.json();
                                })
                                .then(function(json) {
                                    return json.available;
                                })
                            );
                        },
                        errorMessage: "Email already taken. Try to login",
                    },
                ])
                .addField('#password', [{
                        rule: 'required',
                        errorMessage: 'Password is required',
                    },
                    {
                        validator: (value) => {
                            // Ensure password is at least 8 characters long, contains at least one letter, and at least one number
                            return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value);
                        },
                        errorMessage: 'Password must be at least 8 characters long, contain at least one letter and one number',




                    },
                    {
                        rule: 'minLength',
                        value: 6,
                        errorMessage: 'Password must be at least 6 characters long',
                    },
                ])
                .addField("#password_confirmation", [{
                        rule: "required",
                    },
                    {
                        validator: (value, fields) => {
                            return value === fields["#password"].elem.value;
                        },
                        errorMessage: "Passwords should match",
                    },
                ])
                .addField('#dropzone-file', [

                    {
                        rule: 'required',
                        errorMessage: 'Profile is required',
                    },
                    {
                        validator: (value, fields) => {


                            const fileInput = fields['#dropzone-file'].elem; // Access the file input element
                            return fileInput.files.length > 0; // Ensure at least one file is selected

                        },
                        errorMessage: 'Please upload a valid file',
                    },
                ])
                .onSuccess((event) => {
                    document.getElementById("signup").submit();
                });

        });
    </script>
</head>

<body>



    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Edit Profile</h2>
        <!-- <div id="img-view"
            style="width: 200px; height: 200px; background-size: cover; background-position: center; margin-top: 20px;">
        </div> -->
        <form action="" method="post" enctype="multipart/form-data" novalidate>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                        name</label>
                    <input type="text" id="first_name" name="first_name"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" value="<?php echo htmlspecialchars($user["first_name"]); ?>" />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last
                        name</label>
                    <input type="text" id="last_name" name="last_name"
                        class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" value="<?php echo htmlspecialchars($user["last_name"]); ?>" />
                </div>










            </div>
            <!-- profile here -->

            <div class="col-span-full mb-6">
                <label for="about" class="block text-sm font-medium text-gray-900">About</label>
                <div class="mt-2">
                    <textarea id="about" rows="4" name="about"
                        class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($user["about"]); ?></textarea>
                </div>
                <p class="mt-3 text-sm text-gray-600">Write a few sentences about yourself.</p>
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email
                    address</label>
                <input type="email" id="email" name="email" class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" value=<?php echo htmlspecialchars($user["email"]); ?> disabled readonly />

            </div>
            <div class="mb-6">
                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900 ">Current password</label>
                <input type="password" id="current_password" name="current_password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" />
            </div>
            <div class="mb-6">
                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 ">New password</label>
                <input type="password" id="new_password" name="new_password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" />
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Confirm
                    password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2  "
                    placeholder="•••••••••" required />
            </div>
            <button type="submit" name="update"
                class="text-white bg-zinc-900  focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center">
                Update</button>
        </form>

    </div>



    <!-- footer start -->
    <footer class="bg-zinc-100 rounded-lg shadow m-4">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center ">© 2024 <a href="https://flowbite.com/"
                    class="hover:underline">Foodie™</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 sm:mt-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- footer end -->



    <script src="main.js"></script>



</body>

</html>