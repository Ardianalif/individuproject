<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Komplain Pelanggan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2 class="title">📝 Form Komplain Pelanggan</h2>

        <form action="process_complain.php" method="POST" class="complain-form">
            <label for="customer_name">Nama Customer:</label>
            <input type="text" name="customer_name" id="customer_name" required>

            <label for="order_id">ID Pesanan (jika ada):</label>
            <input type="text" name="order_id" id="order_id">

            <label for="message">Isi Komplain:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit" class="complain-button">Kirim Komplain</button>
        </form>

        <a href="index.php" class="back-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>
