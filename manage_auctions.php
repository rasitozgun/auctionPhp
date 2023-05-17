<?php
// Implement a system for users to manage their own auctions
require_once 'top.php';

// Get auctions
$query = "SELECT * FROM auctions WHERE seller_id = '$user_id' ORDER BY end_time DESC";
$result = mysqli_query($conn, $query);
?>

<h1>Manage Auctions</h1>

<?php if (mysqli_num_rows($result) > 0) { ?>
<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Starting Price</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['start_price']; ?></td>
            <td><?php echo $row['end_time']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="edit_auction.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="delete_auction.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } else { ?>
<p>You have no auctions.</p>
<?php } ?>