<?php
    session_start();
    include "koneksi.php";
    //dapatkan data user dari form
    $user = [
    	'username' => $_POST['user'],
    	'password' => $_POST['pass'],
    ];
    //check apakah user tersebut ada di table users
    $query = "select * from user where username = ? and password = ? limit 1";
    $stmt = $conn->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('ss', $user['username'], $user['password']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_NUM);
    if($row != null){
    	$_SESSION['login'] = true;
    	$_SESSION['username'] =  $user['username'];
    	$_SESSION['message']  = 'Berhasil login ke dalam sistem.';
    	header("Location: index.php");
    }else{
    	$_SESSION['error'] = 'Username dan password anda tidak ditemukan.';
    	header("Location: login.php");
    }
?>