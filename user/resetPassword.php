<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card p-5 shadow-lg col-12 col-sm-8 col-md-6 col-lg-4 rounded-3">
        <h1 class="text-center">Reset Password</h1>

        <?php
        if (!isset($_GET['token'])) {
            echo "Invalid token.";
            exit;
        }
        ?>

        <form action="resetPasswordProcess.php" method="post">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="form-group">
                <input type="password" name="new_password" class="form-control mb-4" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control mb-4" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-warning btn-block">Reset Password</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
