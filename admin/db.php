<?php 

$host = "localhost";
$password = "1649";
$dbname ="auctiondb";
$username = "rasit";

$conn = mysqli_connect($host,$username,$password,$dbname,3306);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$currentDateTime = date('Y-m-d H:i:s');
$sql = "UPDATE auctions a
        SET a.winner_id = (
            SELECT b.bidder_id
            FROM bids b
            WHERE b.auction_id = a.id
            ORDER BY b.amount DESC
            LIMIT 1
        )
        WHERE a.end_time <= '$currentDateTime' AND a.winner_id = 0";

        if ($conn->query($sql) === TRUE) {
            // Success, the winner_id has been updated for ended auctions
        } else {
            // Error updating winner_id
        }
        

?>