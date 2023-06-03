<?php
require_once 'top.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Initialize variables
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($email)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Update user information
        $query = "UPDATE users SET username = '$username', email = '$email'";
        
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = '$password_hash'";
        }
        
        $query .= " WHERE id = $user_id";
        
        mysqli_query($conn, $query);

        // Redirect to dashboard
        header("Refresh: 0.1; url=dashboard.php");
        exit();
    }
}

