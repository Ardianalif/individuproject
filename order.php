<?php
$pizza = $_GET['pizza'];
$price = $_GET['price'];
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

    <form action="order_process.php" method="POST">
        <input type="hidden" name="pizza" value="<?= htmlspecialchars($pizza) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">

        <label>Nama Customer:</label>
        <input type="text" name="customer_name" required>

        <label>Jumlah (Quantity):</label>
        <input type="number" name="quantity" min="1" value="1">

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
