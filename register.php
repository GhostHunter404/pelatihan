<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 digunakan di sini, tetapi sebaiknya menggunakan password_hash() untuk keamanan yang lebih baik
    
    $role = 'public';

    // Cek apakah username sudah ada
    $check_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_query->bind_param('s', $username);
    $check_query->execute();
    $check_result = $check_query->get_result();
    
    if ($check_result->num_rows > 0) {
        // Jika username sudah ada
        $error = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Jika username belum ada, lanjutkan dengan pendaftaran
        $query = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $query->bind_param('sss', $username, $password, $role);
        
        if ($query->execute()) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Registrasi gagal! Terjadi kesalahan saat menyimpan data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            text-align: center;
            color: #2c3e50;
        }
        
        .container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin: 20px;
        }
        
        .container:hover {
            transform: translateY(-5px);
        }
        
        h2 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #1a237e;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        input {
            width: calc(100% - 24px);
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            font-size: 1em;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        input:focus {
            outline: none;
            border-color: #1a237e;
            box-shadow: 0 0 10px rgba(26, 35, 126, 0.2);
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #1a237e, #3949ab);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #3949ab, #1a237e);
        }
        
        .error {
            color: #e53935;
            background: rgba(229, 57, 53, 0.1);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        
        .link {
            display: inline-block;
            margin-top: 20px;
            color: #1a237e;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .link:hover {
            color: #3949ab;
        }
        
        .link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: linear-gradient(to right, #1a237e, #3949ab);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .link:hover::after {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px;
                margin: 15px;
            }
            
            h2 {
                font-size: 1.8em;
            }
            
            input {
                font-size: 0.95em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Register</button>
        </form>
        <a href="login.php" class="link">Kembali ke Login</a>
    </div>
</body>
</html>
