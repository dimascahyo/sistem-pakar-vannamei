<?php

require '../koneksi.php';

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['update'])){

    // ambil data dari formulir
    $id = $_POST['id_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    // buat query update
    $update_query = "UPDATE gejala SET nama_gejala='$nama_gejala'
                     WHERE id_gejala=$id";
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