<?php
include '../config.php';  
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_POST['confirm-register']) && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);
    $user_id = $_SESSION['id']; 

    $stmt = $conn->prepare("SELECT participant_number, registration FROM event WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
      $participant_number = $event['participant_number'];
      $registration = $event['registration'];
      $available_slot = $participant_number - $registration;

      if ($available_slot > 0) {
          $stmt = $conn->prepare("UPDATE event SET registration = registration + 1, available_slot = participant_number - registration WHERE event_id = ?");
          $stmt->execute([$event_id]);

          header("Location: event_details.php?id=$event_id&registration=success");
          exit();
      } else {
          header("Location: event_details.php?id=$event_id&registration=failure");
          exit();
      }
  } else {
      die('Event not found.');
  }
}
?>
