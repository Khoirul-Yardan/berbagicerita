<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "jalan_pulang";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data curhat
$sql = "SELECT * FROM curhat ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kumpulan Cerita</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background: #fff8f0;
      font-family: 'Segoe UI', sans-serif;
      padding: 30px 10px;
      color: #444;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      margin: 20px auto;
      max-width: 700px;
      border-left: 6px solid #ffa726;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .perasaan {
      font-weight: bold;
      color: #ef5350;
    }

    .tanggal {
      color: #888;
      font-size: 0.9em;
      margin-bottom: 10px;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #555;
      text-decoration: none;
    }

    a:hover {
      color: #000;
    }
  </style>
</head>
<body>

  <h2>🍂 Kumpulan Cerita Hati</h2>

  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="card">
        <div class="tanggal"><?= date('d M Y, H:i', strtotime($row['tanggal'])) ?></div>
        <div class="perasaan">Perasaan: <?= htmlspecialchars($row['perasaan']) ?></div>
        <p><strong><?= htmlspecialchars($row['nama_samaran']) ?: "Anonim" ?> menulis:</strong></p>
        <p><?= nl2br(htmlspecialchars($row['isi_cerita'])) ?></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">Belum ada cerita yang dibagikan.</p>
  <?php endif; ?>

  <a href="index.php">← Kembali ke Beranda</a>

</body>
</html>

<?php $conn->close(); ?>
