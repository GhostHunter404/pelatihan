<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Role user
$user = $_SESSION['user'];
$role = $user['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = $_POST['nik_instruktur'];
    $nip = $_POST['nip_instruktur'];
    $nama = $_POST['nama_instruktur'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $kelas_pelatihan = $_POST['kelas_pelatihan'];

    $query = $conn->prepare("INSERT INTO instructors (nik_instruktur, nip_instruktur, nama_instruktur, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_telp, kelas_pelatihan)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param('sssssssss', $nik, $nip, $nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $alamat, $no_telp, $kelas_pelatihan);

    if ($query->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Gagal menambahkan data instruktur.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Instruktur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Instruktur</h1>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik_instruktur" required>
            </div>
            
            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip_instruktur" required>
            </div>
            
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_instruktur" required>
            </div>
            
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" required>
            </div>
            
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>
            </div>
            
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="no_telp" required>
            </div>
            
            <div class="form-group">
                <label>Kelas Pelatihan</label>
                <select name="kelas_pelatihan" required>
                    <option value="">Pilih Kelas</option>
                    <option value="Pemrograman">Pemrograman</option>
                    <option value="Desain Grafis">Desain Grafis</option>
                    <option value="Animasi">Animasi</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit">Tambah</button>
                <a href="dashboard.php" class="back-button">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>