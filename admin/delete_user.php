<?php 


require_once 'db.php';



if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kullanıcıyı silme
    $sql = "DELETE FROM users WHERE id='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Başarılı bir şekilde silindiğinde yapılacak işlemler
        header("Refresh: 0.1; url=user_management.php"); // Kullanıcıyı yönlendirilecek sayfaya göre güncelleyin
        exit();
    } else {
        // Hata durumunda yapılacak işlemler
        echo "Hata: " . $conn->error;
    }
}



?>