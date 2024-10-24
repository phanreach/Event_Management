<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>    
        .form-group input {
            border-radius: 10px;
        }

        .btn-warning {
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center form-container" style="min-height:100vh">
        <div class="card shadow-lg p-5 col-12 col-md-8 col-lg-6 col-xl-5 rounded-3">
            
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

                <div class="form-group">
                    <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <div class="text-center mb-3">
                    <a class="text-muted small" href="forgotPassword.php">Forgot password?</a>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning btn-block">Log In</button>
                </div>

                <div class="text-center mt-3">
                    <a href="register.php" class="text-secondary">Don't have an account?</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
