<?php
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="../userSidebar/style.css" rel="stylesheet">
</head>
<style>
        .event-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .event-card:hover {
            transform: scale(1.03);
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            background-color: #ffc107;
            color: #fff;
        }
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include '../userSidebar/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Upcoming Events</h1>
            <div class="col-md-3">
                <input type="text" name="search_query" class="form-control" placeholder="Search event..." value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
            </div>
        </div>
        <div class="row mt-5">
          <?php
            require '../config.php';
            $query = "SELECT * FROM event";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $events = $stmt->fetchAll();

            foreach ($events as $event) {
          ?>
          <div class="col-md-4 event-card-wrapper" data-category="">
              <div class="event-card">
                  <img src="" alt="Event Image">
                  <div class="p-4">
                  <p class="fw-bold text-primary display-6"><?= htmlspecialchars($event['event_name']); ?></p>
                  <i class="fa fa-calendar"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?>
                  <div class="row my-2"></div>
                  <i class="fa fa-clock"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?>
                  <div class="container my-2"></div>
                  <p><strong>Location:</strong> <?= $event['location']; ?></p>
                  <p><strong>Description:</strong> <?= $event['description']; ?></p>
                  <?php
                    $description = htmlspecialchars($event['description']);
                    $description_words = explode(' ', $description);
                    $short_description = implode(' ', array_slice($description_words, 0, 20)) . '...';
                  ?>
                  <div class="row my-3">
                    <div class="col d-flex align-items-center">
                      </p><strong>Price:</strong> <?= $event['price']; ?></p>
                    </div>
                    <div class="col d-flex justify-content-end align-items-center">
                      <i class="fa fa-user me-1" ></i> <?= $event['participant_number']; ?></p>
                    </div>
                  </div>
                  <a href="../user/event_details.php?id=<?php echo $event['event_id']; ?>" class="btn btn-primary">View Details</a>
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
  <script src="../userSidebar/script.js"></script>
</body>
</html>
