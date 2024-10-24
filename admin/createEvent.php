<?php
    require '../config.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $eventName = trim($_POST['eventName']);
        $startDate = trim($_POST['startDate']);
        $endDate = trim($_POST['endDate']);
        $startTime = trim($_POST['startTime']);
        $endTime = trim($_POST['endTime']);
        $location = trim($_POST['location']);
        $description = trim($_POST['description']);
        $participantNumber = trim($_POST['participantNumber']);
        $price = trim($_POST['price']);
        $eventBanner = $_FILES['eventBanner']['name'];
        $tmp = $_FILES['eventBanner']['tmp_name'];
        $uploadDir = '../uploads/eventBanner/';
        $createdAt = date('Y-m-d H:i:s');
        $registrationValue=0;
        $availableSlot=0;

        if ($_FILES['eventBanner']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($tmp, $uploadDir . basename($eventBanner))) {
                $query = "INSERT INTO event (event_name, start_date, end_date, start_time, end_time, location, description, participant_number, price, event_banner, created_at ,registration,available_slot)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$eventName, $startDate, $endDate, $startTime, $endTime, $location, $description, $participantNumber, $price, $eventBanner, $createdAt, $registrationValue, $availableSlot]);

                $_SESSION['success'] = "Event created successfully!";
            } else {
                $_SESSION['error'] = "Failed to upload event banner.";
            }
        } else {
            $_SESSION['error'] = "Error during file upload. Code: " . $_FILES['eventBanner']['error'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../adminSidebar/style.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include '../adminSidebar/sidebar.php'; ?>

        <div class="main">
            <div class="container my-5 col-lg-6 col-md-8 col-sm-10">
                <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    } elseif (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                ?>
                <h1>Create Event</h1>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="mb-0">Event Details</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="createEvent.php" enctype="multipart/form-data" class="mb-0">
                            <div class="mb-3">
                                <label for="eventName" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="eventName" name="eventName" required>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="startTime" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="startTime" name="startTime" required>
                            </div>
                            <div class="mb-3">
                                <label for="endTime" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="endTime" name="endTime" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="participantNumber" class="form-label">Participant Number</label>
                                <input type="number" class="form-control" id="participantNumber" name="participantNumber" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventBanner" class="form-label">Event Banner</label>
                                <input type="file" class="form-control" id="eventBanner" name="eventBanner" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../adminSidebar/script.js"></script>
</body>
</html>
