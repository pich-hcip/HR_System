<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - HR System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="../../assets/images/login.jpg" alt="Login Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
                        </div>
                        <div class="col-md-6 p-4">
                            <h2 class="mb-4 text-center">HR - Login</h2>
                      
                            <form action="../../Action/login/loginController.php" method="POST" autocomplete="off">
                                <div class="mb-3">
                                    <label for="username">Username:</label>
                                    <input id="username" placeholder="Enter your name" class="form-control" type="text" name="username" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">Password:</label>
                                    <input id="password" type="password" name="password" placeholder="Enter your password" class="form-control" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input id="remember" type="checkbox" name="remember" class="form-check-input" >
                                    <label for="remember" class="form-check-label">Remember Me</label>
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>