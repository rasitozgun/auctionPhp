<?php
require_once 'db.php';

// Implement search functionality to allow users to search for specific auctions based on keywords, categories, or other criteria
$query = "SELECT * FROM auctions WHERE title LIKE '%{$_GET['q']}%' OR description LIKE '%{$_GET['q']}%'";



$result = mysqli_query($conn, $query);

while ($auction = mysqli_fetch_assoc($result)) {
    $highest_bid_query = "SELECT MAX(amount) AS amount FROM bids WHERE auction_id = '{$auction['id']}'";
    $highest_bid_result = mysqli_query($conn, $highest_bid_query);
    $highest_bid = mysqli_fetch_assoc($highest_bid_result);
    
    echo '<div class="auction">';
    echo '<h3>' . $auction['title'] . '</h3>';
    echo '<p>' . $auction['description'] . '</p>';
    echo '<p>Starting Price: $' . $auction['start_price'] . '</p>';
    echo '<p>Reserve Price: $' . $auction['reserve_price'] . '</p>';
    echo '<p>Highest Bid: $' . $highest_bid['amount'] . '</p>';
    echo '<p>Ends: ' . $auction['end_time'] . '</p>';
    echo '<a href="auction.php?id=' . $auction['id'] . '">View</a>';
    echo '</div>';
}

?>