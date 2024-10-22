<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
 
<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card p-5 shadow-lg col-12 col-sm-8 col-md-6 col-lg-4 rounded-3">
        <?php
        session_start(); 

        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); 
        }
        ?>
        <form action="loginProcess.php" method="post" class="text-left">
            <h1 class="text-center text-dark mb-4">Welcome Back!</h1>
            <p class="text-center text-muted mb-4">Please enter your email and password!</p>
            
            <!-- Email Label and Input -->
            <div class="form-group">
                <input type="email" name="email" class="form-control mb-4" placeholder="Enter your email" style="width: 70%; margin: 0 auto; border-radius:10px" required>
            </div>
            
            <!-- Password Label and Input -->
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter your password" style="width: 70%; margin: 0 auto; border-radius:10px" required>
            </div>

            <!-- Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a class="text-muted small" href="forgotPassword.php" style="margin-left: 70px">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning mb-3" style="border-radius:10px; width: 200px;">Log In</button>
            </div>


            <!-- Register Link -->
            <div class="text-center">
                <a href="register.php" class="text-secondary">Don't have an account?</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
