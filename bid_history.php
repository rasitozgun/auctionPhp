<?php

// Implement a system for users to view their bid history and won auctions
require_once 'top.php';

// Get bid history
$query = "SELECT auctions.title, auctions.description, auctions.start_price, auctions.reserve_price, bids.amount, bids.bid_time FROM auctions JOIN bids ON auctions.id = bids.auction_id WHERE bids.bidder_id = '$user_id' ORDER BY bids.bid_time DESC";
$result = mysqli_query($conn, $query);

// Get won auctions
$query = "SELECT auctions.title, auctions.description, auctions.start_price, auctions.reserve_price, bids.amount, bids.bid_time FROM auctions JOIN bids ON auctions.id = bids.auction_id WHERE bids.bidder_id = '$user_id' AND bids.amount >= auctions.reserve_price ORDER BY bids.bid_time DESC";
$won_result = mysqli_query($conn, $query);

?>

<body>
    <div class="container">
        <h1>Bid History</h1>

        <h2>Active Bids</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Starting Price</th>
                    <th>Reserve Price</th>
                    <th>Amount</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['start_price']; ?></td>
                    <td><?php echo $row['reserve_price']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['bid_time']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>You have no active bids.</p>
        <?php } ?>

        <h2>Won Auctions</h2>

        <?php if (mysqli_num_rows($won_result) > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Starting Price</th>
                    <th>Reserve Price</th>
                    <th>Amount</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($won_result)) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['start_price']; ?></td>
                    <td><?php echo $row['reserve_price']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>You have not won any auctions.</p>
        <?php } ?>
    </div>
</body>

</html>