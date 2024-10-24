<?php
require '../config.php'; // Database connection

if (isset($_POST['confirm'])) {

    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['id']; // Ensure the session user ID is set

    try {
       // Retrieve the user's registration count for this event
       $sql = "SELECT COUNT(*) FROM user_event WHERE event_id = ? AND user_id = ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$event_id, $user_id]);
       $registration_exists = $stmt->fetchColumn();

       if ($registration_exists) {
        // Delete the registration from user_event
        $sqlDelete = "DELETE FROM user_event WHERE event_id = ? AND user_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->execute([$event_id, $user_id]);
    
        // Update the available slots in the event table
        $sqlUpdate = "UPDATE event SET available_slot = available_slot + 1 WHERE event_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([$event_id]);
    
        $_SESSION['message'] = "You have successfully canceled your registration.";
        header("Location: myHistory.php");
    } else {
        $_SESSION['message'] = "No registration found for this event.";
        header("Location: myHistory.php");
    }
    
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Debugging purpose
    }
} else {
    echo "Invalid request.";
}
