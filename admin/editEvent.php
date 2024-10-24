<?php

    require_once '../config.php';
    
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../event/browse_event.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $eventId = $_GET['id'];

        $query = "SELECT * FROM event WHERE event_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$eventId]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        $queryCreator = "SELECT username FROM user WHERE id = ?";
        $stmtCreator = $conn->prepare($queryCreator);
        $stmtCreator->execute([$event['creator_id']]);
        $eventCreatorName = $stmtCreator->fetchColumn();

        $queryParticipant = "SELECT u.id, u.username, ue.created_at FROM user u 
                            JOIN user_event ue ON u.id = ue.user_id
                            WHERE ue.event_id = ?";
        $stmtParticipant = $conn->prepare($queryParticipant);
        $stmtParticipant->execute([$eventId]);
        $participants = $stmtParticipant->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // var_dump($participants);
        // echo '</pre>';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $eventId = $_POST['eventId'];
        $eventName = htmlspecialchars(trim($_POST['eventName']));
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $location = htmlspecialchars(trim($_POST['location']));
        $description = htmlspecialchars(trim($_POST['description']));
        $participantNumber = $_POST['participantNumber'];

        $eventBanner = $_FILES['eventBanner']['name'];
        $tmp = $_FILES['eventBanner']['tmp_name'];

        $query = "UPDATE event SET event_name = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ?, location = ?, description = ?, participant_number = ? WHERE event_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$eventName, $startDate, $endDate, $startTime, $endTime, $location, $description, $participantNumber, $eventId]);

        if ($_FILES['eventBanner']['error'] == 0) {
            $stmtBanner = $conn->prepare("SELECT event_banner FROM event WHERE event_id = ?");
            $stmtBanner->execute([$eventId]);
            $currentBanner = $stmtBanner->fetchColumn();

            if ($currentBanner && file_exists("../uploads/eventBanner/$currentBanner")) {
                unlink("../uploads/eventBanner/$currentBanner");
            }

            if (move_uploaded_file($tmp, '../uploads/eventBanner/' . $eventBanner)) {
                $queryBanner = "UPDATE event SET event_banner = ? WHERE event_id = ?";
                $stmtBanner = $conn->prepare($queryBanner);
                $stmtBanner->execute([$eventBanner, $eventId]);
            }
        }

        header('Location: editEvent.php?id=' . $eventId);
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['event_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../sidebar/style.css" rel="stylesheet">
</head>

<style>
    .form-control {
    width: 100%; /* or any width you prefer */
    overflow: hidden; /* Hide scrollbar */
    resize: none; /* Disable manual resizing */
    min-height: 40px; /* Set a minimum height */
    }

    .table td:last-child {
    width: 60px; /* Set a fixed width for the last column */
    text-align: center; /* Center align the dropdown icon */
    position: relative; /* Position relative for dropdown */
    }
  
    .dropdown {
    display: inline-block; /* Ensure dropdown is inline with the icon */
    }
  
    .dropdown-menu {
    min-width: 100px; /* Adjust minimum width of the dropdown */
    z-index: 1000; /* Ensure dropdown appears above other elements */
    }
  
    .dropdown-toggle::after {
    display: none; /* Hide default dropdown arrow */
    }

</style>
<body>
    <div class="wrapper">

        <?php include '../sidebar/adminSidebar.php' ?>

        <div class="main">
            <nav class="navbar bg-body-secondary shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="adminDashboard.php">
                        <h2><i class="bi bi-chevron-left"></i></h2>
                    </a>
                </div>
            </nav>
            <div class="container my-3">
                <?php 
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    } elseif (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                ?>
            </div>
            <div class="row justify-content-center my-5">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Event Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="card mb-3">
                                <img src="<?= isset($event['event_banner']) && !empty($event['event_banner']) 
                                          ? '../uploads/eventBanner/' . htmlspecialchars($event['event_banner']) 
                                          : 'https://via.placeholder.com/400x200?text=Image+Not+Found' ?>" 
                                          class="card-img" alt="Event Image">
                            </div>
                            <h3 class="card-title text-primary fw-bold mb-3"><?= htmlspecialchars($event['event_name']) ?></h3>
                            <p><i class="bi bi-person mx-2"></i>Create by: <?= $eventCreatorName ?></p>
                            <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                            <p><i class="bi bi-calendar-check"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?></p>
                            <p><i class="bi bi-hourglass-top"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?></p>
                            <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($event['location']) ?></p>  
                            <p><i class="bi bi-tags"></i> <?= htmlspecialchars($event['price']) ?></p>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Participants</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Maximum Participant: <?= htmlspecialchars($event['participant_number']) ?></p>
                            <p class="card-text">Registered: <?= htmlspecialchars($event['registration']) ?></p>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Registered At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($participants)): ?>
                                            <tr>
                                                <td colspan="3">No participants found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($participants as $key => $participant): ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $participant['username'] ?></td>
                                                    <td><?= htmlspecialchars($participant['created_at']) ?></td>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <a class='link' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </a>
                                                            <ul class='dropdown-menu'>
                                                                <li><a class='dropdown-item' href='deleteRegisteredUser.php?id=<?= $participant['id'] ?>&eventId=<?= $eventId ?>' onclick='return confirm("Are you sure?");'>Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Edit Event</h3>
                        </div>
                        <div class="card-body">
                            <form action="editEvent.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="eventId" value="<?= $event['event_id'] ?>">
                                <div class="mb-3">
                                    <label for="eventName" class="form-label">Event Name</label>
                                    <input type="text" class="form-control" id="eventName" name="eventName" value="<?= $event['event_name'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" value="<?= $event['start_date'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" value="<?= $event['end_date'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="startTime" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="startTime" name="startTime" value="<?= $event['start_time'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="endTime" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="endTime" name="endTime" value="<?= $event['end_time'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" value="<?= $event['location'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" required><?= $event['description'] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="participantNumber" class="form-label">Max Participant</label>
                                    <input type="number" class="form-control" id="participantNumber" name="participantNumber" value="<?= $event['participant_number'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="eventBanner" class="form-label">Event Banner</label>
                                    <input type="file" class="form-control" id="eventBanner" name="eventBanner">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
        document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('description');

        function adjustHeight() {
            textarea.style.height = 'auto';
            textarea.style.height = `${textarea.scrollHeight}px`;
        }

        textarea.addEventListener('input', adjustHeight);
        
        adjustHeight();
    });
    </script>

</body>
</html>