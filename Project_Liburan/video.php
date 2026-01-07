<?php
include "auth.php";
include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>List Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>Daftar Video</h3>
<a href='home.php'>⬅ Kembali</a>

<hr>

<?php
$q = mysqli_query($conn, "SELECT * FROM videos");

while ($v = mysqli_fetch_assoc($q)) {
    echo "
    <center>
    <h4>{$v['title']}</h4>
    <video width='400' controls preload='metadata'>
    <source src='vid/{$v['title']}' type='video/mp4'>
    </video>
    <hr>
    ";
}
?>

</body>
</html>