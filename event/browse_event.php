<?php
require '../config.php';
session_start();

$userId = $_SESSION['id'];

$queryAccountType = "SELECT role FROM user WHERE id = ?";
$stmtAccountType = $conn->prepare($queryAccountType);
$stmtAccountType->execute([$userId]);
$accountType = $stmtAccountType->fetchColumn();

// Initialize search query and parameters
$searchQuery = isset($_GET['search_query']) ? htmlspecialchars(trim($_GET['search_query'])) : '';
$params = [];

// Base SQL query
$countSql = "SELECT * FROM event WHERE 1=1"; 

if ($searchQuery) {
    $countSql .= " AND event_name LIKE ?";
    $params[] = '%' . $searchQuery . '%';
}

// Prepare and execute the search query
$stmt = $conn->prepare($countSql);
$stmt->execute($params);

// Fetch matching events
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="../sidebar/style.css" rel="stylesheet">
  <link href="../styles.css" rel="stylesheet">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
      if ($accountType == 'admin') {
        include '../sidebar/adminSidebar.php';
      } else {
        include '../sidebar/userSidebar.php';
      }
    ?>

    <!-- Main Content -->
    <div class="main">
      <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h1>Upcoming Events</h1>
          <div class="col-md-3">
            <form method="GET" action="" class="mb-4">
              <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Search for events..." value="<?php echo htmlspecialchars($searchQuery); ?>" required>
                <button class="btn btn-primary" type="submit">Search</button>
              </div>
            </form>
          </div>
        </div>

        <div class="row">
          <?php
          if ($events) {
            foreach ($events as $event) {
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
                      <p><strong>Price:</strong> <?= htmlspecialchars($event['price']); ?></p>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                      <i class="bi bi-person"></i> <?= htmlspecialchars($event['participant_number']); ?>
                    </div>
                  </div>
                  <a href="event_details.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-primary">View Details</a>
                </div>
              </div>
            </div>
          <?php
            }
          } else {
            echo "<p>No events found matching your search.</p>";
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