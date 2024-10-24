<?php
    $hostname = 'localhost';
    $dbname = 'event_management_db';
    $username = 'root';
    $password = 'Mysql';

    try {
        $dsn = "mysql:host=$hostname;dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Database connection failed: " . $e->getMessage();
        exit();    
    }
?>

