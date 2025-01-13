<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
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
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
        }
        
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #1a237e;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        p {
            font-size: 1.2em;
            line-height: 1.6;
            color: #546e7a;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 35px;
            margin-top: 20px;
            background: linear-gradient(45deg, #1a237e, #3949ab);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #3949ab, #1a237e);
        }
        
        footer {
            margin-top: 40px;
            color: #78909c;
            font-size: 0.9em;
            position: relative;
            padding-top: 20px;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: linear-gradient(to right, transparent, #78909c, transparent);
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            p {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Sistem Manajemen Pelatihan</h1>
        <p>Untuk dapat mengelola instruktur pelatihan, silakan login terlebih dahulu</p>
        <a href="login.php" class="btn">Login</a>
        <footer>©2024 Sistem Manajemen Pelatihan</footer>
    </div>
</body>
</html>