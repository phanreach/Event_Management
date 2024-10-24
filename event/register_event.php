<?php
include '../config.php';  

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit();
}


if (isset($_POST['confirm-register']) && isset($_POST['event_id'])) {

    $slot_amount = intval($_POST['slot_amount']);
    $event_id = intval($_POST['event_id']);

    $stmt = $conn->prepare("SELECT participant_number, registration FROM event WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if (!$event) {
        $_SESSION['error'] = "Event not found.";
    }

    $participant_number = $event['participant_number'];
    $registration = $event['registration'];
    $available_slot = $participant_number - $registration;

    if ($slot_amount > $available_slot) {
        $_SESSION['error'] = "Not enough slots available.";
    }

    $created_at = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO user_event (user_id, event_id, created_at) VALUES (?, ?, ?)");
    $is_registered = $stmt->execute([$_SESSION['id'], $event_id, $created_at]);

    if ($is_registered) {
        $stmt = $conn->prepare("UPDATE event SET registration = registration + ?, available_slot = available_slot - ? WHERE event_id = ?");
        $is_updated = $stmt->execute([$slot_amount, $slot_amount, $event_id]);

        if ($is_updated) {
            $_SESSION['success'] = "Registered successfully!";
            header('Location: ../event/event_details.php?event_id=' . $event_id);
        } else {
            $_SESSION['error'] = "Failed to update event registration.";
        }
    } else {
        $_SESSION['error'] = "Failed to register for the event.";
    }
}
?>
