<?php

    require '../config.php';

    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../event/browse_event.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) ) {
        $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $event_id = filter_input(INPUT_GET, 'eventId', FILTER_VALIDATE_INT);

        if ($userId === false || $event_id === false) {
            echo "Invalid ID!";
            exit;
        }

        $deleteQuery = "DELETE FROM user_event WHERE event_id = ? AND user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        if ($stmt->execute([$event_id, $userId])) {

            $_SESSION['success'] = "Registration deleted successfully!";
            header('Location: editEvent.php?id=' . $event_id);
        } else {
            $_SESSION['error'] = "Failed to delete registration!";
            echo "Failed to delete registration!";
        }

    }