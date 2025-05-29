<?php
$conn = new mysqli("localhost", "root", "", "jalan_pulang");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM curhat ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Galeri Cerita</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f4f4;
      padding: 2em;
      color: #444;
    }
    h2 {
      text-align: center;
      margin-bottom: 1em;
    }
    .card {
      background-color: #fff;
      border-left: 6px solid #f2a6a6;
      border-radius: 10px;
      padding: 1em 1.5em;
      margin-bottom: 1.2em;
      box-shadow: 0 3px 6px rgba(0,0,0,0.05);
    }
    .info {
      font-size: 0.9em;
      color: #777;
      margin-bottom: 0.5em;
    }
    .isi {
      white-space: pre-wrap;
    }
  </style>
</head>
<body>
  <h2>📝 Cerita Mereka</h2>

  <?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
      <div class="info">
        <?= htmlspecialchars($row['nama_samaran'] ?: "Anonim") ?> | 
        <?= htmlspecialchars($row['perasaan']) ?> | 
        <?= date('d M Y, H:i', strtotime($row['tanggal'])) ?>
      </div>
      <div class="isi"><?= nl2br(htmlspecialchars($row['isi_cerita'])) ?></div>
    </div>
  <?php endwhile; ?>

</body>
</html>
