<?php
require('../config.php');
session_start();

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['eventBanner'])) {
    $eventBanner = $_FILES['eventBanner']['name'];
    $tmp = $_FILES['eventBanner']['tmp_name'];

    // Fetch current profile picture from the database
    $stmt = $conn->prepare("SELECT event_banner FROM event WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $currentPhoto = $stmt->fetchColumn();

    // Check for errors
    if ($_FILES['eventBanner']['error'] == 0) {
        // Delete the old photo if it exists
        if ($currentPhoto && file_exists("../uploads/eventBanner/$currentPhoto")) {
            unlink("../uploads/eventBanner/$currentPhoto");
        }
        
        if (move_uploaded_file($tmp, '../uploads/eventBanner/' . $eventBanner)) {
            $query = "UPDATE event SET event_banner = ? WHERE event_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$eventBanner, $event_id]);

            $_SESSION['success'] = "Profile picture updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to upload photo.";
        }
    } else {
        $_SESSION['error'] = "Failed to upload photo.";
    }

    header('Location: createEvent.php');
    exit();
}
?>
