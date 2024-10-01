<?php

require '../koneksi.php';

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['create'])){

    // ambil data dari formulir
    $id_pengetahuan = $_POST['id_pengetahuan'];
    $kode_penyakit = $_POST['kode_penyakit'];
    $id_gejala = $_POST['id_gejala'];
    $h = $_POST['h'];
    $e = $_POST['e'];

    // buat query update
    $update_query = "INSERT INTO pengetahuan (id_pengetahuan, kode_penyakit, id_gejala, h, e) 
                     VALUE ('$id_pengetahuan', '$kode_penyakit', '$id_gejala', $h, $e)";
    $update_result = mysqli_query($conn, $update_query);

    // apakah query update berhasil?
    if( $update_result ) {
        // kalau berhasil alihkan ke halaman view.php
        //echo $kode_penyakit;
        header('Location: view.php?status=sukses');
    } else {
        // kalau gagal tampilkan pesan
        die('Location: view.php?status=gagal');
    }


} else {
    die("Akses dilarang...");
}

?>