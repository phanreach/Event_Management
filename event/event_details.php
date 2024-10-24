<?php
include '../config.php';  
session_start();

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']); 
} else {
    die('No event ID provided.');
}

$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->execute([$event_id]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die('Event not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['event_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../userSidebar/style.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include '../userSidebar/sidebar.php'; ?>
        <div class="main">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-4"><?php echo htmlspecialchars($event['event_name']); ?></h1>
            </div>
              <!-- Display success message -->
              <?php if (isset($_GET['registration']) && $_GET['registration'] == 'success'): ?>
                <div class="alert alert-success" role="alert">
                    Your registration is successful!
                </div>
            <?php endif; ?>

            <!-- Display failure message -->
            <?php if (isset($_GET['registration']) && $_GET['registration'] == 'failure'): ?>
                <div class="alert alert-danger" role="alert">
                    Registration failed. No available slots.
                </div>
            <?php endif; ?>
            <!-- Event Details -->
            <div class="container w-75">
                <div class="card shadow-lg mb-5">
                    <!-- Event Image -->
                    <img  src="<?= isset($event['event_banner']) && !empty($event['event_banner']) 
                              ? '../uploads/eventBanner/' . htmlspecialchars($event['event_banner']) 
                              : 'https://via.placeholder.com/400x200?text=Image+Not+Found' ?>"
                               class="card-img-top img-fluid" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title">Event Details</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['start_date'])); ?></li>
                            <li class="list-group-item"><strong>Start Time:</strong> <?php echo date('g:i A', strtotime($event['start_time'])); ?></li>
                            <li class="list-group-item"><strong>End Time:</strong> <?php echo date('g:i A', strtotime($event['end_time'])); ?></li>
                            <li class="list-group-item"><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></li>
                            <li class="list-group-item"><strong>Available Slots:</strong> <?php echo htmlspecialchars($event['available_slot']); ?></li>
                        </ul>
                        <p class="card-text mb-4"><?php echo htmlspecialchars($event['description']); ?></p>
                        <!-- Button to trigger the modal -->
                        <button class="btn btn-primary" id="register-btn">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
   <!-- Modal -->
<div class="modal" tabindex="-1" id="register-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="register_event.php">
                <div class="modal-header">
                    <h5 class="modal-title">Register for Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to register for this event?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Submit the form when the user confirms registration -->
                    <button type="submit" class="btn btn-primary" name="confirm-register">Confirm</button>
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
                </div> 
            </form>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../userSidebar/script.js"></script>

    <script>
document.getElementById('register-btn').addEventListener('click', function() {
    <?php if (!isset($_SESSION['id'])): ?>
        window.location.href = '../auth/login.php';
    <?php else: ?>
        var modal = new bootstrap.Modal(document.getElementById('register-event'));
        modal.show();
    <?php endif; ?>
});
</script>

</body>
</html>
