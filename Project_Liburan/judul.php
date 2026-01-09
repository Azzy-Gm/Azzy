<?php
include "auth.php";
include "koneksi.php";

$id = (int)$_GET['id'];

$series = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM judul WHERE id=$id")
);

$eps = mysqli_query($conn,
    "SELECT * FROM videos 
     WHERE judul_id=$id 
     ORDER BY episode ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($series['judul']); ?> | Wibuku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/istri2.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="home.php">▶ Wibuku</a>
        <a href="video.php" class="btn btn-outline-light btn-sm">⬅ Kembali</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="row mb-4 align-items-center">

        <div class="col-md-4">
            <img src="img/<?= htmlspecialchars($series['thumbnail']); ?>" 
                class="img-fluid rounded shadow"
                alt="<?= htmlspecialchars($series['judul']); ?>">

        </div>

        <div class="col-md-8">
            <h3 class="fw-bold"><?= htmlspecialchars($series['judul']); ?></h3>
            <p class="text-muted">
                <?= nl2br(htmlspecialchars($series['description'])); ?>
            </p>
        </div>

    </div>

    <hr>

    <!-- EPISODE LIST -->
    <h5 class="mb-3">📂 Daftar Episode</h5>

    <div class="list-group shadow-sm">
    <?php while ($e = mysqli_fetch_assoc($eps)) { ?>
        <a href="nontonnya.php?id=<?= $e['id']; ?>"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

            <div>
                <strong>Episode <?= $e['episode']; ?></strong><br>
                <span class="text-muted small">
                    <?= htmlspecialchars($e['filename']); ?>
                </span>
            </div>

            <span class="badge bg-primary rounded-pill">▶</span>
        </a>
    <?php } ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/boots
