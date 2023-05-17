<?php 
require_once 'top.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Bid</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .card-img-top {
        max-height: 300px;
        object-fit: cover;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-4 mb-5">Place Bid</h1>

        <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["place_bid"])) {
        // Place bid logic
        $auctionId = $_POST["auction_id"];
        $bidAmount = $_POST["bid_amount"];
        $bidderId = $user_id; // Replace with the actual bidder's ID
    
        // Check if the bid amount is greater than the current highest bid
        $checkQuery = "SELECT start_price, reserve_price, MAX(amount) AS highest_bid
                       FROM auctions AS a
                       LEFT JOIN bids AS b ON a.id = b.auction_id
                       WHERE a.id = $auctionId";
        $checkResult = mysqli_query($conn, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
    
        $startPrice = $row["start_price"];
        $reservePrice = $row["reserve_price"];
        $highestBid = $row["highest_bid"];
    
        if ($bidAmount < $startPrice) {
            echo '<div class="alert alert-danger" role="alert">
                    Your bid amount is less than the starting price.
                  </div>';
        } elseif ($bidAmount <= $highestBid) {
            echo '<div class="alert alert-danger" role="alert">
                    Your bid amount is not higher than the current highest bid.
                  </div>';
        } elseif ($bidAmount >= $reservePrice) {
            echo '<div class="alert alert-success" role="alert">
                    Congratulations! You placed a bid higher than the reserve price.
                  </div>';
            // Update the auction's winner and status
            $updateQuery = "UPDATE auctions
                            SET winner_id = $bidderId, status = 0
                            WHERE id = $auctionId";
            mysqli_query($conn, $updateQuery);
    
            // Insert the bid into the database
            $insertQuery = "INSERT INTO bids (amount, bidder_id, auction_id, bid_time, status)
                            VALUES ($bidAmount, $bidderId, $auctionId, NOW(), 1)";
            mysqli_query($conn, $insertQuery);
        } else {
            echo '<div class="alert alert-success" role="alert">
                    Your bid has been placed successfully.
                  </div>';
    
            // Insert the bid into the database
            $insertQuery = "INSERT INTO bids (amount, bidder_id, auction_id, bid_time)
                            VALUES ($bidAmount, $bidderId, $auctionId, NOW())";
            mysqli_query($conn, $insertQuery);

            $updateStatusQueryFirst = "UPDATE bids SET status = 0 WHERE auction_id = $auctionId AND bidder_id != $bidderId";
            mysqli_query($conn, $updateStatusQueryFirst);

            $updateStatusQuery = "UPDATE bids SET status = 0 WHERE auction_id = $auctionId AND bidder_id = $bidderId AND id <> LAST_INSERT_ID()";
            mysqli_query($conn, $updateStatusQuery);

            
        }
    }
     elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["auction_id"])) {
            $auctionId = $_GET["auction_id"];
            $_SESSION["auction_id"] = $auctionId;
            // Fetch the auction details
            $auctionQuery = "SELECT *
                             FROM auctions
                             WHERE id = $auctionId";
            $auctionResult = mysqli_query($conn, $auctionQuery);
            $auctionRow = mysqli_fetch_assoc($auctionResult);

            if($auctionRow['status'] == 0){
                header("Location: index.php");
            }

            if ($auctionRow) {
                echo '<div class="card mb-4">';
                echo '<img src="' . $auctionRow["image"] . '" class="card-img-top" alt="Auction Image">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $auctionRow["title"] . '</h5>';
                echo '<p class="card-text">' . $auctionRow["description"] . '</p>';
                echo '<p class="card-text">Ends on: ' . $auctionRow["end_time"] . '</p>';
                echo '<p class="card-text">Reserve Price: $' . $auctionRow["reserve_price"] . '</p>';
                echo '<p class="card-text">Starting Price: $' . $auctionRow["start_price"] . '</p>';

                // Check if there are any bids for the auction
                $bidQuery = "SELECT b.amount, u.username
                             FROM bids AS b
                             INNER JOIN users AS u ON b.bidder_id = u.id
                             WHERE b.auction_id = $auctionId
                             ORDER BY b.amount DESC
                             LIMIT 1";
                $bidResult = mysqli_query($conn, $bidQuery);
                $bidRow = mysqli_fetch_assoc($bidResult);

                if ($bidRow) {
                    echo '<p class="card-text">Highest Bid: $' . $bidRow["amount"] . ' by ' . $bidRow["username"] . '</p>';
                } else {
                    echo '<p class="card-text">No bids yet.</p>';
                }

                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<input type="hidden" name="auction_id" value="' . $auctionId . '">';
                echo '<div class="form-group">';
                echo '<label for="bid_amount">Your Bid:</label>';
                echo '<input type="text" class="form-control" id="bid_amount" name="bid_amount" required>';
                echo '</div>';
                echo '<input type="hidden" name="place_bid" value="1">';    
                echo '<button type="submit" class="btn btn-primary">Place Bid</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Invalid auction ID.
                      </div>';
            }
    
          }
            ?>
        <?php 
    
    include_once 'comment.php';
    
    ?>

    </div>
    <?php 
    include 'footer.php'
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>