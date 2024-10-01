<?php
// File: edit.php

// Koneksi ke database
require '../koneksi.php';

session_start();
if(empty($_SESSION['login'])){
    header("Location: ../login.php");
}

// Ambil data yang akan diedit dari database berdasarkan id_pengetahuan
if (isset($_GET['id'])) {
    $id_pengetahuan = $_GET['id'];
    
    // Query untuk mengambil data
    
    $query = "SELECT pny.kode_penyakit, pny.nama_penyakit, p.id_gejala, g.nama_gejala, p.h, p.e 
              FROM pengetahuan p JOIN gejala g
              JOIN penyakit pny ON p.kode_penyakit = pny.kode_penyakit AND g.id_gejala = p.id_gejala
              WHERE p.id_pengetahuan = $id_pengetahuan";
    $result = mysqli_query($conn, $query);
    
    // Memeriksa apakah query berhasil dijalankan
    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
    
    // Memeriksa apakah ada baris data yang cocok
    if (mysqli_num_rows($result) == 1) {
        // Ambil data dari database
        $row = mysqli_fetch_assoc($result);
        $kode_penyakit = $row['kode_penyakit'];
        $nama_penyakit = $row['nama_penyakit'];
        $id_gejala = $row['id_gejala'];
        $nama_gejala = $row['nama_gejala'];
        $h = $row['h'];
        $e = $row['e'];
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pengetahuan tidak ditemukan.";
    exit();
}

$query_penyakit = "SELECT kode_penyakit, nama_penyakit FROM penyakit";
$result_penyakit = mysqli_query($conn, $query_penyakit);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Biru Langit */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 16px;
            margin-top: 60px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 420px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #1565c0; /* Warna biru gelap */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0d47a1; /* Warna biru gelap yang sedikit lebih tua */
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            appearance: none; /* Remove default arrow */
            background-image: linear-gradient(45deg, transparent 50%, #4CAF50 50%),
                                linear-gradient(135deg, #4CAF50 50%, transparent 50%);
            background-position: calc(100% - 20px) calc(1em + 2px), 
                                  calc(100% - 15px) calc(1em + 2px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
            font-size: 16px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <!-- Your logo image or text -->
            <a href="../index.php">
                <img src="../assets/logo.png" alt="Logo">
            </a>
        </div>
        <div class="menu">
            <!-- Menu links -->
            <a href="../cek_penyakit.php">Cek Penyakit</a>
            <a href="../pengetahuan/view.php">Pengetahuan</a>
            <a href="../gejala/view.php">Gejala</a>
            <a href="../logout.php" id="logout">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>Edit Data Pengetahuan</h2>
        <form method="post" action="proses-edit.php">
            <input type="hidden" name="id_pengetahuan" value="<?php echo $id_pengetahuan; ?>">
            Nama Penyakit: <input type="text" name="nama_penyakit" value="<?php echo $nama_penyakit; ?>" readonly><br><br>
            Gejala: <input type="text" name="nama_gejala" value="<?php echo $nama_gejala; ?>" readonly><br><br>
            Pakar: <input type="text" name="h" value="<?php echo $h; ?>"><br><br>
            Pengguna: <input type="text" name="e" value="<?php echo $e; ?>"><br><br>
            <input type="submit" value="Update" name="update">
        </form>
    </div>
</body>
</html>
