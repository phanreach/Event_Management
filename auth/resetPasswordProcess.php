<?php
session_start();
require 'config.php';  // Include your database connection

if (isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password'])) {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: resetPassword.php?token=$token");
        exit;
    }

    // Fetch the user by token
    $query = $conn->prepare("SELECT * FROM user WHERE reset_token = ?");
    $query->execute([$token]);
    $user = $query->fetch();

    if ($user && strtotime($user['reset_expires']) > time()) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateQuery = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
        $updateQuery->execute([$hashedPassword, $token]);

        $_SESSION['success'] = "Your password has been reset. You can now log in.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: forgotPassword.php");
    }
}
?>
