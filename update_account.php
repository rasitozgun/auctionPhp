<?php

// Implement a system for users to edit their account information and update it in the database
require_once 'top.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($email)) {
        $error = 'Please fill in all required fields.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Update user information
        $query = "UPDATE users SET username = '$username', email = '$email'";
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password_hash = '$password_hash'";
        }
        $query .= " WHERE id = '$user_id'";
        mysqli_query($conn, $query);

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
    }
}

// Get user information
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>

<h1>Update Account Information</h1>

<?php if (isset($error)) { ?>
<p><?php echo $error; ?></p>
<?php } ?>

<form action="update_account.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>">
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password">
    <br>
    <input type="submit" value="Update">
</form>