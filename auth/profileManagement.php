<?php
require '../config.php';
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User profile not found!";
    exit();
}

// Update user profile on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $hashedPassword = ''; // Initialize to avoid undefined variable error

    // Start building the update query
    $updates = [];
    $params = [];

    // Update username and email if they're not empty
    if (!empty($username)) {
        $updates[] = "username = ?";
        $params[] = htmlspecialchars($username); // Sanitize user input
    }
    if (!empty($email)) {
        $updates[] = "email = ?";
        $params[] = filter_var($email, FILTER_VALIDATE_EMAIL); // Validate and sanitize email
    }

    // Handle password change
    if (!empty($_POST['password'])) {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updates[] = "password = ?";
        $params[] = $hashedPassword;
    }

    // Execute the update query if there are updates
    if (!empty($updates)) {
        $updateQuery = "UPDATE user SET " . implode(", ", $updates) . " WHERE id = ?";
        $params[] = $id; 
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute($params);
    }

    // Fetch updated user data after the changes
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Redirect to the profile management page after update
    header("Location: profileManagement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../adminSidebar/style.css" rel="stylesheet">
    <link href="../userSidebar/style.css" rel="stylesheet">

</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php
        // Check if the user is an admin or a regular user and load the respective sidebar
        if ($_SESSION['role'] == 'admin') {
            include '../adminSidebar/sidebar.php';
        } else {
            include '../userSidebar/sidebar.php';
        }
        ?>        
        
        <!-- Main Content Area -->
        <div class="main">
            <div class="container mt-5 col-md-6">
                <div class="card p-4 shadow-sm">
                    <div class="d-flex align-items-center">
                        <img id="profilePreview" 
                        src="<?= isset($user['profile_picture']) && !empty($user['profile_picture']) ? 'userprofile/' . htmlspecialchars($user['profile_picture']) : 'https://via.placeholder.com/100' ?>" 
                        alt="Profile Photo" 
                        class="rounded-circle me-4" 
                        style="width: 100px; height: 100px; object-fit: cover">
                        <div>
                            <h4 class="mb-1 fw-bold"><?= htmlspecialchars($user['username']) ?></h4>
                            <h4 class="mb-1 fs-6 text-muted"><?= htmlspecialchars($user['role']) ?></h4>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#changeProfile">
                                Change Photo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Display alerts if any -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success mt-3"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger mt-3"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>

                <!-- Profile Info Card -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">Profile info</h5>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            Edit Info
                        </button>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Username</h6>
                            <p class="text-muted mb-0"><?= htmlspecialchars($user['username']) ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Email</h6>
                            <p class="text-muted mb-0"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Password</h6>
                            <p class="text-muted mb-0">*******</p>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Profile Picture -->
    <div class="modal fade" id="changeProfile" tabindex="-1" aria-labelledby="changeProfileLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Profile Info -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="profileManagement.php" method="post">
                        <div class="mb-3">
                            <label for="usernameInput" class="form-label">Username</label>
                            <input type="text" class="form-control" id="usernameInput" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailInput" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter new password">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Sidebar Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../adminSidebar/script.js"></script>
    <script src="../userSidebar/script.js"></script>
</body>
</html>
