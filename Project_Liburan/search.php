<?php
include "auth.php";
include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Video</title>
</head>
<body>

<h2>Cari Video</h2>
<a href="home.php">⬅ Kembali</a>

<hr>

<form method="GET">
    <input type="text" name="q" placeholder="Judul video">
    <button>Cari</button>
</form>

<hr>

<?php
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $sql = mysqli_query($conn,
        "SELECT * FROM videos WHERE title LIKE '%$q%'");

    while ($v = mysqli_fetch_assoc($sql)) {
        echo "
        <p>{$v['title']}</p>
        <video width='300' controls preload='metadata'>
            <source src='vid/{$v['filename']}' type='video/mp4'>
        </video>
        <hr>
        ";
    }
}
?>

</body>
</html>