<?php

require '../koneksi.php';

if (isset($_GET['id'])) {
    $id_gejala = $_GET['id'];

    // buat query hapus
    $sql_gejala = "DELETE FROM gejala WHERE id_gejala=$id_gejala";
    $query_gejala = mysqli_query($conn, $sql_gejala);

    $sql_pengetahuan = "DELETE FROM pengetahuan WHERE id_gejala=$id_gejala";
    $query_pengetahuan = mysqli_query($conn, $sql_pengetahuan);

    if( $query_gejala &&  $query_pengetahuan){
        header('Location: view.php?status=sukses');
    } else {
        // kalau gagal tampilkan pesan
        die('Location: view.php?status=gagal');
    }


}


?>