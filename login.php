<?php

session_start();
require_once 'db.php';

// Authenticate user credentials against the stored information in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        margin-top: 100px;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 40px;
    }

    .card-title {
        font-size: 24px;
        font-weight: 600;
        color: #155724;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-group label {
        font-weight: 500;
        color: #155724;
    }

    .form-control {
        border-color: #28a745;
        border-radius: 4px;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-primary:hover {
        background-color: #218838;
        border-color: #218838;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Login</h4>
                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="username" name="username" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>

            </div>

        </div>
    </div>
</body>

</html>