<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        /* Header image section */
        .event-header {
            background-image: url('<?php echo htmlspecialchars($event['name']); ?>');
            background-size: cover;
            background-position: center;
            height: 300px;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .event-header h1 {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        /* Event information card */
        .event-details {
            margin-top: -100px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }
        /* Date, location, and ticket button styling */
        .event-details .event-meta {
            margin-bottom: 20px;
            font-size: 1.1em;
        }
        .event-details .event-meta strong {
            color: #007bff;
        }
        .event-details .description {
            font-size: 1.1em;
            margin-bottom: 30px;
        }
        .ticket-btn {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 5px;
            text-decoration: none;
        }
        .ticket-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <!-- Event Header -->
    <div class="event-header">
        <h1><?php echo htmlspecialchars($event['name']); ?></h1>
    </div>

    <!-- Event Details -->
    <div class="container event-details">
        <div class="event-meta">
            <p><strong>Date:</strong> <?php echo date('F j, Y, g:i A', strtotime($event['event_date'])); ?></p>
            <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['time'])); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            <p><strong>Available Slot:</strong> <?php echo htmlspecialchars($event['avaible_slots']); ?></p>
        </div>
        <div class="description">
            <?php echo htmlspecialchars($event['description']); ?>
        </div>
        <a href="register_event.php?id=<?php echo $event['event_id']; ?>" class="ticket-btn">Register</a>
    </div>
</div>

</body>
</html>

