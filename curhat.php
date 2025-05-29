<?php
// koneksi database
$conn = new mysqli('localhost', 'root', '', 'jalan_pulang');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = '';
$success = false;
$nama_samaran = '';
$perasaan = '';
$isi_cerita = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_samaran = trim($_POST['nama_samaran'] ?? '');
    $perasaan = trim($_POST['perasaan'] ?? '');
    $isi_cerita = trim($_POST['isi_cerita'] ?? '');

    if ($perasaan === '' || $isi_cerita === '') {
        $error = 'Perasaan dan cerita wajib diisi.';
    } else {
        $stmt = $conn->prepare("INSERT INTO curhat (nama_samaran, perasaan, isi_cerita) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $nama_samaran, $perasaan, $isi_cerita);
        if ($stmt->execute()) {
            $success = true;
            $nama_samaran = '';
            $perasaan = '';
            $isi_cerita = '';
        } else {
            $error = 'Gagal menyimpan cerita, coba lagi.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Curhat Anonim</title>
  <style>
    body {
      background: #fdf6f0;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
      text-align: center;
      color: #444;
    }
    h2 {
      margin-bottom: 10px;
    }
    form {
      max-width: 500px;
      margin: 0 auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      text-align: left;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      box-sizing: border-box;
      font-family: inherit;
      color: #444;
    }
    button {
      background-color: #ff8a80;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1rem;
      margin-top: 20px;
      border-radius: 8px;
      cursor: pointer;
      display: block;
      width: 100%;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #ff5252;
    }
    a {
      display: inline-block;
      margin-top: 15px;
      color: #888;
      text-decoration: none;
    }
    a:hover {
      color: #444;
    }
    .message {
      max-width: 500px;
      margin: 15px auto;
      padding: 15px;
      border-radius: 10px;
      font-weight: 600;
    }
    .error {
      background-color: #fdecea;
      color: #b00020;
      border: 1px solid #b00020;
    }
    .success {
      background-color: #e3f2e3;
      color: #2e7d32;
      border: 1px solid #2e7d32;
    }
  </style>
</head>
<body>

  <h2>🌿 Ceritakan Apa yang Kamu Rasakan</h2>
  <p>Kami di sini untuk mendengarkan. Ceritamu aman bersama kami.</p>

  <?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="message success">Terima kasih sudah berbagi. Kamu luar biasa karena berani jujur hari ini.</div>
  <?php endif; ?>

  <form action="curhat.php" method="POST">
    <input type="text" name="nama_samaran" placeholder="Nama samaran (opsional)" value="<?= htmlspecialchars($nama_samaran) ?>">
    
    <select name="perasaan" required>
      <option value="">Perasaanmu saat ini?</option>
      <option value="Sedih" <?= $perasaan === 'Sedih' ? 'selected' : '' ?>>Sedih</option>
      <option value="Kecewa" <?= $perasaan === 'Kecewa' ? 'selected' : '' ?>>Kecewa</option>
      <option value="Lelah" <?= $perasaan === 'Lelah' ? 'selected' : '' ?>>Lelah</option>
      <option value="Kesepian" <?= $perasaan === 'Kesepian' ? 'selected' : '' ?>>Kesepian</option>
      <option value="Marah" <?= $perasaan === 'Marah' ? 'selected' : '' ?>>Marah</option>
      <option value="Pasrah" <?= $perasaan === 'Pasrah' ? 'selected' : '' ?>>Pasrah</option>
      <option value="Rindu" <?= $perasaan === 'Rindu' ? 'selected' : '' ?>>Rindu</option>
    </select>
    
    <textarea name="isi_cerita" rows="6" placeholder="Tulis isi curhatmu di sini..." required><?= htmlspecialchars($isi_cerita) ?></textarea>

    <button type="submit">Kirim Cerita</button>
  </form>

  <a href="index.php">← Kembali ke Beranda</a>

</body>
</html>
