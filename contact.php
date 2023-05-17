<?php 
require_once 'top.php';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {


    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert the form data into the database
    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "Form submission successful!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Error: Please fill in all the required fields.";
}
?>

<div class="container py-4">
    <?php if (isset($successMessage)) : ?>
    <div class="alert alert-success">
        <?php echo $successMessage; ?>
    </div>
    <?php elseif (isset($errorMessage)) : ?>
    <div class="alert alert-danger">
        <?php echo $errorMessage; ?>
    </div>
    <?php endif; ?>
    <!-- Bootstrap 5 starter form -->
    <form id="contactForm" method="POST" data-sb-form-api-token="API_TOKEN">
        <h2>Contact Us</h2>
        <!-- Name input -->
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input class="form-control" id="name" name="name" type="text" placeholder="Name" required>
        </div>

        <!-- Email address input -->
        <div class="mb-3">
            <label class="form-label" for="emailAddress">Email Address</label>
            <input class="form-control" id="emailAddress" name="email" type="email" placeholder="Email Address"
                required>
        </div>

        <!-- Message input -->
        <div class="mb-3">
            <label class="form-label" for="message">Message</label>
            <textarea class="form-control" id="message" name="message" placeholder="Message" style="height: 10rem;"
                required></textarea>
        </div>

        <!-- Form submit button -->
        <div class="d-grid">
            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
        </div>
    </form>

</div>

<!-- SB Forms JS -->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>



<?php 
    include 'footer.php'
    ?>