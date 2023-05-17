<?php
// Connect to the database
require_once 'db.php';

// SQL query to update the winner
$updateWinnerSql = "UPDATE auctions
                    SET winner_id = (
                        SELECT bidder_id
                        FROM bids
                        WHERE auction_id = auctions.id
                        ORDER BY amount DESC
                        LIMIT 1
                    )
                    WHERE status = 1 AND winner_id = 0 AND end_time < NOW()";


                    
$result = mysqli_query($conn, $updateWinnerSql);




$updateStatusSql = "UPDATE auctions
                    SET status = 0
                    WHERE status = 1 AND winner_id != 0";

$updateResult = mysqli_query($conn, $updateStatusSql);
 
// Close the database connection

?>