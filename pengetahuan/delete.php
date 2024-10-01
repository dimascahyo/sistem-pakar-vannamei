<?php

require '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengetahuan = $_GET['id'];

    // buat query hapus
    $sql = "DELETE FROM pengetahuan WHERE id_pengetahuan=$id_pengetahuan";
    $query = mysqli_query($conn, $sql);

    if( $query ){
        header('Location: view.php?status=sukses');
    } else {
        // kalau gagal tampilkan pesan
        die('Location: view.php?status=gagal');
    }


}


?>