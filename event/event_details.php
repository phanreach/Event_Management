<?php
include '../config.php';  

if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    // Continue with registration logic
} else {
    die("No event ID provided.");
}



$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->execute([$event_id]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die('Event not found.');
}

$participant_number = $event['participant_number'] ?? 0;
$registration = $event['registration'] ?? 0;
if ($participant_number < $registration) {
    $available_slot = 0;
} else {
    $available_slot = $participant_number - $registration;
}

$stmt = $conn->prepare("SELECT * FROM user_event WHERE user_id = ? AND event_id = ?");
$stmt->execute([$_SESSION['id'], $event_id]);
$user_event = $stmt->fetch();

$isAvailable = false;
if ($user_event) {
    $isAvailable = true;
    $_SESSION['error'] = "You have already registered for this event.";
}

if ($available_slot <= 0) {
    $isAvailable = true;
    $_SESSION['error'] = "No available slots for this event.";
}

$queryEventCreator = "SELECT username FROM user WHERE id = ?";
$stmt = $conn->prepare($queryEventCreator);
$stmt->execute([$event['creator_id']]);
$eventCreatorName = $stmt->fetchColumn();
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
    <link href="../sidebar/style.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include '../sidebar/userSidebar.php'; ?>
        <div class="main">
            <nav class="navbar bg-body-secondary shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="browse_event.php">
                        <h2><i class="bi bi-chevron-left"></i></h2>
                    </a>
                </div>
            </nav>
            <!-- Display success or failure message -->
            <div class="container mt-3">
                 <?php if (isset($_SESSION['success'])): ?>
                     <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
                     <?php unset($_SESSION['success']); ?>
                 <?php elseif (isset($_SESSION['error'])): ?>
                     <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
                     <?php unset($_SESSION['error']); ?>
                 <?php endif; ?>
            </div>

            <!-- Event Details -->
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="card mb-3">
                            <img src="<?= isset($event['event_banner']) && !empty($event['event_banner']) 
                                        ? '../uploads/eventBanner/' . htmlspecialchars($event['event_banner']) 
                                        : 'https://via.placeholder.com/400x200?text=Image+Not+Found' ?>" 
                                class="card-img" alt="Event Image">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-primary fw-bold mb-3"><?= htmlspecialchars($event['event_name']) ?></h3>
                                <p><i class="bi bi-person mx-2"></i>Create by: <?= $eventCreatorName ?></p>
                                <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($event['location']) ?></p>  
                                <p><i class="bi bi-tags"></i> <?= htmlspecialchars($event['price']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <p><i class="bi bi-calendar-check"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?></p>
                                <p><i class="bi bi-hourglass-top"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?></p>
                                <p><i class="bi bi-person"></i> <?= $available_slot ?> slots available</p>
                                <button class="btn btn-primary" id="register-btn" data-bs-toggle="modal" data-bs-target="#register-event"
                                    <?= $isAvailable ? 'disabled' : '' ?>>
                                    Register
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Registration -->
    <div class="modal" tabindex="-1" id="register-event">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="register_event.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Register for Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="number" name="slot_amount" placeholder="Slot Amount" class="form-control" min="1" required>
                        </div>
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="confirm-register">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../sidebar/script.js"></script>

</body>
</html>
