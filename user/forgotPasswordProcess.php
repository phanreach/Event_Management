<?php
session_start();
require 'config.php';  // Include your database connection

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch();

    if ($user) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50));
        
        // Save the token and its expiration time in the database
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour
        $updateQuery = $conn->prepare("UPDATE user SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $updateQuery->execute([$token, $expires, $email]);

        // Send reset link to user via email
        $resetLink = "http://yourdomain.com/resetPassword.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: no-reply@yourdomain.com";  // Replace with your email

        mail($email, $subject, $message, $headers);

        $_SESSION['success'] = "A password reset link has been sent to your email.";
        header("Location: forgotPassword.php");
    } else {
        $_SESSION['error'] = "Email not found.";
        header("Location: forgotPassword.php");
    }
}
?>
