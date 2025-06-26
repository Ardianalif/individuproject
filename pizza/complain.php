<?php
// KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_pizzza";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// PROSES FORM JIKA DI-SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id'] ?? '');
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validasi input
    if (empty($customer_name)) {
        $error = "Nama customer harus diisi!";
    } elseif (empty($message)) {
        $error = "Isi komplain harus diisi!";
    } else {
        // Simpan ke database
        $sql = "INSERT INTO complaints (customer_name, order_id, message, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $customer_name, $order_id, $message);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Komplain berhasil dikirim!";
        } else {
            $error = "❌ Gagal menyimpan komplain: " . mysqli_error($conn);
        }
    }
}

// Ambil order_id dari URL jika ada
$order_id_value = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Komplain</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h2 {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #c0392b;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Form Komplain Pelanggan</h2>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success ?>
                <p>Terima kasih atas masukan Anda. Kami akan segera menindaklanjuti komplain Anda.</p>
            </div>
            <a href="index.php" class="back-link">← Kembali ke Beranda</a>
        <?php else: ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="customer_name">Nama Customer*</label>
                    <input type="text" name="customer_name" id="customer_name" required 
                           value="<?= isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : '' ?>">
                </div>
                
                <div class="form-group">
                    <label for="order_id">ID Pesanan (jika ada)</label>
                    <input type="text" name="order_id" id="order_id" 
                           value="<?= $order_id_value ?>">
                </div>
                
                <div class="form-group">
                    <label for="message">Isi Komplain*</label>
                    <textarea name="message" id="message" required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
                </div>
                
                <button type="submit">Kirim Komplain</button>
            </form>
            
            <a href="index.php" class="back-link">← Kembali ke Beranda</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>