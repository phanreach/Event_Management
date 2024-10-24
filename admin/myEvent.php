<?php
require '../config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../event/browse_event.php');
  exit();
}

$userId = $_SESSION['id'];

$query = "SELECT * FROM event WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$userId]);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="../sidebar/style.css" rel="stylesheet">

</head>
<body>
<div class="wrapper">
  <?php include '../sidebar/adminSidebar.php'  ?>
    <div class="container my-5">
      <h1>Your Events</h1>
        <div class="row">
          <?php if (empty($events)): ?>
            <div class="alert alert-warning">No events found.</div>
            <?php else: ?>
              <?php foreach ($events as $event): ?>
                <div class="col-md-4 mb-4">
                  <div class="card">
                    <img src="<?= isset($event['event_banner']) && !empty($event['event_banner']) 
                              ? '../uploads/eventBanner/' . htmlspecialchars($event['event_banner']) 
                              : 'https://via.placeholder.com/400x200?text=Image+Not+Found' ?>" 
                              class="card-img-top" alt="Event Image">
                      <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['event_name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                        <p><strong>Date:</strong> <?= date('F j, Y', strtotime($event['start_date'])) ?></p>
                        <a href="editEvent.php?id=<?= $event['event_id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="deleteEvent.php?id=<?= $event['event_id'] ?>" class="btn btn-danger">Delete</a>
                      </div>
                    </div>
                  </div>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../sidebar/adminScript.js"></script>

</body>
</html>