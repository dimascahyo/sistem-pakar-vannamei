<!-- process.php -->
<?php

require 'koneksi.php';


$sql_penyakit = "SELECT id_penyakit, kode_penyakit, nama_penyakit FROM penyakit";
$count_penyakit = $conn->query($sql_penyakit);

$count_gejala = 0;
$banyak_penyakit = 0;

if ($count_penyakit->num_rows > 0) {
    // Loop melalui setiap baris hasil query
    while ($row = $count_penyakit->fetch_assoc()) {
        // Tambahkan id_penyakit ke array
        $nama_pny[] = $row["nama_penyakit"];
        
        // Tambahkan 1 ke counter
        $banyak_penyakit++;
    }
} else {
    echo "Tidak ada data penyakit";
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected symptoms from the form
    $selectedSymptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : array();

    //get counter for gejala
    //$count_gejala = 0;
    $count_gejala = $_POST['banyak_gejala'];

    // Initialize array to store symptoms
    //$symptoms = array(false, false, false, false, false, false, false, false, false, false, false, false, false, false); // Initial value for all symptoms is false
    $symptoms = array_fill(0, $count_gejala, false);
    // Update symptom array based on selected symptoms
    foreach ($selectedSymptoms as $symptomIndex) {
        if ($symptomIndex >= 1 && $symptomIndex < $count_gejala) {
            $symptoms[$symptomIndex] = true;
        }
    }
    

    $disease = "";

    function getCF($p){
        require 'koneksi.php';

        $kode_p = 'P'.$p;
    
        $selectedSymptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : array();
        $selected_gejala_int = implode(',', array_map('intval', $selectedSymptoms));
        //echo "$selected_gejala_int";
        
        if (!empty($selected_gejala_int)) {
            $sql_pengetahuan = "SELECT p.id_gejala, p.h, p.e, pny.nama_penyakit 
                                FROM pengetahuan p 
                                JOIN penyakit pny ON p.kode_penyakit = pny.kode_penyakit 
                                WHERE p.id_gejala IN ($selected_gejala_int) AND p.kode_penyakit = '$kode_p'";
            $result_pengetahuan = $conn->query($sql_pengetahuan);
        
            $cfPengetahuan = array();
            if ($result_pengetahuan->num_rows > 0) {
                // Menyimpan nilai h dan e dalam array cf
                while($row = $result_pengetahuan->fetch_assoc()) {
                    $cfPengetahuan[$row["id_gejala"]] = array("nama_penyakit" => $row["nama_penyakit"], "h" => $row["h"], "e" => $row["e"]);
                }
            }else {
                //echo "Tidak ada nilai CF ditemukan dalam database.";
            }

            // Mengehalikan array h dan e
            return $cfPengetahuan;
        }
    }
    function getRule($p){
        require 'koneksi.php';

        $kode_p = 'P'.$p;
        $sql_rule = "SELECT p.id_gejala, pny.nama_penyakit, p.h, p.e FROM pengetahuan p JOIN penyakit pny WHERE p.kode_penyakit = '$kode_p'";
            $result_rule = $conn->query($sql_rule);
        
            $rule_id = array();
            if ($result_rule->num_rows > 0) {
                // Menyimpan nilai h dan e dalam array cf
                while($row = $result_rule->fetch_assoc()) {
                    $rule_id[] = $row["id_gejala"];
                    //$rule[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
                }
            }else {
                //echo "Tidak ada nilai CF ditemukan dalam database.";
            }

            // Mengehalikan array h dan e
            return $rule_id;

    }
    function getPenyakit($p){
        require 'koneksi.php';

        $query_penyakit = "SELECT id_penyakit, nama_penyakit, solusi FROM penyakit WHERE id_penyakit = '$p'";
            $result_penyakit = $conn->query($query_penyakit);
        
            $data_penyakit = array();
            if ($result_penyakit->num_rows == 1) {
                // Menyimpan nilai h dan e dalam array cf
                while($row = $result_penyakit->fetch_assoc()) {
                    $data_penyakit[$row["id_penyakit"]] = array("nama_penyakit" => $row["nama_penyakit"], "solusi" => $row["solusi"]);
                }
            }else {
                //echo "Tidak ada nilai CF ditemukan dalam database.";
            }

            // Mengehalikan array h dan e
            return $data_penyakit;

    }
    if (!$symptoms[5] && !$symptoms[6] && !$symptoms[7] && !$symptoms[8] && !$symptoms[9] && !$symptoms[10]&& 
        !$symptoms[11] && !$symptoms[12] && !$symptoms[13]) {
            $disease = "tidak_sakit";
    }
    else {
        $max_cf = 0;
        $sesuaiRule = false;
        $solusi='';
        //perulangan untuk menghitung nilai cf
        for ($i=1; $i <= $banyak_penyakit; $i++) { 
            //echo "<p>i = $i</p>";
            // Memanggil fungsi getCF dengan parameter $p
            $cfPengetahuan = getCF($i);
            $dataPenyakit = getPenyakit($i);
            $rule = array_fill(0, $count_gejala, false);
            $selectedRule = getRule($i);
            // Update symptom array based on selected symptoms
            foreach ($selectedRule as $ruleIndex) {
                if ($ruleIndex >= 1 && $ruleIndex < $count_gejala) {
                    $rule[$ruleIndex] = true;
                }
            }
            $cflama = 0;
            $cfbaru = 0;
            $cfcombine = 0;
            if ($rule==$symptoms) {
                $sesuaiRule = true;
                $disease = $dataPenyakit[$i]['nama_penyakit'];
                $solusi = $dataPenyakit[$i]['solusi'];
                for ($j=1; $j <= $count_gejala; $j++) {
                    // Memeriksa apakah $cfPengetahuan[$j] telah diisi sebelumnya
                   if (isset($cfPengetahuan[$j])){
                       if ($cflama == 0) {
                           $cflama = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cflama;
                       }elseif ($cflama != 0 && $cfbaru == 0) {
                           $cfbaru = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cflama+$cfbaru*(1-$cflama);
                           $cflama = $cfcombine;
                       }elseif ($cflama != 0 && $cfbaru != 0) {
                           $cfbaru = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                           $cflama = $cfcombine;
                       } 
                   }
                   //echo "<p>$cfcombine</p>";
               }
               if ($cflama>$max_cf) {
                $max_cf = $cflama;
                $disease = $dataPenyakit[$i]['nama_penyakit'];
                $solusi = $dataPenyakit[$i]['solusi'];                
                }
            }
            if(!$sesuaiRule){
                for ($j=1; $j <= $count_gejala; $j++) {
                    // Memeriksa apakah $cfPengetahuan[$j] telah diisi sebelumnya
                   if (isset($cfPengetahuan[$j])){
                       if ($cflama == 0) {
                           $cflama = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cflama;
                       }elseif ($cflama != 0 && $cfbaru == 0) {
                           $cfbaru = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cflama+$cfbaru*(1-$cflama);
                           $cflama = $cfcombine;
                       }elseif ($cflama != 0 && $cfbaru != 0) {
                           $cfbaru = $cfPengetahuan[$j]['h']*$cfPengetahuan[$j]['e'];
                           $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                           $cflama = $cfcombine;
                       } 
                   }
                   //echo "<p>$cfcombine</p>";
               }
                if ($cflama>$max_cf) {
                $max_cf = $cflama;
                    if (isset($dataPenyakit[$i])){
                        $disease = $dataPenyakit[$i]['nama_penyakit'];
                        $solusi = $dataPenyakit[$i]['solusi'];
                    }
                
                }
            }
        }    
        $cfcombine = $max_cf;
        $presentase = $cfcombine*100;
        if ($presentase<=50) {
            $disease = 'tidak_sakit';
        }
    }
    
        
        //echo $d;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Penyakit Vanamei</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3f2fd; /* Warna biru langit */
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #1565c0; /* Warna biru gelap */
            text-align: center;
        }

        .result {
            font-size:  14px;
            margin-top: 20px;
            padding: 20px;
            background-color: #bbdefb; /* Warna biru muda */
            border-radius: 8px;
        }

        .result p {
            margin: 10px 0;
            padding: 5px 10px;
            border-bottom: 1px solid #90caf9; /* Warna biru terang */
        }

        .result p:last-child {
            border-bottom: none;
        }
        #tidak_sakit{
            font-size: 18px;
            text-align: center;
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
    <div class="container">
            <?php
            if ($disease=="tidak_sakit") {
                echo"<h1>Udang tidak terserang penyakit</h1>";
                echo"<div class='result'>";
                echo"<p id='tidak_sakit'> Apabila kondisi air tambak dalam kondisi di luar standar segera lakukan penyesuaian.</p>";
                echo"</div>";
            }else {
                echo"<h1>Hasil Deteksi Penyakit</h1>";
                echo"<div class='result'>";
                echo"<p>Udang Vannamei terindikasi terserang penyakit <strong>$disease</strong> dengan presentase keyakinan <strong>".number_format($presentase, 0)."%</strong></p>";
                echo"<p>Nilai Certainty Factor: <strong>".number_format($cfcombine, 2)."</strong></p>";
                echo"<p>Solusi: $solusi</p>";
                echo"</div>";
            }
            ?>
    </div>
</body>
</html>
