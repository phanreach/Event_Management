<?php
    $hostname = 'localhost';
    $dbname = 'event_management_db';
    $username = '';
    $password = '';

    try {
        $dsn = "mysql:host=$hostname;dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database connection failed: " . $e->getMessage();
        exit();    
    }
    
    session_start();

    $sessionLifetime = 1800;

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionLifetime) {
    session_unset();
    session_destroy();
    header('Location: ../auth/login.php');
    exit();
    }

    $_SESSION['LAST_ACTIVITY'] = time();
?>
