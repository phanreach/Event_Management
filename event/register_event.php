<?php
include '../config.php';  

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit();
}


if (isset($_POST['confirm-register']) && isset($_POST['event_id'])) {

    $name = htmlspecialchars(trim($_POST['name']));
    $slot_amount = intval($_POST['slot_amount']);
    $event_id = intval($_POST['event_id']);

    // Fetch event details
    $stmt = $conn->prepare("SELECT participant_number, registration FROM event WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if ($event) {
        $participant_number = $event['participant_number'];
        $registration = $event['registration'];
        $available_slot = $participant_number - $registration;

        // Check if there are enough available slots
        if ($available_slot >= $slot_amount) {
            // Update registration
            $stmt = $conn->prepare("UPDATE event SET registration = registration + ?, available_slot = participant_number - registration WHERE event_id = ?");
            if ($stmt->execute([$slot_amount, $event_id])) {
                // Registration successful, redirect with success message
                header('Location: event_details.php?id=' . $event_id . '&registration=success');
                exit();
            } else {
                // Handle insertion error
                header('Location: event_details.php?id=' . $event_id . '&registration=failure');
                exit();
            }
        } else {
            // Not enough available slots
            header('Location: event_details.php?id=' . $event_id . '&registration=failure');
            exit();
        }
    } else {
        echo "Event not found.";
    }
} else {
    // Handle case where form was not submitted properly
    echo "Invalid request.";
}
?>
