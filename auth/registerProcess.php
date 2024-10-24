<?php
session_start(); // Start the session
require_once '../config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header('Location: register.php'); // Redirect back to the registration page
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            // Email already exists
            $_SESSION['error'] = "Error: The email address is already registered.";
            header('Location: register.php'); // Redirect back to the registration page
            exit();
        }

        // If email does not exist, insert the new user
        $query = "INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt->execute([$username, $email, $hashed_password, $role])) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header('Location: login.php'); 
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header('Location: register.php'); // Redirect back to the registration page
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('Location: register.php'); // Redirect back to the registration page
        exit();
    }
}
?>
