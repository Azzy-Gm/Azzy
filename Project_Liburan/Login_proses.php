<?php
session_start();
include "koneksi.php";

$user = $_POST['username'];
$pass = $_POST['password'];

$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
$data = mysqli_fetch_assoc($q);

if ($data && password_verify($pass, $data['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['user'] = $data['username'];
    header("Location: home.php");
    exit;
} else {
    echo "Login gagal!";
}
