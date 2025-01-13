<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

// Perbaikan query untuk mengambil data instruktur
try {
    $query = $conn->prepare("SELECT * FROM instructors WHERE id_instruktur = ?");
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows === 0) {
        header('Location: dashboard.php');
        exit;
    }
    
    $data = $result->fetch_assoc();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

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

    try {
        $query = $conn->prepare("UPDATE instructors SET 
                                nik_instruktur = ?, 
                                nip_instruktur = ?, 
                                nama_instruktur = ?, 
                                jenis_kelamin = ?, 
                                tempat_lahir = ?, 
                                tanggal_lahir = ?, 
                                alamat = ?, 
                                no_telp = ?, 
                                kelas_pelatihan = ?
                                WHERE id_instruktur = ?");
        $query->bind_param('sssssssssi', $nik, $nip, $nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $alamat, $no_telp, $kelas_pelatihan, $id);

        if ($query->execute()) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Gagal mengupdate data instruktur.";
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Instruktur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Instruktur</h1>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik_instruktur" value="<?= htmlspecialchars($data['nik_instruktur'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip_instruktur" value="<?= htmlspecialchars($data['nip_instruktur'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_instruktur" value="<?= htmlspecialchars($data['nama_instruktur'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="Laki-laki" <?= ($data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" required><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Kelas Pelatihan</label>
                <select name="kelas_pelatihan" required>
                    <option value="Pemrograman" <?= ($data['kelas_pelatihan'] ?? '') == 'Pemrograman' ? 'selected' : ''; ?>>Pemrograman</option>
                    <option value="Desain Grafis" <?= ($data['kelas_pelatihan'] ?? '') == 'Desain Grafis' ? 'selected' : ''; ?>>Desain Grafis</option>
                    <option value="Animasi" <?= ($data['kelas_pelatihan'] ?? '') == 'Animasi' ? 'selected' : ''; ?>>Animasi</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit">Update</button>
                <a href="dashboard.php" class="back-button">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>