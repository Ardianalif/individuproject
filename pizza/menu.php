<!DOCTYPE html>
<html>
<head>
    <title>Menu Pizza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Menu Pizza</h1>
    </header>

    <div class="container">
        <?php
        $menu = [
            ["Margherita", 50000],
            ["Pepperoni", 60000],
            ["BBQ Chicken", 70000],
            ["Cheese Lovers", 55000],
            ["Meat Feast", 75000]
        ];

        foreach ($menu as $item) {
            echo "<div class='menu-item'>";
            echo "<h3>{$item[0]}</h3>";
            echo "<p>Harga: Rp " . number_format($item[1], 0, ',', '.') . "</p>";
            echo "<a class='button' href='order.php?pizza={$item[0]}&price={$item[1]}'>Pesan Sekarang</a>";
            echo "</div>";
        }
        ?>
        
        <br><br>
        <!-- Tombol ke halaman komplain -->
        <a href="complain.php" class="complain-button">Kirim Komplain</a>
    </div>
</body>
</html>
