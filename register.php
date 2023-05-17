<?php
require_once 'db.php';

// Validate user input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if username and email are unique
    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error = 'Username or email already exists';
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    }

    // Store user information securely in the MySQL database
    if (!isset($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        mysqli_query($conn, $query);
        header('Location: login.php');
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Your custom CSS styles can be added here */
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
                <h4 class="card-title">Register</h4>
                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Password:</label>
                        <input class="form-control" type="password" name="confirm_password" id="password" required>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Register</button>
                </form>
                <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
            </div>

        </div>
    </div>
</body>


</html>