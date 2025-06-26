<?php
// Include database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_pizzza";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the order form submission
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $pizza_name = mysqli_real_escape_string($conn, $_POST['pizza']);
    $price_each = (int)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $toppings = $_POST['toppings'] ?? [];

    $topping_text = "";
    $topping_total = 0;
    foreach ($toppings as $top) {
        list($topping_name, $topping_price) = explode("|", $top);
        $topping_text .= mysqli_real_escape_string($conn, $topping_name) . ", ";
        $topping_total += (int)$topping_price;
    }
    $topping_text = rtrim($topping_text, ", ");
    $subtotal = ($price_each + $topping_total) * $quantity;
    $order_time = date('Y-m-d H:i:s');

    // Save to database
    $sql = "INSERT INTO orders (customer_name, pizza_name, price_each, quantity, subtotal, order_time, toppings) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiisss", $customer_name, $pizza_name, $price_each, $quantity, $subtotal, $order_time, $topping_text);
    
    if (mysqli_stmt_execute($stmt)) {
        // Get the inserted order ID
        $order_id = mysqli_insert_id($conn);
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
            <p><strong>Topping:</strong> <?= $topping_text ? htmlspecialchars($topping_text) : '-' ?></p>
            <p class="total">Total Bayar: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
            <p class="queue">📝 ID Pesanan: <?= $order_id ?></p>
            <a href="menu.php" class="btn">🔙 Kembali ke Menu</a>
            <a href="complaint.php?order_id=<?= $order_id ?>" class="btn" style="background-color: #e74c3c; margin-left: 10px;">📢 Laporkan Masalah</a>
        </div>

        </body>
        </html>

        <?php
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
} else {
    // Display the order form
    $pizza = isset($_GET['pizza']) ? htmlspecialchars($_GET['pizza']) : '';
    $price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '';
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Form Pemesanan Pizza</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #fff8f0;
                margin: 0;
                padding: 20px;
            }

            .order-form {
                background-color: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                padding: 30px;
                max-width: 500px;
                margin: auto;
            }

            h2 {
                text-align: center;
                color: #d35400;
            }

            label {
                font-weight: bold;
                color: #333;
            }

            input[type="text"],
            input[type="number"] {
                width: 100%;
                padding: 10px;
                margin-top: 6px;
                margin-bottom: 16px;
                border: 1px solid #ccc;
                border-radius: 6px;
            }

            .topping-options {
                margin-bottom: 16px;
            }

            .topping-options label {
                display: block;
                margin-bottom: 6px;
            }

            button {
                background-color: #e67e22;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
            }

            button:hover {
                background-color: #d35400;
            }
        </style>
    </head>
    <body>

    <div class="order-form">
        <h2>Form Pemesanan Pizza</h2>

        <form action="" method="POST">
            <input type="hidden" name="pizza" value="<?= $pizza ?>">
            <input type="hidden" name="price" value="<?= $price ?>">

            <label>Nama Customer:</label>
            <input type="text" name="customer_name" required>

            <label>Jumlah (Quantity):</label>
            <input type="number" name="quantity" min="1" value="1" required>

            <label>Pilih Topping (Opsional):</label>
            <div class="topping-options">
                <label><input type="checkbox" name="toppings[]" value="Extra Keju|5000"> Extra Keju (+Rp5.000)</label>
                <label><input type="checkbox" name="toppings[]" value="Sosis|7000"> Sosis (+Rp7.000)</label>
                <label><input type="checkbox" name="toppings[]" value="Jamur|4000"> Jamur (+Rp4.000)</label>
                <label><input type="checkbox" name="toppings[]" value="Nanas|3000"> Nanas (+Rp3.000)</label>
            </div>

            <button type="submit">Pesan Sekarang</button>
        </form>
    </div>

    </body>
    </html>
    <?php
}

// Close connection
mysqli_close($conn);
?>