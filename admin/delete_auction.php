<?php
// Veritabanı bağlantısı ve diğer gerekli ayarlar
require_once 'db.php';
// Gelen auction_id parametresini kontrol etme
if (isset($_GET['auction_id'])) {
    $auction_id = $_GET['auction_id'];

    // Bağımlı kayıtları ("bids" tablosundaki ilgili satırları) silme
    $sql_bids = "DELETE FROM bids WHERE auction_id = $auction_id";
    if ($conn->query($sql_bids) === TRUE) {
        // Bağımlı kayıtlar başarıyla silindiğinde, açık artırmayı silme
        $sql_auction = "DELETE FROM auctions WHERE id = $auction_id";
        if ($conn->query($sql_auction) === TRUE) {
            // Başarılı bir şekilde silindiğinde yapılacak işlemler
            header('Location: deleted_success.php');
        } else {
            // Silme işlemi sırasında hata oluştuğunda yapılacak işlemler
            echo "Error deleting auction: " . $conn->error;
        }
    } else {
        // Bağımlı kayıtları silme işlemi sırasında hata oluştuğunda yapılacak işlemler
        echo "Error deleting bids: " . $conn->error;
    }
} else {
    header('Location: tables.php');
    exit();
}
// Veritabanı bağlantısını kapatma ve diğer gerekli temizlemeler

?>