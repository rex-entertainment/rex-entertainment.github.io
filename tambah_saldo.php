<?php
session_start();

// Cek apakah user adalah rexowner
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'rexowner') {
    die("Akses ditolak! Anda bukan owner.");
}

// Pastikan form dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Metode tidak valid.");
}

// Ambil data dari form
$username = trim($_POST['username']);
$amount = (int)$_POST['amount'];

// Validasi input
if (empty($username) || $amount <= 0) {
    die("Input tidak valid.");
}

// Nama file saldo
$dataFile = 'saldo.json';

// Cek apakah file saldo.json ada, jika tidak buat baru
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([], JSON_PRETTY_PRINT));
}

// Ambil data dari file JSON
$data = json_decode(file_get_contents($dataFile), true);

// Jika user belum ada, buat saldo default 0
if (!isset($data[$username])) {
    $data[$username] = 0;
}

// Tambah saldo
$data[$username] += $amount;

// Simpan kembali ke file saldo.json dengan pengecekan error
if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT))) {
    header("Location: order.html?msg=Saldo berhasil ditambahkan!");
    exit();
} else {
    die("Gagal menyimpan saldo.");
}
?>
