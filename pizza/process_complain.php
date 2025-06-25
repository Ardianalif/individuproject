<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    $stmt = $conn->prepare("INSERT INTO complaints (customer_name, order_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $customer_name, $order_id, $message);

    if ($stmt->execute()) {
        echo "<h2 style='color: green;'>✅ Komplain berhasil dikirim!</h2>";
        echo "<a href='index.php' style='text-decoration:none;color:#2980b9;'>← Kembali ke Beranda</a>";
    } else {
        echo "❌ Gagal menyimpan komplain: " . $stmt->error;
    }
} else {
    echo "Akses tidak valid.";
}
?>
