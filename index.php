<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tempat Berbagi Perasaan</title>
  <style>
    body {
      background-color: #f0e9f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #4b3b6b;
      margin: 0;
      padding: 20px;
      text-align: center;
    }
    h1 {
      font-size: 3rem;
      margin-bottom: 0.5rem;
      font-weight: 700;
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      max-width: 450px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.5;
      color: #6a5d7b;
    }
    nav {
      margin-bottom: 30px;
    }
    nav a {
      display: inline-block;
      background-color: #a97bc9;
      color: white;
      padding: 12px 24px;
      font-size: 1rem;
      border-radius: 30px;
      text-decoration: none;
      margin: 0 10px 10px 10px;
      box-shadow: 0 5px 10px rgba(169, 123, 201, 0.4);
      transition: background-color 0.3s ease;
    }
    nav a:hover {
      background-color: #8f5bb6;
    }
  </style>
</head>
<body>

  <h1>Tempat Berbagi Perasaan</h1>
  <p>Di sini kamu tidak harus kuat.<br>Duduklah sejenak.<br>Ceritakan apa yang kamu rasakan.</p>

  <nav>
    <a href="curhat.php">Mulai Curhat</a>
    <a href="cerita.php">Lihat Cerita</a>
    <a href="admin.php">Admin Panel</a>
    <a href="terimakasih.php">Terima Kasih</a>
  </nav>
<footer>
    &copy; <?php echo date("Y"); ?> Jalan Pulang | KYMZ 
  </footer>
</body>
</html>
