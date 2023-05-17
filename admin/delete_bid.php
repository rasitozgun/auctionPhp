<?php
// Veritabanı bağlantısı ve diğer gerekli ayarlar
require_once 'db.php';
// Gelen auction_id parametresini kontrol etme
if (isset($_GET['bid_id'])) {
    $bid_id = $_GET['bid_id'];

    // Bağımlı kayıtları ("bids" tablosundaki ilgili satırları) silme
    $sql = "DELETE FROM bids WHERE id = '$bid_id'";

if ($conn->query($sql) === TRUE) {
    header('Location: deleted_bid.php');
} else {
    echo "Hata: " . $conn->error;
}
} else {
    header('Location: tables.php');
    exit();
}
// Veritabanı bağlantısını kapatma ve diğer gerekli temizlemeler

?>