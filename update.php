<?php
// Include the database connection file
require_once 'top.php';

// Check if the auction ID is provided
if (isset($_POST['auction_id'])) {
    $auction_id = $_POST['auction_id'];

    // Retrieve the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_price = $_POST['start_price'];
    $end_time = $_POST['end_time'];
    $reserve_price = $_POST['reserve_price'];

    // Update the auction in the database
    $updateQuery = "UPDATE auctions SET 
        title = '$title',
        description = '$description',
        start_price = '$start_price',
        end_time = '$end_time',
        reserve_price = '$reserve_price'
        WHERE id = '$auction_id'";

    if (mysqli_query($conn, $updateQuery)) {
        // Auction updated successfully
        header('Location: manage_auctions.php');
        exit();
    } else {
        // Error updating auction
        $error = "Error updating auction: " . mysqli_error($conn);
    }
} else {
    // Invalid auction ID
    header('Location: manage_auctions.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Auction</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Update Auction</h1>
        <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } else { ?>
        <div class="alert alert-success">Auction updated successfully!</div>
        <?php } ?>
        <a href="manage_auctions.php" class="btn btn-primary">Go Back</a>
    </div>
</body>

</html>