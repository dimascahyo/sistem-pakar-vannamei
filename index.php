<?php

    require 'koneksi.php';
    // Query untuk mengambil data gejala dari tabel gejala
    $sql_gejala = "SELECT id_gejala, nama_gejala FROM gejala";
    $result_gejala = $conn->query($sql_gejala);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Deteksi Penyakit Udang</title>
    <style>
        body{
            background-color: #e3f2fd; /* Warna biru langit */
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .hero {
            background-image: url('assets/bg_web.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Style untuk header*/ 
        
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #007eff;
            color: white;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000; /* Ensure it's above other content */
            display: flex;
            justify-content:space-between;
            opacity: 0.9;
        }

        .logo {
            float: left;
            
        }

        img{
            width: 30px;
            height: 30px;
        }

        .menu {
            float: right;
            margin-right: 5%;
            color: #ffffff;
            padding-top: 10px;
        }

        .menu a {
            text-decoration: none;
            color: white;
            padding-top: 40px;
            padding-bottom: 31px;
            padding-left: 25px;
            padding-right: 25px;
            margin: 0;
            /*transition: background-color 0.3s ease;*/
        }

        .menu a:hover {
            color: #ffffff;
            background-color: #0074EB;
            transition: background-color 0.3s ease;
            
        }

        #login{
            padding: 15px 30px;
            background-color: #007EFF;
            color: white;
            border-radius: 8px;
            border-style: solid;
            border-color: #ffffff;
            border-width: 3px;
            margin-left: 25px;
        }
        #login:hover{
            background-color: #0062C6;
            padding: 15px 30px;
            color: white;
            border-color: #ffffff;
        }
        
        #logout{
            padding: 15px 30px;
            background-color: #ff007e;
            color: white;
            border-radius: 8px;
            border-style: solid;
            border-color: #ff007e;
            border-width: 3px;
            margin-left: 25px;
        }
        #logout:hover{
            background-color: #B10057;
            padding: 15px 30px;
            color: white;
            border-color: #B10057;
        }

        #cek {
            display: inline-block;
            padding: 20px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #cek:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php
    // Start session
    session_start();

    // Check if user is logged in
    if(empty($_SESSION['login'])){
        // If logged in, display header with menu links and logout button
        ?>
        <div class="header">
            <div class="logo">
                <!-- Your logo image or text -->
                <a href="index.php">
                    <img src="assets/logo.png" alt="Logo">
                </a>
                
            </div>
            <div class="menu">
                <!-- Menu links -->
                <a href="cek_penyakit.php">Cek Penyakit</a>
                <a href="login.php" id="login">Login</a>
            </div>
        </div>
        <?php
    } else {
        // If not logged in, display header with login button
        ?>
        <div class="header">
            <div class="logo">
                <!-- Your logo image or text -->
                <a href="index.php">
                    <img src="assets/logo.png" alt="Logo">
                </a>
            </div>
            <div class="menu">
                <!-- Menu links -->
                <a href="cek_penyakit.php">Cek Penyakit</a>
                <a href="pengetahuan/view.php">Pengetahuan</a>
                <a href="gejala/view.php">Gejala</a>
                <a href="logout.php" id="logout">Logout</a>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="hero">
        <div class="content">
            <h1>Sistem Pakar Deteksi Penyakit Udang Vanname</h1>
            <br>
            <p>Selamat datang di sistem pakar deteksi penyakit udang Vanname. Ketahui kemungkinan penyakit apa yang menjangkit udang anda disini.</p>
            <br>
            <a href="cek_penyakit.php" class="btn" id="cek">Cek Penyakit</a>
        </div>
    </div>
</body>
</html>
