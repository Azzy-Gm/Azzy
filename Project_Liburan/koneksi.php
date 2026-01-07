<?php
$conn = mysqli_connect("localhost", "root", "", "projectvscode");

if (!$conn) {
    die("Koneksi gagal: ".mysqli_connect_eror());
}