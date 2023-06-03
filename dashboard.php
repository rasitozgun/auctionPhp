<?php

// Develop a personalized user dashboard where users can view their active bids, won auctions, and manage their account settings
require_once 'top.php';

// Get user information
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Get active bids  
$bid_query = "SELECT a.id AS auction_id, a.title, b.amount, a.end_time
FROM auctions AS a
JOIN bids AS b ON a.id = b.auction_id
WHERE b.bidder_id = $user_id AND b.status = 1
ORDER BY b.amount DESC";
$bid_result = mysqli_query($conn, $bid_query);

// Get won auctions
$won_query = "SELECT a.title, a.description, a.start_price, a.end_time, b.amount
FROM auctions AS a
INNER JOIN bids AS b ON a.id = b.auction_id
WHERE a.winner_id = $user_id AND b.status = 1 AND b.amount = (
   SELECT MAX(amount)
   FROM bids
   WHERE auction_id = a.id
)";
$won_result = mysqli_query($conn, $won_query);

?>
<style>
.container {
    margin-top: 50px;
}

.bid,
.auction {
    margin-bottom: 20px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
}
</style>
</head>

<body>

    <div class="container">
        <h1>Welcome, <?php echo $user['username']; ?></h1>

        <?php if(mysqli_num_rows($bid_result) > 0): ?>
        <h2>Active Bids</h2>

        <?php while($bid = mysqli_fetch_assoc($bid_result)): ?>
        <div class="bid">
            <a href="place_bid.php?auction_id=<?php echo $bid['auction_id']; ?>">
                <h3><?php echo $bid['title']; ?></h3>
                <?php echo "</a>"?>
                <p>Current Bid: $<?php echo $bid['amount']; ?></p>
                <p>Ends: <?php echo $bid['end_time']; ?></p>
            </a>
        </div>
        <?php endwhile; ?>

        <?php else: ?>
        <h2>You have no active bids.</h2>
        <?php endif; ?>

        <?php if(mysqli_num_rows($won_result) > 0): ?>
        <h2>Won Auctions</h2>

        <?php while($auction = mysqli_fetch_assoc($won_result)): ?>
        <div class="auction">
            <h3><?php echo $auction['title']; ?></h3>
            <p>Description: <?php echo $auction['description']; ?></p>
            <p>Start Price: $<?php echo $auction['start_price']; ?></p>
            <p>Ends: <?php echo $auction['end_time']; ?></p>
            <p>Highest Bid: $<?php echo $auction['amount']; ?></p>
        </div>
        <?php endwhile; ?>

        <?php else: ?>
        <h2>No won auctions.</h2>
        <?php endif; ?>

        <h2 class="mt-5">Account Settings</h2>


        <form action="update_account.php" method="post">
           
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="w-50 form-control" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="w-50 form-control" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="w-50 form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary mb-5">Update</button>
            <a href="logout.php" class="btn btn-primary mb-5">Logout</a>
        </form>

    </div>
    <?php 
    include 'footer.php'
    ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>