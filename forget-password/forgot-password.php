<?php

// if ($_SERVER["REQUEST_METHOD"] === "POST") {

//     $mysqli = require __DIR__ . "/../includes/database.inc.php";

//     // Validate email format
//     if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
//         die("A valid email is required");
//     }

//     // Use prepared statement to prevent SQL injection
//     $sql = "SELECT * FROM users WHERE email = ?";
//     $stmt = $mysqli->prepare($sql);
//     $stmt->bind_param("s", $_POST["email"]);
//     $stmt->execute();

//     $result = $stmt->get_result();

//     $user = $result->fetch_assoc();

//     // Check if user exists
//     if ($user) {
//         // User found, handle accordingly
//     } else {
//         // No user found, handle accordingly
//     }

//     // Close the statement
//     $stmt->close();
// }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot | Password</title>
    <link href="../output.css" rel="stylesheet">
</head>

<body>
    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Forgot Password</h2>

        <form method="post" action="send-password-reset.php" novalidate>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email
                    address</label>
                <input type="email" id="email" name="email" class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 
                    placeholder=" required />

            </div>
            <!-- <div>
            <label for="email">email</label>
            <input type="email" id="email" name="email">
        </div> -->
            <button
                class="mb-10 text-gray-900 bg-gray-100 hover:bg-gray-200  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2">
                Submit</button>

        </form>
    </div>
</body>

</html>