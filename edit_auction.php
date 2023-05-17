    <?php

    // Implement a system for users to edit their own auctions
    require_once 'top.php';

    if (isset($_GET['id'])) {
        $auction_id = $_GET['id'];
    
        // Get auction
        $query = "SELECT * FROM auctions WHERE id = '$auction_id' AND seller_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        
        
        if (mysqli_num_rows($result) != 1) {
            header('Location: manage_auctions.php');
            exit();
        }
    
        // Fetch the auction data
        $auction = mysqli_fetch_assoc($result);

        
    } else {
        header('Location: manage_auctions.php');
        exit();
    }


    if (mysqli_num_rows($result) != 1) {
        header('Location: manage_auctions.php');
        exit();
    }


    

    $errors = array();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $auction_id = $_POST['auction_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_price = $_POST['start_price'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $reserve_price = $_POST['reserve_price'];
    
        // Validate form data
        $errors = [];
    
        if (empty($title)) {
            $errors[] = "Title is required.";
        }
    
        if (empty($description)) {
            $errors[] = "Description is required.";
        }
    
        if (empty($start_price) || !is_numeric($start_price) || $start_price <= 0) {
            $errors[] = "Invalid start price.";
        }
    
        if (empty($start_time) || !strtotime($start_time)) {
            $errors[] = "Invalid start time.";
        }
    
        if (empty($end_time) || !strtotime($end_time)) {
            $errors[] = "Invalid end time.";
        }
    
        if (empty($reserve_price) || !is_numeric($reserve_price) || $reserve_price <= 0) {
            $errors[] = "Invalid reserve price.";
        }
    
        // If there are no validation errors, update the auction
        if (empty($errors)) {
            // Update the auction in the database (write the appropriate SQL update query here)
            // ...
    
            // Redirect the user to the manage_auctions.php page after successful update
            header('Location: manage_auctions.php');
            exit();
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Auction</title>
    </head>

    <body>
        <div class="container mt-5">
            <h1>Edit Auction</h1>
            <form method="POST" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="auction_id" value="<?php echo $auction['id']; ?>">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $auction['title']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description"
                        required><?php echo $auction['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control-file" name="image">
                </div>

                <div class="form-group">
                    <label>Start Price</label>
                    <input type="number" class="form-control" name="start_price"
                        value="<?php echo $auction['start_price']; ?>" required>
                </div>


                <div class="form-group">
                    <label>End Time</label>
                    <input type="datetime-local" class="form-control" name="end_time"
                        value="<?php echo date('Y-m-d\TH:i', strtotime($auction['end_time'])); ?>" required>
                </div>

                <div class="form-group">
                    <label>Reserve Price</label>
                    <input type="number" class="form-control" name="reserve_price"
                        value="<?php echo $auction['reserve_price']; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Auction</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>