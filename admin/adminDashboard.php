<?php
  require '../config.php';

  if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../event/browse_event.php');
    exit();
  }
  $userId = 8;

  $queryCoutEvents = "SELECT COUNT(*) FROM event WHERE creator_id = ?";
  $stmtCountEvents = $conn->prepare($queryCoutEvents);
  $stmtCountEvents->execute([$userId]);
  $countEvents = $stmtCountEvents->fetchColumn();

  $searchQuery = isset($_GET['search_query']) ? htmlspecialchars(trim($_GET['search_query'])) : '';

  $queryMyEvents = "SELECT * FROM event WHERE creator_id = ?";
  $params = [$userId];

  if ($searchQuery) {
    $queryMyEvents .= " AND event_name LIKE ?";
    $params[] = '%' . $searchQuery . '%';
  }

  $stmtMyEvents = $conn->prepare($queryMyEvents);
  $stmtMyEvents->execute($params);
  $myEvents = $stmtMyEvents->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="../sidebar/style.css" rel="stylesheet">
  <link href="../styles.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include '../sidebar/adminSidebar.php'; ?> 

    <!-- Main Content -->
    <div class="main">
      <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h1>Admin Dashboard</h1>
          <div class="col-md-3">
            <form method="GET" class="mb-4">
              <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Search for events..." value="<?php echo htmlspecialchars($searchQuery); ?>" required>
                <button class="btn btn-primary" type="submit">Search</button>
              </div>
            </form>
          </div>
        </div>

        <div class="row">
          <?php
          if(empty($myEvents)) {
            echo "<p>No events found.</p>";
          } else {
            foreach ($myEvents as $event) {
          ?>
            <div class="col-md-4">
              <div class="card shadow-sm mb-3">
                <img src="<?= isset($event['event_banner']) && !empty($event['event_banner']) 
                              ? '../uploads/eventBanner/' . htmlspecialchars($event['event_banner']) 
                              : 'https://via.placeholder.com/400x200?text=Image+Not+Found' ?>" alt="Event Image">
                <div class="p-4">
                  <h3 class="fw-bold text-primary mb-3"><?= htmlspecialchars($event['event_name']); ?></h3>
                  <p class="LongText"><?= htmlspecialchars($event['description']); ?></p>
                  <p><i class="bi bi-calendar-check"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?></p>
                  <p><i class="bi bi-hourglass-top"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?></p>
                  <p class="LongText"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($event['location']); ?></p>
                  <div class="row">
                    <div class="col d-flex align-items-center">
                      <i class="bi bi-person mx-2"></i> <?= htmlspecialchars($event['registration']); ?>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                    <i class="bi bi-people mx-2"></i> <?= htmlspecialchars($event['participant_number']); ?>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col d-flex align-items-center">
                      <a href="editEvent.php?id=<?php echo $event['event_id']; ?>" class="btn btn-outline-primary">Edit Event Info</a>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                        <a href="deleteEvent.php?id=<?php echo $event['event_id']; ?>" class="btn btn-outline-danger">Delete Event</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }}; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../sidebar/script.js"></script>
</body>
</html>
