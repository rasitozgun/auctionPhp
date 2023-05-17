<?php
require_once 'top.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $starting_price = $_POST['starting_price'];
    $reserve_price = $_POST['reserve_price'];
    $end_time = $_POST['end_time'];

    if (empty($title) || empty($description) || empty($starting_price) || empty($reserve_price) || empty($end_time)) {
        $error = 'All fields are required';
    }

    if (!is_numeric($starting_price) || !is_numeric($reserve_price)) {
        $error = 'Starting price and reserve price must be numbers';
    }

    // Image upload
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_path = 'assets/' . $image_name;
    move_uploaded_file($image_tmp, $image_path);

    // Store auction details in the database
    if (!isset($error)) {
        $query = "INSERT INTO auctions (title, description, image, start_price, end_time,  reserve_price,  seller_id) VALUES ('$title', '$description', '$image_path', '$starting_price', '$end_time', '$reserve_price', '$user_id')";
        mysqli_query($conn, $query);
        header('Location: dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Auction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Your custom CSS styles can be added here */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #000;
    }

    .container {
        max-width: 800px;
        margin-top: 100px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background-color: rgba(255, 255, 255, 0.2);
    }

    .container h3 {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group label {
        font-size: 18px;
    }

    .form-group input,
    .form-group textarea {
        border-radius: 20px;
    }

    .btn-primary {
        border-radius: 20px;
        padding: 10px 30px;
        font-size: 18px;
        font-weight: bold;
        background-color: #1E8449;
        border-color: #1E8449;
    }

    .btn-primary:hover {
        background-color: #0B5345;
        border-color: #0B5345;
    }

    input {
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
    }

    textarea {
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
    }

    input[type="file"] {
        border-radius: 0;

    }
    </style>
</head>

<body>
    <div class="container">
        <h3>Create Auction</h3>
        <?php if (isset($error)) { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
        <div class="row">
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Starting Price:</label>
                        <input type="text" class="form-control" name="starting_price" required>
                    </div>
                    <div class="form-group">
                        <label>Reserve Price:</label>
                        <input type="text" class="form-control" name="reserve_price" required>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>End Time:</label>
                    <input type="datetime-local" class="form-control" name="end_time" required>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" class="form-control-file" name="image" accept="image/*" required>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Create Auction">
                </div>
                </form>
            </div>
        </div>
    </div>



</body>

</html>