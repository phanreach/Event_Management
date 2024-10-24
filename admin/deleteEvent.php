<?php

    require_once '../config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        // var_dump($_GET);

        $eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($eventId === false) {
            echo "Invalid ID!";
            exit;
        }

        $deleteQuery = "DELETE FROM event WHERE event_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        if ($stmt->execute([$eventId])) {

            $_SESSION['success'] = "Event deleted successfully!";
            header('Location: adminDashboard.php');
        } else {
            $_SESSION['error'] = "Failed to delete event!";
            echo "Failed to delete event!";
        }
    }
