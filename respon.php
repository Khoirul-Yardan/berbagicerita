<?php
// respon.php
// Mendapatkan perasaan dari parameter GET atau POST
$perasaan = $_GET['perasaan'] ?? $_POST['perasaan'] ?? '';

$pesan = '';

// Contoh kalimat hangat berdasarkan perasaan
switch (strtolower($perasaan)) {
    case 'sedih':
        $pesan = "Nangis nggak apa-apa. Peluk dari jauh, ya.";
        break;
    case 'kecewa':
        $pesan = "Mungkin mereka nggak tahu kamu seberharga itu. Tapi aku tahu.";
        break;
    case 'lelah':
        $pesan = "Istirahat dulu, kamu sudah berusaha sebaik mungkin.";
        break;
    case 'marah':
        $pesan = "Teriakkan isi hatimu, tapi jangan biarkan amarah menguasai dirimu.";
        break;
    case 'bahagia':
        $pesan = "Senang melihat kamu bahagia! Tetap jaga semangatmu ya.";
        break;
    default:
        $pesan = "Terima kasih sudah berbagi perasaanmu.";
        break;
}

header('Content-Type: application/json');
echo json_encode(['pesan' => $pesan]);
