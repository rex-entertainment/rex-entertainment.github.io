<?php
session_start();

// Cek apakah user adalah rexowner
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'rexowner') {
    die("Akses ditolak! Anda bukan owner.");
}

// Pastikan data POST diterima
if (!isset($_POST['username']) || !isset($_POST['amount'])) {
    die("Error: Data tidak lengkap.");
}

$username = trim($_POST['username']);
$amount = (int)$_POST['amount'];

// Validasi input
if (empty($username) || $amount <= 0) {
    die("Error: Masukkan username yang valid dan jumlah saldo lebih dari 0.");
}

// File saldo.json sebagai database sederhana
$dataFile = 'saldo.json';

// Jika file belum ada, buat file kosong
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Ambil data saldo yang sudah ada
$data = json_decode(file_get_contents($dataFile), true);

// Jika user belum ada dalam saldo.json, buat saldo default 0
if (!isset($data[$username])) {
    $data[$username] = 0;
}

// Tambah saldo
$data[$username] += $amount;

// Simpan kembali ke saldo.json
if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT))) {
    echo "Saldo berhasil ditambahkan! <a href='order.html'>Kembali</a>";
} else {
    die("Error: Gagal menyimpan data.");
}
?>
