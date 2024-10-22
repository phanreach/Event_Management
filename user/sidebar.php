<?php
require('config.php');
session_start();

if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit();
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User profile not found!";
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Side Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <style>
      body {
        overflow-x: hidden; /* Prevent horizontal scroll */
      }
      .sidebar {
        width: 250px;
        background-color: #202842;
      }
      .sidebar a {
        text-decoration: none;
        color: inherit;
      }
      .sidebar .nav-link {
        display: flex;
        align-items: center;
      }
      .sidebar .nav-link i {
        margin-right: 8px;
      }
    </style>
  </head>
  <body>
  <div class="d-flex">
    <!-- Sidebar -->
    <nav class="navbar navbar-expand-lg vh-100 flex-column p-3 sidebar">
      <!-- Profile Picture -->
      <a href="profileManagement.php">
      <img id="profilePreview" 
           src="<?= isset($user['profile_picture']) && !empty($user['profile_picture']) ? 'userprofile/' . htmlspecialchars($user['profile_picture']) : 'https://via.placeholder.com/100' ?>" 
           alt="Profile Photo" 
           class="rounded-circle mx-auto mb-3" 
           style="width: 100px; height: 100px; object-fit: cover">
      <h4 class="mb-3 text-center text-white"><?= htmlspecialchars($user['username']) ?></h4>
      </a>
      <hr>

      <!-- Sidebar Navigation -->
      <ul class="navbar-nav flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="#">
            <i class="bi bi-speedometer text-white"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="event.php" >
            <i class="bi bi-calendar-event text-white"></i>Event
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" aria-disabled="true" href="userManagement.php">
            <i class="bi bi-person text-white"></i>User Management
          </a>
        </li>
      </ul>

      <!-- Logout Button -->
      <a href="logout.php" class="btn btn-danger mt-2 text-white">Logout</a>
    </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
