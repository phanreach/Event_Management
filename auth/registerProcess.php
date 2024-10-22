<?php
require_once 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }
    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO user (username, email, password, role ) VALUES (?, ?, ?,?)";
        $stmt = $conn->prepare($query);

        if ($stmt->execute([$username, $email, $hashed_password, $role])) {
            echo "Registration successful!";
            header('Location: login.php'); 
            exit();
        } else {
            echo "Registration failed. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
