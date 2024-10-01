<?php

    require 'koneksi.php';
    // Query untuk mengambil data gejala dari tabel gejala
    $sql_gejala = "SELECT id_gejala, nama_gejala FROM gejala";
    $result_gejala = $conn->query($sql_gejala);
    
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penyakit</title>
    <style>
        body{
            background-color: #e3f2fd; /* Warna biru langit */
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #cover {
            font-family: Arial, sans-serif;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding-top: 100px;
        }

        .container {
            max-width: 1000px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #1565c0; /* Warna biru gelap */
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2; /* Warna abu-abu */
        }

        tr:hover {
            background-color: #f2f2f2; /* Warna abu-abu saat dihover */
        }

        input[type="checkbox"] {
            margin-right: 5px;
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
        a {
            text-decoration: none;
            color: #000;
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
<?php
    // Start session

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
    <div id="cover">
        <div class="container">
            <h1>Pilih Gejala</h1>
            <?php
                echo '<form action="proses-fix.php" method="post">';
                echo '<table>';
                echo '<tr>';
                echo '<th></th>';
                echo '<th>Nomor</th>';
                echo '<th>Kode</th>';
                echo '<th>Gejala</th>';
                echo '</tr>';
                
                if ($result_gejala->num_rows > 0) {
                    // Tampilkan data gejala dalam bentuk checkbox
                    $banyak_gejala=1;
                    while ($row = $result_gejala->fetch_assoc()) {
                        $banyak_gejala++;
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="symptoms[]" value="' . $row["id_gejala"] . '"></td>';
                        echo '<td>' . $row["id_gejala"] . '</td>';
                        echo '<td>G' . $row["id_gejala"] . '</td>';
                        echo '<td>' . $row["nama_gejala"] . '</td>';
                        echo '</tr>';
                    }
                    echo '<input type="hidden" name="banyak_gejala" value="'.$banyak_gejala.'">';
                } else {
                    echo '<tr><td colspan="4">Tidak ada data gejala</td></tr>';
                }
                echo '</table>';
                echo '<input type="submit" value="Proses">';
                echo '</form>';
            ?>
        </div>
    </div>
</body>
</html>
