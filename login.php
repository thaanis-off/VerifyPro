<?php


$is_invalid = false;

$user = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require_once __DIR__ . "/includes/database.inc.php";;

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->bind_param("s", $_POST["email"]);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();


    if ($user && $user["account_activation_hash"] === null) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            if ($user["user_status"] == 0) {
                // Update user_status to 1
                $update_stmt = $mysqli->prepare("UPDATE users SET user_status = 1 WHERE id = ?");

                $update_stmt->bind_param("i", $user["id"]);

                $update_stmt->execute();

                $update_stmt->close();
            }

            session_start();

            // Regenerate session ID for security
            session_regenerate_id();

            // Store the user's ID in the session
            $_SESSION["user_id"] = $user["id"];

            header("location: index.php");
            exit();
        }
    }



    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with | Dave</title>
    <link href="./output.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="app.js"></script>
</head>

<body>
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php if (!$user): ?>
            <?php echo "<script>alert('We haven\'t found this email in our records');</script>"; ?>
        <?php elseif ($is_invalid): ?>
            <?php echo "<script>alert('Invalid email or password');</script>"; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Login</h2>
        <!-- <div id="img-view"
            style="width: 200px; height: 200px; background-size: cover; background-position: center; margin-top: 20px;">
        </div> -->
        <form method="post" novalidate>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email
                    address</label>
                <input type="email" id="email" name="email" class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 
                    placeholder=" required value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" />

            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                <input type="password" id="password" name="password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" required />
            </div>






            <button
                class="mb-10 text-gray-900 bg-gray-100 hover:bg-gray-200  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2">
                Login</button>
            <a href="forget-password/forgot-password.php">Forgot Password?</a>
            <a href="signup.php">Sign Up</a>



        </form>

    </div>








</body>

</html>