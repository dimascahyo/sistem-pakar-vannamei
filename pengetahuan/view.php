<?php

    session_start();
    if(empty($_SESSION['login'])){
        header("Location: ../login.php");
    }

    require '../koneksi.php';

    // Query untuk membaca data dari tabel penyakit
    $sql_read = "SELECT p.id_pengetahuan, p.kode_penyakit, pny.nama_penyakit, p.id_gejala, g.nama_gejala, p.h, p.e
                FROM pengetahuan AS p 
                JOIN penyakit AS pny 
                JOIN gejala AS g
                WHERE p.kode_penyakit LIKE pny.kode_penyakit AND p.id_gejala = g.id_gejala
                ";
    $result_read = $conn->query($sql_read);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengetahuan</title>
    <style>
        body{
            background-color: #e3f2fd; /* Warna biru langit */
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #container {
            font-family: Arial, sans-serif;
            /*background-color: #e0f2f1; /* Warna latar belakang biru langit */
            margin: 0;
            padding: 20px;
            margin-top:60px;
        }

        h1 {
            color: #1565c0; /* Warna judul */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff; /* Warna latar belakang tabel */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            font-size: 14px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Garis pembatas */
        }

        th {
            background-color: #1565c0; /* Warna latar belakang header kolom */
            color: #fff; /* Warna teks header kolom */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Warna latar belakang baris genap */
        }

        tr:hover {
            background-color: #ddd; /* Warna latar belakang saat dihover */
        }

        .button {
            background-color: #1565c0; /* Warna latar belakang tombol */
            color: #fff; /* Warna teks tombol */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0d47a1; /* Warna latar belakang saat dihover */
        }

        #add{
            padding: 15px;
            font-size: 14px;
        }
        #delete{
            background-color: #ff007e;
            color: white;
        }
        #delete:hover{
            background-color: #B10057;
            color: white;
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
    <div id="container">
        <h1>Data Pengetahuan</h1>
        <!-- Tombol untuk menambah data -->
        <a href="create.php" class="button" id="add">Tambah Pengetahuan</a>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>ID Pengetahuan</th>
                    <th>Kode Penyakit</th>
                    <th>Nama Penyakit</th>
                    <th>ID Gejala</th>
                    <th>Gejala</th>
                    <th>CF Pakar</th>
                    <th>CF Pengguna</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        if ($result_read->num_rows > 0) {
                            while ($row = $result_read->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id_pengetahuan"] . "</td>";
                                echo "<td>" . $row["kode_penyakit"] . "</td>";
                                echo "<td>" . $row["nama_penyakit"] . "</td>";
                                echo "<td>" . $row["id_gejala"] . "</td>";
                                echo "<td>" . $row["nama_gejala"] . "</td>";
                                echo "<td>" . $row["h"] . "</td>";
                                echo "<td>" . $row["e"] . "</td>";
                                echo "<td><a href='edit.php?id=".$row['id_pengetahuan']."' class='button'>Edit</a>
                                    <a href='delete.php?id=".$row['id_pengetahuan']."' class='button' id='delete'>delete </a></td>
                                ";
                                echo "</tr>";
                            }
                        } else {
                            echo "Tidak ada data penyakit";
                        }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
