<?php
session_start();

// Pastikan hanya owner yang bisa akses
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'rexowner') {
    die("Akses ditolak!");
}

// Ambil data dari form
$username = $_POST['username'];
$amount = (int) $_POST['amount'];

// Simpan ke file saldo.json
$dataFile = 'saldo.json';
$data = json_decode(file_get_contents($dataFile), true);

// Tambahkan saldo ke user
$data[$username] = isset($data[$username]) ? $data[$username] + $amount : $amount;

// Simpan ke file
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

header("Location: order.html");
exit();
?>
