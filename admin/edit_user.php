<?php 

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $edit_username = $_POST['edit_username'];
    $edit_email = $_POST['edit_email'];
    $edit_password = $_POST['edit_password'];

    // Kullanıcıyı güncelleme
    $hashed_password = password_hash($edit_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$edit_username', email='$edit_email', password='$hashed_password' WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Başarılı bir şekilde güncellendiğinde yapılacak işlemler
        header("Refresh: 0.1; url=user_management.php"); // Kullanıcıyı yönlendirilecek sayfaya göre güncelleyin
        exit();
    } else {
        // Hata durumunda yapılacak işlemler
        echo "Hata: " . $conn->error;
    }
}


?>