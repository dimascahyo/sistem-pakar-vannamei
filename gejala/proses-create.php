<?php

require '../koneksi.php';

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['create'])){

    // ambil data dari formulir
    $id_gejala = $_POST['id_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    // buat query update
    $update_query = "INSERT INTO gejala (id_gejala, nama_gejala) 
                     VALUE ('$id_gejala','$nama_gejala')";
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