<?php 
require_once 'top.php';





?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    html{
        min-height: 100vh;
    }
    body {
        min-height: 100vh;
    }

    .card-text {
        display: inline-block;
    }

    .place-bid-btn {
        display: inline-block;
        margin-left: 10px;
        vertical-align: middle;
    }
</style>

<body>
    <div class="container d-flex flex-column min-vh-100">
        <h1 class="text-center mt-4 mb-5">Auction List</h1>
        <div class="row">
            <?php
       

       $query = "SELECT a.id AS auction_id, a.title, a.reserve_price, b.amount AS highest_bid, a.image, u.username AS highest_bidder
       FROM auctions AS a
       LEFT JOIN (
         SELECT auction_id, MAX(amount) AS amount
         FROM bids
         GROUP BY auction_id
       ) AS b ON a.id = b.auction_id
       LEFT JOIN bids AS bb ON bb.auction_id = a.id AND bb.amount = b.amount
       LEFT JOIN users AS u ON bb.bidder_id = u.id
       WHERE a.status = 1
       ORDER BY a.id";

        
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4" >';
                echo '<div class="card">';
                echo '<img src="' . $row['image'] . '" class="card-img-top" alt="Auction Image">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                
                echo '<p class="card-text mt-1">Reserve price: $' . $row['reserve_price'] . '</p>';
                if ($row['highest_bidder'] !== null) {
                    echo '<div class="row">';
                    echo '<div class="col">';
                    echo '<p class="card-text mt-1">Highest Bidder: ' . $row['highest_bidder'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="row">';
                    echo '<div class="col">';
                    echo '<p class="card-text ">No Bids Yet</p>';
                    echo '</div>';
                    echo '</div>';
                }
            
                if ($row['highest_bid'] !== null) {
                    echo '<div class="row">';
                    echo '<div class="col">';
                    echo '<p class="card-text mt-2">Highest Bid: $' . $row['highest_bid'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            
                
                echo '<a href="place_bid.php?auction_id=' . $row['auction_id'] . '" class="btn btn-primary mt-2">Place Bid</a>';
               
            
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            


            mysqli_close($conn);
            ?>
        </div>
    </div>
    <?php
  include('footer.php');
?>
</body>

</html>