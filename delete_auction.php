<?php

// Implement a system for users to delete their own auctions
require_once 'db.php';
require_once 'top.php';

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
    $deleteBidsQuery = "DELETE FROM bids WHERE auction_id = '$auction_id'";
    mysqli_query($conn, $deleteBidsQuery);

    $query = "DELETE FROM auctions WHERE id = '$auction_id'";
    mysqli_query($conn, $query);

    header('Location: manage_auctions.php');
    exit();
}

?>

<div class="container mt-5">
    <h1>Delete Auction</h1>

    <div class="alert alert-danger mt-4">
        <p>Are you sure you want to delete this auction?</p>
    </div>

    <form method="POST" class="mt-4">
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-danger">Yes</button>
            <a href="manage_auctions.php" class="btn btn-secondary">No</a>
        </div>
    </form>
</div>