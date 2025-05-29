<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; // ganti jika bukan root
$pass = "";     // ganti jika ada password
$db   = "jalan_pulang";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_samaran = htmlspecialchars($_POST['nama_samaran']);
$perasaan = htmlspecialchars($_POST['perasaan']);
$isi_cerita = htmlspecialchars($_POST['isi_cerita']);

// Validasi sederhana
if (empty($perasaan) || empty($isi_cerita)) {
  echo "<script>
    alert('Perasaan dan isi cerita tidak boleh kosong.');
    window.location.href = 'curhat.php';
  </script>";
  exit;
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO curhat (nama_samaran, perasaan, isi_cerita) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nama_samaran, $perasaan, $isi_cerita);

if ($stmt->execute()) {
  echo "<script>
    alert('Terima kasih. Ceritamu sudah tersimpan.');
    window.location.href = 'index.php';
  </script>";
} else {
  echo "<script>
    alert('Terjadi kesalahan saat menyimpan cerita.');
    window.location.href = 'curhat.php';
  </script>";
}

$stmt->close();
$conn->close();
?>
