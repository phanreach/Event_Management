<?php
require '../config.php'; // Database connection

if (isset($_POST['confirm'])) {

    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['id'];

    try {
       // Retrieve the user's registration count for this event
       $sql = "SELECT register_amount FROM user_event WHERE event_id = ? AND user_id = ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$event_id, $user_id]);
       $registration_exists = $stmt->fetchColumn();

       if ($registration_exists) {

        $sqlDelete = "DELETE FROM user_event WHERE event_id = ? AND user_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->execute([$event_id, $user_id]);
    
        // Update the available slots in the event table
        $sqlUpdate = "UPDATE event SET registration = registration - " . $registration_exists . " WHERE event_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([$event_id]);
    
        $_SESSION['success'] = "Registration cancelled successfully.";
        header("Location: myHistory.php");
        
        }
    
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
