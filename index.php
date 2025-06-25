<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV. Pizza AS | Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(to bottom right, #fff3e0, #ffe0b2);
            color: #333;
        }

        header {
            background-color: #d62828;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 48px;
            color: #d62828;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            color: #444;
        }

        .button {
            background-color: #f77f00;
            padding: 14px 28px;
            font-size: 18px;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .button:hover {
            background-color: #e85d04;
        }

        footer {
            background-color: #003049;
            color: white;
            text-align: center;
            padding: 16px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<header>
    CV. Pizza AS 🍕
</header>

<section class="hero">
    <h1>Selamat Datang di CV. Pizza AS!</h1>
    <p>Kami menyajikan pizza hangat, renyah, dan lezat untuk menemani harimu.<br>
       Pesan sekarang dan nikmati cita rasa autentik Italia di meja makanmu.</p>
    <a href="menu.php" class="button">Lihat Menu Pizza</a>
</section>

<footer>
    &copy; <?= date("Y") ?> CV. Pizza AS - Rasa yang Tak Terlupakan
</footer>

</body>
</html>
