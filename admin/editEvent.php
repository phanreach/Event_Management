<?php

    require_once '../config.php';
    
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../event/browse_event.php');
        exit();
    }