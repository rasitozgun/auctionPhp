<?php

// Implement a system for users to delete their own auctions
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header('Location: manage_auctions.php');
    exit();
}

$auction_id = $_GET['id'];

// Get auction
$query = "SELECT * FROM auctions WHERE id = '$auction_id' AND seller_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1) {
    header('Location: manage_auctions.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete auction
    $query = "DELETE FROM auctions WHERE id = '$auction_id'";
    mysqli_query($conn, $query);

    header('Location: manage_auctions.php');
    exit();
}

?>

<h1>Delete Auction</h1>

<p>Are you sure you want to delete this auction?</p>

<form method="post">
    <div>
        <button type="submit">Yes</button>
        <a href="manage_auctions.php">No</a>
    </div>
</form>