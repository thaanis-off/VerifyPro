    <?php

    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/includes/database.php";

    $sql = "SELECT * FROM users
        WHERE account_activation_hash = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("Invalid or expired activation token.");
    }

    $sql = "UPDATE users 
                    SET account_activation_hash = NULL
                    WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $user["id"]);

    $stmt->execute();

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Account activation</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="js/validation.js" defer></script>
    </head>

    <body>

        <h1>Account activation</h1>
        <p>Account activated succesful. you can now
            <a href="./login.php">Log in</a>
        </p>


    </body>

    </html>