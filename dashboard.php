<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'];

// Query untuk mendapatkan seluruh data instruktur
$query = "SELECT * FROM instructors";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Instruktur</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 20px;
            color: #2c3e50;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            text-align: center;
            color: #1a237e;
            font-size: 2.2em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome {
            text-align: center;
            margin: 20px 0 30px;
            padding: 15px;
            background: rgba(26, 35, 126, 0.1);
            border-radius: 10px;
            color: #1a237e;
        }

        .welcome strong {
            font-size: 1.2em;
            color: #3949ab;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn {
            padding: 12px 25px;
            background: linear-gradient(45deg, #1a237e, #3949ab);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #3949ab, #1a237e);
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Use collapse for better spacing */
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            white-space: normal; /* Allow text to wrap */
            overflow: visible; /* Allow overflow to be visible */
            text-overflow: clip; /* Disable text overflow clipping */
        }

        th {
            background: linear-gradient(45deg, #1a237e, #3949ab);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: rgba(26, 35, 126, 0.05);
        }

        /* Set specific widths for columns if necessary */
        th:nth-child(1), td:nth-child(1) { width: 50px; } /* ID */
        th:nth-child(2), td:nth-child(2) { width: 100px; } /* NIK */
        th:nth-child(3), td:nth-child(3) { width: 100px; } /* NIP */
        th:nth-child(4), td:nth-child(4) { width: 150px; } /* Nama */
        th:nth-child(5), td:nth-child(5) { width: 100px; } /* Jenis Kelamin */
        th:nth-child(6), td:nth-child(6) { width: 150px; } /* Tempat Lahir */
        th:nth-child(7), td:nth-child(7) { width: 100px; } /* Tanggal Lahir */
        th:nth-child(8), td:nth-child(8) { width: 200px; } /* Alamat */
        th:nth-child(9), td:nth-child(9) { width: 100px; } /* No. Telp */
        th:nth-child(10), td:nth-child(10) { width: 150px; } /* Kelas Pelatihan */
        <?php if ($role == 'admin'): ?>
        th:nth-child(11), td:nth-child(11) { width: 100px; } /* Action */
        <?php endif; ?>

        @media (max-width: 768px) {
            table {
                display: block; /* Allow the table to be block-level for scrolling */
                overflow-x: auto; /* Enable horizontal scrolling */
                white-space: nowrap; /* Prevent text from wrapping */
            }
        }

        .action-links a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 5px;
            border-radius: 15px;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }

        .edit-link {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
        }

        .delete-link {
            background: linear-gradient(45deg, #f44336, #e53935);
            color: white;
        }

        .action-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logout {
            display: inline-block;
            text-align: center;
            margin: 30px auto 10px;
            padding: 12px 30px;
            background: linear-gradient(45deg, #e53935, #ff5252);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #ff5252, #e53935);
        }

        .center-button {
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 10px;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            .btn-container {
                flex-direction: column;
                gap: 10px;
            }

            .action-links a {
                display: block;
                margin: 5px 0;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Instruktur</h1>
        <div class="welcome">
            <p>Selamat datang, <strong><?= htmlspecialchars($user['username']); ?></strong></p>
        </div>

        <div class="btn-container">
            <a href="add_instructor.php" class="btn">+ Tambah Instruktur</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Kelas Pelatihan</th>
                    <?php if ($role == 'admin'): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_instruktur']); ?></td>
                        <td><?= htmlspecialchars($row['nik_instruktur']); ?></td>
                        <td><?= htmlspecialchars($row['nip_instruktur']); ?></td>
                        <td><?= htmlspecialchars($row['nama_instruktur']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                        <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['no_telp']); ?></td>
                        <td><?= htmlspecialchars($row['kelas_pelatihan']); ?></td>
                        <?php if ($role == 'admin'): ?>
                            <td class="action-links">
                                <a href="edit_instructor.php?id=<?= $row['id_instruktur']; ?>" class="edit-link">Edit</a>
                                <a href="delete_instructor.php?id=<?= $row['id_instruktur']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus?')" 
                                   class="delete-link">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="center-button">
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>
</body>
</html>