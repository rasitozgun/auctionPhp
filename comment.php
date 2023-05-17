<?php

$auctionId = $_SESSION["auction_id"];


// Comment form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    // Get the username, comment, and auction ID from the form
    $username = $_SESSION["username"];
    $comment = $_POST["comment"];
    
    
    // Insert the comment into the database
    $insertQuery = "INSERT INTO comments (username, comment, comment_time, auction_id)
                    VALUES ('$username', '$comment', NOW(), $auctionId)";
    mysqli_query($conn, $insertQuery);

    header("Location: place_bid.php?auction_id=$auctionId");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_comment"])) {
    $commentId = $_POST["comment_id"];
    $deleteQuery = "DELETE FROM comments WHERE id = $commentId";
    mysqli_query($conn, $deleteQuery);
    header("Location: place_bid.php?auction_id=$auctionId");

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-5">Leave a Comment</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            </div>
            <input type="hidden" name="auction_id" value="<?php echo $auctionId; ?>">
            <button type="submit" class="btn btn-primary" name="submit_comment">Submit</button>
        </form>

        <h2 class="mt-5">Comments</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Comment</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve comments for the specific auction from the database
                $selectQuery = "SELECT * FROM comments WHERE auction_id = $auctionId ORDER BY comment_time DESC";
                $result = mysqli_query($conn, $selectQuery);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row["username"] . '</td>';
                    echo '<td>' . $row["comment"] . '</td>';
                    echo '<td>' . $row["comment_time"] . '</td>';
                if ($row["username"] == $username) {
                    echo '<td>';
                    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                    echo '<input type="hidden" name="comment_id" value="' . $row["id"] . '">';
                    echo '<button type="submit" class="btn btn-sm btn-danger" name="delete_comment">Delete</button>';
                    echo '</form>';
                    }
                    echo '</td>';
                    echo '</tr>';
        
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>

</html>