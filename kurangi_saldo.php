<?php
session_start();

// Cek apakah user adalah rexowner
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'rexowner') {
    die("Akses ditolak! Anda bukan owner.");
}

// Ambil data dari form
$username = $_POST['username'];
$amount = (int)$_POST['amount'];

// Simpan saldo ke database (contoh: menggunakan file JSON)
$dataFile = 'saldo.json';
$data = json_decode(file_get_contents($dataFile), true);

// Jika user tidak ada, hentikan proses
if (!isset($data[$username])) {
    die("User tidak ditemukan!");
}

// Kurangi saldo (pastikan tidak negatif)
if ($data[$username] < $amount) {
    die("Saldo tidak cukup!");
}

$data[$username] -= $amount;

// Simpan kembali ke file saldo.json
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

// Redirect kembali
header("Location: order.html?msg=Saldo berhasil dikurangi!");
exit();
?>
