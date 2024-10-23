<?php
  require 'config.php';

  $query = "SELECT * FROM event";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $events = $stmt->fetchAll();

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
  <!-- <link href="sidebar/style.css" rel="stylesheet"> -->
  <style>
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 30px;
      transition: transform 0.3s ease;
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .card:hover {
      transform: scale(1.03);
    }

    .LongText {
      min-height: 48px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    /* .badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 12px;
      background-color: #ffc107;
      color: #fff;
    } */
    /* .btn-group .btn {
      margin-right: 5px;
    } */
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <!-- <?php include 'sidebar/sidebar.php'; ?> -->

    <!-- Main Content -->
    <div class="main">
      <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h1>Upcoming Events</h1>
          <div class="col-md-3">
            <input type="text" name="search_query" class="form-control" placeholder="Search event..." value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
          </div>
        </div>

        <div class="row">
          <?php
            foreach ($events as $event) {
          ?>
            <div class="col-md-4">
              <div class="card shadow-sm mb-3">
                <img src="<?= 'uploads/eventBanner/'. htmlspecialchars($event['event_banner']); ?>" alt="Event Image">
                <div class="p-4">
                  <h3 class="fw-bold text-primary mb-3"><?= htmlspecialchars($event['event_name']); ?></h3>
                  <p class="LongText"><?= htmlspecialchars($event['description']); ?></p>
                  <p><i class="fa fa-calendar"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?></p>
                  <p><i class="fa fa-clock"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?></p>
                  <p class="LongText"><i class="fa fa-location-dot"></i> <?= htmlspecialchars($event['location']); ?></p>
                  <div class="row">
                    <div class="col d-flex align-items-center">
                      <p><strong>Price:</strong> <?= htmlspecialchars($event['price']); ?></p>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                      <i class="fa fa-user me-1"></i> <?= htmlspecialchars($event['participant_number']); ?>
                    </div>
                  </div>
                  <a href="user/event_details.php?id=<?php echo $event['event_id']; ?>" class="btn btn-primary">View Details</a>
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
  <script src="sidebar/script.js"></script>
</body>
</html>
