<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card p-5 shadow-lg col-12 col-sm-8 col-md-6 col-lg-4 rounded-3">
        <h1 class="text-center">Forgot Password</h1>
        <p class="text-muted text-center mb-4">Enter your email to reset your password.</p>

        <form action="forgotPasswordProcess.php" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control mb-4" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-warning btn-block mb-4">Send Reset Link</button>
        </form>
        <div class="text-center">
                <a href="login.php" class="text-secondary">Don't have an account?</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
