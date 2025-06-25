<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $pizza_name = $_POST['pizza'];
    $price_each = (int)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $toppings = $_POST['toppings'] ?? [];

    $topping_text = "";
    $topping_total = 0;
    foreach ($toppings as $top) {
        list($topping_name, $topping_price) = explode("|", $top);
        $topping_text .= $topping_name . ", ";
        $topping_total += (int)$topping_price;
    }
    $topping_text = rtrim($topping_text, ", ");
    $subtotal = ($price_each + $topping_total) * $quantity;

    // Dapatkan nomor antrian terakhir hari ini
    $today = date('Y-m-d');
    $result = mysqli_query($conn, "SELECT MAX(no_antrian) as last_queue FROM orders WHERE DATE(created_at) = '$today'");
    $row = mysqli_fetch_assoc($result);
    $no_antrian = $row['last_queue'] ? $row['last_queue'] + 1 : 1;

    // Simpan ke database
    $sql = "INSERT INTO orders (customer_name, pizza_name, price_each, quantity, subtotal, toppings, no_antrian, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiiisi", $customer_name, $pizza_name, $price_each, $quantity, $subtotal, $topping_text, $no_antrian);
    mysqli_stmt_execute($stmt);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Pesanan Berhasil</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #fff8f0;
                margin: 0;
                padding: 40px;
            }

            .box {
                background-color: white;
                max-width: 600px;
                margin: auto;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            h2 {
                color: #27ae60;
                font-size: 26px;
                margin-bottom: 20px;
            }

            p {
                font-size: 16px;
                margin: 10px 0;
                color: #333;
            }

            .total {
                font-size: 20px;
                font-weight: bold;
                margin-top: 15px;
                color: #e67e22;
            }

            .queue {
                font-size: 30px;
                color: #c0392b;
                margin-top: 30px;
                font-weight: bold;
                letter-spacing: 2px;
            }

            .btn {
                display: inline-block;
                margin-top: 25px;
                background-color: #e67e22;
                color: white;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 8px;
                font-size: 16px;
                transition: background-color 0.3s ease;
            }

            .btn:hover {
                background-color: #d35400;
            }
        </style>
    </head>
    <body>

    <div class="box">
        <h2>🎉 Pesanan Berhasil!</h2>
        <p><strong>Nama:</strong> <?= htmlspecialchars($customer_name) ?></p>
        <p><strong>Pizza:</strong> <?= htmlspecialchars($pizza_name) ?></p>
        <p><strong>Harga Satuan:</strong> Rp <?= number_format($price_each, 0, ',', '.') ?></p>
        <p><strong>Jumlah:</strong> <?= $quantity ?></p>
        <p><strong>Topping:</strong> <?= $topping_text ?: '-' ?></p>
        <p class="total">Total Bayar: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
        <p class="queue">🧾 No. Antrian Anda: <?= $no_antrian ?></p>
        <a href="menu.php" class="btn">🔙 Kembali ke Menu</a>
    </div>

    </body>
    </html>

    <?php
} else {
    echo "Akses tidak valid.";
}
?>
