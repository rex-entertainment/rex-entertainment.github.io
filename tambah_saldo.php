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

// Jika user belum ada di saldo.json, buat default saldo 0
if (!isset($data[$username])) {
    $data[$username] = 0;
}

// Tambah saldo
$data[$username] += $amount;

// Simpan kembali ke file saldo.json
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

// Redirect kembali
header("Location: order.html?msg=Saldo berhasil ditambahkan!");
exit();
?>
