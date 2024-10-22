<?php
require_once('config.php');

session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "User found: " . print_r($user, true); 
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 
    
            if ($user['role'] == 'admin') {
                header('Location: adminDashboard.php'); 
            } else {
                header('Location: userDashboard.php');
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password!"; 
            header('Location: login.php'); 
            exit();
        }
    } else {
        echo "No user found with that email."; 
    }
    
}
?>
