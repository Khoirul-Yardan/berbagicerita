<?php
session_start();

// Login sederhana: username = admin, password = jalanpulang
if (isset($_POST['login'])) {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if ($user === 'admin' && $pass === 'jalanpulang') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Username atau password salah";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Login Admin</title>
        <style>
            body { font-family: 'Segoe UI', sans-serif; background:#fdf4f4; display:flex; justify-content:center; align-items:center; height:100vh; }
            .login-box { background:#fff; padding:2em; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); width:320px; }
            input { width:100%; padding:0.7em; margin:0.6em 0; border-radius:8px; border:1px solid #ccc; }
            button { width:100%; padding:0.7em; background:#f2a6a6; border:none; color:#fff; border-radius:8px; cursor:pointer; font-weight:bold; }
            button:hover { background:#e47b7b; }
            .error { color:#d00; margin-bottom:1em; }
        </style>
    </head>
    <body>
    <div class="login-box">
        <h2>Login Admin</h2>
        <?php if (!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Masuk</button>
        </form>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// Kalau sudah login, sambung koneksi database
$conn = new mysqli("localhost", "root", "", "jalan_pulang");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Hapus curhat jika ada permintaan hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM curhat WHERE id = $id");
    header("Location: admin.php");
    exit;
}

// Proses tambah afirmasi baru
if (isset($_POST['tambah_afirmasi'])) {
    $kata = $conn->real_escape_string($_POST['kata'] ?? '');
    if ($kata !== '') {
        // Asumsikan tabel baru bernama 'afirmasi'
        $conn->query("INSERT INTO afirmasi (kata) VALUES ('$kata')");
        $message = "Afirmasi baru berhasil ditambahkan.";
    }
}

// Ambil semua curhat
$sql = "SELECT * FROM curhat ORDER BY tanggal DESC";
$result = $conn->query($sql);

// Ambil semua afirmasi
$afirmasi_result = $conn->query("SELECT * FROM afirmasi ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Jalan Pulang</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background:#fafafa; margin:0; padding:1em 2em; color:#333; }
        h1 { margin-bottom: 1em; color:#f26a6a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2em; }
        th, td { border: 1px solid #ddd; padding: 0.5em; text-align: left; }
        th { background: #f2a6a6; color: white; }
        .btn-hapus { color: #d00; text-decoration: none; font-weight: bold; }
        .btn-logout { float: right; background: #f26a6a; color: white; padding: 0.5em 1em; border-radius: 6px; text-decoration: none; }
        .form-afirmasi { margin-bottom: 3em; }
        textarea, input[type=text] { width: 100%; padding: 0.6em; margin-top: 0.5em; border-radius: 8px; border: 1px solid #ccc; }
        button { background:#f26a6a; border:none; color:white; padding:0.6em 1.2em; border-radius:8px; cursor:pointer; }
        button:hover { background:#d24d4d; }
        .message { color: green; margin-bottom: 1em; }
    </style>
</head>
<body>

    <h1>Panel Admin Jalan Pulang</h1>
    <a href="?logout=1" class="btn-logout">Logout</a>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <h2>Daftar Curhat</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Samaran</th>
                <th>Perasaan</th>
                <th>Isi Cerita</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama_samaran'] ?: "Anonim") ?></td>
                <td><?= htmlspecialchars($row['perasaan']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['isi_cerita'])) ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><a href="?hapus=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Hapus curhat ini?')">Hapus</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Tambah Afirmasi Baru</h2>
    <form method="post" class="form-afirmasi">
        <label for="kata">Kata Afirmasi:</label>
        <input type="text" name="kata" id="kata" required placeholder="Contoh: Kamu luar biasa..." />
        <button type="submit" name="tambah_afirmasi">Tambah</button>
    </form>

    <h2>Daftar Afirmasi</h2>
    <ul>
    <?php while($afirm = $afirmasi_result->fetch_assoc()): ?>
        <li><?= htmlspecialchars($afirm['kata']) ?></li>
    <?php endwhile; ?>
    </ul>

</body>
</html>
