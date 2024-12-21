<?php

// echo $_GET['id'];
session_start();

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
