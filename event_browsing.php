<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Browsing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include '../sidebar/sidebar.php'; ?>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Upcoming Events</h1>
            <div class="col-md-3">
                <input type="text" name="search_query" class="form-control" placeholder="Search tasks..." value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
            </div>
        </div>

        <div class="row">
            <?php
            require 'config.php';

            $query = "SELECT * FROM event";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $events = $stmt->fetchAll();

            foreach ($events as $event): ?>
            <div class="col-md-4 event-card-wrapper" data-category="<?php echo htmlspecialchars($event['category']); ?>">
                <div class="event-card">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Event Image">
                    <div class="p-3">
                        <span class="badge"><?php echo htmlspecialchars($event['category']); ?></span>
                        <h5><?php echo htmlspecialchars($event['name']); ?></h5>
                        <p><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                        <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                        <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../sidebar/script.js"></script>
</body>
</html>





