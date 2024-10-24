<?php
require '../config.php';

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

try {
  // Define and sanitize the search query
  $searchQuery = isset($_GET['search_query']) ? '%' . htmlspecialchars($_GET['search_query']) . '%' : '%';

  $sql = "SELECT e.event_id, e.event_name, e.description, e.start_date, e.end_date, 
  e.start_time, e.end_time, e.location, e.event_banner, e.price, 
  e.participant_number
  FROM event e
  JOIN user_event u ON e.event_id = u.event_id
  WHERE u.user_id = ? AND e.event_name LIKE ?";


  $stmt = $conn->prepare($sql);
  $stmt->execute([$_SESSION['id'], $searchQuery]);
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$events) {
      $noEventsMessage = "No events found matching your search.";
  }
} catch (Exception $e) {
  echo "Error fetching events: " . $e->getMessage();
}
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
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include '../sidebar/userSidebar.php'; ?>

    <!-- Main Content -->
    <div class="main">
      <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h1>Your Registered Events</h1>
          <div class="col-md-3">
          <form method="GET" action="" class="mb-4"> <!-- action="" to keep on the same page -->
              <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Search for events..." value="<?php echo htmlspecialchars(isset($_GET['search_query']) ? $_GET['search_query'] : ''); ?>" required>
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
                      <!-- Button to trigger the modal -->
                      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal" data-event-id="<?= $event['event_id']; ?>">
                        Cancel
                      </button>
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

        <!-- Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="cancel.php">
                <div class="modal-header">
                  <h5 class="modal-title" id="cancelModalLabel">Cancel Event</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to cancel this event?</p>
                  <input type="hidden" name="event_id" id="modalEventId">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="confirm">Confirm</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../sidebar/script.js"></script>
  <script>
    // Pass the event_id dynamically to the modal
    var cancelModal = document.getElementById('cancelModal');
    cancelModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var eventId = button.getAttribute('data-event-id');
      var modalEventId = cancelModal.querySelector('#modalEventId');
      modalEventId.value = eventId;
    });
  </script>
</body>
</html>
