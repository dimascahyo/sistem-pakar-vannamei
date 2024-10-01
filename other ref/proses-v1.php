<!-- process.php -->
<?php

require 'koneksi.php';

$sql1 = "SELECT id_gejala, h, e FROM pengetahuan WHERE kode_penyakit = 'P1'";
$result_wsd = $conn->query($sql1);

$sql2 = "SELECT id_gejala, h, e FROM pengetahuan WHERE kode_penyakit = 'P2'";
$result_wfd = $conn->query($sql2);

$sql3 = "SELECT id_gejala, h, e FROM pengetahuan WHERE kode_penyakit = 'P3'";
$result_myo = $conn->query($sql3);

$sql4 = "SELECT id_gejala, h, e FROM pengetahuan WHERE kode_penyakit = 'P4'";
$result_ahpnd = $conn->query($sql4);

$count_gejala = 0;

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

        $kode_p = '';
        switch ($p) {
            case 0:
                $kode_p = 'P1';
                break;
            case 1:
                $kode_p = 'P2';
                break;
            case 2:
                $kode_p = 'P3';
                break;
            case 3:
                $kode_p = 'P4';
                break;
            default:
                $kode_p = ''; // default value jika $p tidak sesuai
                break;
        }
    
        $selectedSymptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : array();
        $selected_gejala_int = implode(',', array_map('intval', $selectedSymptoms));
        //echo "$selected_gejala_int";
        
        if (!empty($selected_gejala_int)) {
            $sql_pengetahuan = "SELECT id_gejala, h, e FROM pengetahuan WHERE pengetahuan.id_gejala IN ($selected_gejala_int) AND kode_penyakit = '$kode_p'";
            $result_pengetahuan = $conn->query($sql_pengetahuan);
        
            $cfPengetahuan = array();
            if ($result_pengetahuan->num_rows > 0) {
                // Menyimpan nilai h dan e dalam array cf
                while($row = $result_pengetahuan->fetch_assoc()) {
                    $cfPengetahuan[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
                }
            }else {
                //echo "Tidak ada nilai CF ditemukan dalam database.";
            }

            // Mengehalikan array h dan e
            return $cfPengetahuan;
        }
    }
    // Applying the knowledge rules
    if ($symptoms[1] && $symptoms[2] && $symptoms[3] && $symptoms[4] && $symptoms[5] && 
        $symptoms[6] && $symptoms[7] && $symptoms[8] && !$symptoms[9] && !$symptoms[10]&& 
        !$symptoms[11] && !$symptoms[12] && !$symptoms[13]){
        $disease = "White Spot Disease";
        $cf = array();
        if ($result_wsd->num_rows > 0) {
            // Menyimpan nilai h dan e dalam array cf
            while($row = $result_wsd->fetch_assoc()) {
                $cf[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
            }
        }
        $cfcombine = 0;
        for ($i=1; $i <= 8; $i++) { 
            if ($i==1) {
                $cflama = $cf[$i]['h']*$cf[$i]['e']; 
            }
            $cfbaru = $cf[$i]['h']*$cf[$i]['e'];
            if ($i==2) {
                $cfcombine = $cflama+$cfbaru*(1-$cflama);
                $cflama = $cfcombine;
            }else if($i>2){
                $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                $cflama = $cfcombine;
            }
        }
    }elseif ($symptoms[1] && $symptoms[2] && $symptoms[3] && $symptoms[4] && !$symptoms[5] && 
            !$symptoms[6] && !$symptoms[7] && $symptoms[8] && $symptoms[9] && $symptoms[10]&& 
            !$symptoms[11] && !$symptoms[12] && !$symptoms[13]){
        $disease = "White Feces Disease";
        $cf = array();
        if ($result_wfd->num_rows > 0) {
            // Menyimpan nilai h dan e dalam array cf
            while($row = $result_wfd->fetch_assoc()) {
                $cf[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
            }
        }
        $cfcombine = 0;
        for ($i=1;$i<=10; $i++) { 
            if ($i==1) {
                $cflama = $cf[$i]['h']*$cf[$i]['e']; 
            }
            if ($i<=4 || $i>=8) {
                $cfbaru = $cf[$i]['h']*$cf[$i]['e'];
            }
            if ($i==2) {
                $cfcombine = $cflama+$cfbaru*(1-$cflama);
                $cflama = $cfcombine;
            }else if($i>2&&($i<=4||$i>=8)){
                $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                $cflama = $cfcombine;
            }
        }
    }elseif ($symptoms[1] && $symptoms[2] && $symptoms[3] && $symptoms[4] && !$symptoms[5] && 
            !$symptoms[6] && !$symptoms[7] && !$symptoms[8] && $symptoms[9] && !$symptoms[10]&& 
            $symptoms[11] && $symptoms[12] && !$symptoms[13]){
        $disease = "Infectious Myonecrosis virus";
        $cf = array();
        if ($result_myo->num_rows > 0) {
            // Menyimpan nilai h dan e dalam array cf
            while($row = $result_myo->fetch_assoc()) {
                $cf[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
            }
        }
        $cfcombine = 0;
        for ($i=1;$i<=12; $i++) { 
            if ($i==1) {
                $cflama = $cf[$i]['h']*$cf[$i]['e']; 
            }
            if ($i<=4 || ($i>=9 && $i!=10)) {
                $cfbaru = $cf[$i]['h']*$cf[$i]['e'];
            }
            if ($i==2) {
                $cfcombine = $cflama+$cfbaru*(1-$cflama);
                $cflama = $cfcombine;
            }else if($i>2&&($i<=4||($i>=9 && $i!=10))){
                $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                $cflama = $cfcombine;
            }
        }
    }elseif ($symptoms[1] && $symptoms[2] && $symptoms[3] && $symptoms[4] && !$symptoms[5] && 
            !$symptoms[6] && !$symptoms[7] && $symptoms[8] && !$symptoms[9] && $symptoms[10]&& 
            !$symptoms[11] && !$symptoms[12] && $symptoms[13]){
        $disease = "Acute Hepatopancreatic Necrosis Disesase";
        $cf = array();
        if ($result_ahpnd->num_rows > 0) {
            // Menyimpan nilai h dan e dalam array cf
            while($row = $result_ahpnd->fetch_assoc()) {
                $cf[$row["id_gejala"]] = array("h" => $row["h"], "e" => $row["e"]);
            }
        }
        $cfcombine = 0;
        for ($i=1;$i<=13; $i++) { 
            if ($i==1) {
                $cflama = $cf[$i]['h']*$cf[$i]['e']; 
            }
            if ($i<=4 || ($i>=8 && $i!=9 && $i!=11 && $i!=12)) {
                $cfbaru = $cf[$i]['h']*$cf[$i]['e'];
            }
            if ($i==2) {
                $cfcombine = $cflama+$cfbaru*(1-$cflama);
                $cflama = $cfcombine;
            }else if($i>2&&($i<=4 || ($i>=8 && $i!=9 && $i!=11 && $i!=12))){
                $cfcombine = $cfbaru+$cflama*(1-$cfbaru);
                $cflama = $cfcombine;
            }
        }
    }else {
        $a = 0;
        $b = 3;
        
        $max_cf = 0;
        for ($i=$a; $i <= $b; $i++) { 
            //echo "<p>i = $i</p>";
            // Memanggil fungsi getCF dengan parameter $p
            $cfPengetahuan = getCF($i);
            $cflama = 0;
            $cfbaru = 0;
            $cfcombine = 0;
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
                    switch ($i) {
                        case 0:
                            $disease = 'White Spot Disease (WSD)';
                            break;
                        case 1:
                            $disease = 'White Feces Disease (WFD)';
                            break;
                        case 2:
                            $disease = 'Infectious Myonecrosis virus (IMNV)';
                            break;
                        case 3:
                            $disease = 'Acute Hepatopancreatic Necrosis Disesase (AHPND)';
                            break;
                        default:
                            $disease = '';
                            break;
                    }
                
            }
        }
        $cfcombine = $max_cf;
    }
    $penanganan = '';
    if ($disease == 'White Spot Disease (WSD)') {
        $penanganan = 'Menambahkan beta-glucan, viamin C, fucoidan dan imunostimulan lain pada pakan yang dapat meningkatkan resistensi terhadap virus';
    }elseif ($disease == 'White Feces Disease (WFD)') {
        $penanganan = 'Mengurangi jumlah tebar. Jika ada indikasi terkena penyakit maka 
        kurangi jumlah pakan atau menghentikan sementara pemberian pakan, meningkatkan aerasi menggunakan kincir, 
        tambahkan bubuk bawang putih bersamaan pakan, dan gunakan probiotik dengan dosis 3x dari penggunaan normal. 
        Dan juga membersihkan dan mengeluarkan kotoran yang berada di tambak baik di permukaan dan di dasar tambak';
    }elseif ($disease == 'Infectious Myonecrosis virus (IMNV)') {
        $penanganan = 'Memperketat sistem biosekuriti. Kurangi kepadatan. Pemberian klorin yang harus di netralkan nantinya agar tidak menjadi racun yang membunuh udang.';
    }elseif ($disease == 'Acute Hepatopancreatic Necrosis Disesase (AHPND)') {
        $penanganan = 'Menjaga kualitas air agar tidak terjadi perubahan secara mendadak. 
        Mengontrol kepadatan udang dan rutin melakukan sampling. Jika terserang penyakit, 
        udang didesinfeksi menggunakan kaporit 100 ppm selama 3-7 hari kemudian dikubur. 
        Dasar tambak dibersihkan dari sisa-sisa molting udang, pakan, dan lumpur 
        lalu didesinfeksi menggunakan kaporit 100 ppm dan pengeringan minimal 15 hari
        ';
    }
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
            font-size:  18px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Hasil Deteksi Penyakit</h1>
        <div class="result">
            <p>Penyakit Terdeteksi: <strong><?php echo $disease; ?></strong></p>
            <p>Nilai Certainty Factor Terbesar: <strong><?php echo number_format($cfcombine, 5); ?></strong></p>
            <p>Penanganan:</p>
            <p><?php echo $penanganan?></p>
        </div>
    </div>
</body>
</html>
