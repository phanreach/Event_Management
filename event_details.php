<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .event-header {
            background-size: cover;
            background-position: center;
            height: 300px;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 10px 10px 0 0; /* Optional: rounded corners */
            margin-bottom: -20px; /* Adjust spacing */
        }
        .event-header h1 {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .event-details {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }
        .event-details .event-meta {
            margin-bottom: 20px;
        }
        
        .ticket-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 70px;
            border-radius: 5px;
            text-decoration: none;
        }
        .ticket-btn:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <?php
        require 'config.php';
        $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

        if ($event_id > 0) {
            $query = "SELECT * FROM event WHERE event_id = :event_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($event) {
        ?>
                <!-- Event Header -->
                <div class="event-header" style="background-image: url('<?php echo htmlspecialchars($event['image']); ?>');">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Event Image" style="display: none;">
                    <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
                </div>

                <!-- Event Details -->
                <div class="container event-details">
                    <div class="event-meta">
                        <div class="row">
                        <!-- Date and Time -->
                        <div class="col-md-3">
                            <p style="font-size: 14px;"><i class="fa fa-calendar"></i> <?= date('M j, Y', strtotime($event['start_date'])) . ' - ' . date('M j, Y', strtotime($event['end_date'])); ?>
                            <p style="font-size: 14px;"><i class="fa fa-clock"></i> <?= date('ga', strtotime($event['start_time'])) . ' - ' . date('ga', strtotime($event['end_time'])); ?>
                            <p style="font-size: 14px;"><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?>
                        </div>
                        <!-- Participants and Price -->
                        <div class="col-md-3">
                            <p style="font-size: 13px;"><i class="fa fa-user me-1"></i><?= htmlspecialchars($event['participant_number']); ?>
                            <p style="font-size: 13px;"><strong>Price:</strong> <?= htmlspecialchars($event['price']); ?>
                        </div>
                        <div class="col-md-4">
                        <div class="col d-flex justify-content-end">
                        <a href="registerEvent.php?id=<?php echo htmlspecialchars($event['event_id']); ?>" class="ticket-btn">Register</a>            
                        </div>
                        </div>
                        </div>
                    </div>
                        <div class="row mb-3"></div>
                        <p style="font-size: 24px;"><strong>Details</strong>
                        <div class="row"></div>
                        <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                        <a href="userDashboard.php" class="btn btn-secondary">Back to Events</a>
                    </div>  
                </div>
        <?php 
            } else {
                echo "<p class='error-message'>Event not found. Please check the event ID.</p>";
            }
        } else {
            echo "<p class='error-message'>Invalid event ID. <a href='user_dashboard.php'>Return to Events</a></p>";
        }
        ?>
    </div>
</body>
</html>