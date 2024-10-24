<?php
  require '../config.php';
  session_start();

  if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="../sidebar/style.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include '../sidebar/adminSidebar.php'; ?>

    <!-- Main Content -->
    <div class="main">
      <div class="container my-3">
        <h1>Admin Dashboard</h1>
        <div class="row mt-5">
          <?php
            require '../config.php';
            $query = "SELECT * FROM event";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $events = $stmt->fetchAll();

            foreach ($events as $event) {
          ?>
          <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card mb-4">
              <div class="card-header bg-primary text-white">
                <?= $event['event_name']; ?>
              </div>
              <div class="card-body">
                <p><strong>Start Date:</strong> <?= $event['start_date']; ?></p>
                <p><strong>End Date:</strong> <?= $event['end_date']; ?></p>
                <p><strong>Start Time:</strong> <?= $event['start_time']; ?></p>
                <p><strong>Location:</strong> <?= $event['location']; ?></p>
                <p><strong>Description:</strong> <?= $event['description']; ?></p>
                <p><strong>End Time:</strong> <?= $event['end_time']; ?></p>
                <p><strong>Participant Number:</strong> <?= $event['participant_number']; ?></p>
                <p><strong>Price:</strong> <?= $event['price']; ?></p>
              </div>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../sidebar/script.js"></script>
</body>
</html>
