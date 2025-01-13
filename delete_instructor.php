<?php
session_start();
require 'db.php';

// Periksa apakah pengguna telah login dan memiliki role admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Ambil ID instruktur dari URL
$id = $_GET['id'] ?? null;

if ($id) {
    // Siapkan query untuk menghapus data instruktur
    $query = $conn->prepare("DELETE FROM instructors WHERE id_instruktur = ?");
    $query->bind_param('i', $id);

    // Eksekusi query dan periksa hasilnya
    if ($query->execute()) {
        // Jika berhasil, kembali ke dashboard dengan pesan sukses
        $_SESSION['message'] = "Data instruktur berhasil dihapus.";
    } else {
        // Jika gagal, kembali ke dashboard dengan pesan error
        $_SESSION['error'] = "Gagal menghapus data instruktur.";
    }
} else {
    // Jika tidak ada ID, kembali ke dashboard
    $_SESSION['error'] = "ID tidak valid.";
}

header('Location: dashboard.php');
exit;
