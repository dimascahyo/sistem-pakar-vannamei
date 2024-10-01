<?php
// File: create.php

// Koneksi ke database
require '../koneksi.php';


session_start();
if(empty($_SESSION['login'])){
    header("Location: ../login.php");
}


$query_penyakit = "SELECT kode_penyakit, nama_penyakit FROM penyakit";
$result_penyakit = mysqli_query($conn, $query_penyakit);

$query_gejala = "SELECT id_gejala, nama_gejala FROM gejala";
$result_gejala = mysqli_query($conn, $query_gejala);

$query_pengetahuan = "SELECT COUNT(id_pengetahuan) AS banyak_pengetahuan FROM pengetahuan";
$result_pengetahuan = mysqli_query($conn, $query_pengetahuan);
if (mysqli_num_rows($result_pengetahuan) == 1) {
    // Ambil data dari database
    $row = mysqli_fetch_assoc($result_pengetahuan);
    $id_baru = $row['banyak_pengetahuan']+1;
}

$kode_penyakit = '';
$id_gejala = '';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengetahuan Baru</title>
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
        <h2>Buat Data Pengetahuan</h2>
        <form method="post" action="proses-create.php">
            <input type="hidden" name="id_pengetahuan" value="<?php echo $id_baru; ?>">
            Pilih Penyakit:  
            <select name="kode_penyakit">
                <?php while ($row_penyakit = mysqli_fetch_assoc($result_penyakit)) : ?>
                    <option value="<?php echo $row_penyakit['kode_penyakit']; ?>" 
                                   <?php echo ($kode_penyakit == $row_penyakit['kode_penyakit']) ? 'selected' : ''; ?>>
                                   <?php echo $row_penyakit['nama_penyakit']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>
            Pilih gejala:  
            <select name="id_gejala">
                <?php while ($row_gejala = mysqli_fetch_assoc($result_gejala)) : ?>
                    <option value="<?php echo $row_gejala['id_gejala']; ?>" 
                                   <?php echo ($id_gejala == $row_gejala['id_gejala']) ? 'selected' : ''; ?>>
                                   <?php echo $row_gejala['nama_gejala']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>
            CF Pakar: <input type="text" name="h" value="">Contoh: 0.4<br><br>
            CF Pengguna: <input type="text" name="e" value="">Contoh: 0.6<br><br>
            <input type="submit" value="Create" name="create">
        </form>
    </div>
</body>
</html>