<?php
include "auth.php";
include "koneksi.php";

/* VALIDASI ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Video tidak ditemukan");
}
$id = (int)$_GET['id'];

/* VIDEO UTAMA */
$q = mysqli_query($conn, "
    SELECT 
        v.*, 
        j.folder_judul, 
        j.judul AS judul_film, 
        j.description
    FROM videos v
    JOIN judul j ON v.judul_id = j.id
    WHERE v.id = $id
");

$v = mysqli_fetch_assoc($q);
if (!$v) {
    die("Video tidak ditemukan");
}

$judul_id = $v['judul_id'];
$episode  = $v['episode'];

/* NEXT EPISODE */
$nextEp = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT id FROM videos 
    WHERE judul_id = $judul_id AND episode > $episode
    ORDER BY episode ASC LIMIT 1
"));

/* PREV EPISODE */
$prevEp = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT id FROM videos 
    WHERE judul_id = $judul_id AND episode < $episode
    ORDER BY episode DESC LIMIT 1
"));

/* VIDEO LAIN */
$other = mysqli_query($conn, "
    SELECT 
        v.id, v.filename, v.episode,
        j.folder_judul, j.judul AS judul_film
    FROM videos v
    JOIN judul j ON v.judul_id = j.id
    WHERE v.id != $id
    ORDER BY v.id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($v['judul_film']); ?> - Episode <?= $episode; ?> | Wibuku</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/istri2.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="video.php">▶ Wibuku</a>
    </div>
</nav>

<div class="container-fluid mt-3">
<div class="row">

<!-- VIDEO UTAMA -->
<div class="col-lg-8">

    <div class="ratio ratio-16x9 mb-3">
        <video controls autoplay muted>
            <source src="vid/<?= htmlspecialchars($v['folder_judul']); ?>/<?= htmlspecialchars($v['filename']); ?>" type="video/mp4">
        </video>
    </div>

    <h5 class="fw-bold">
        <?= htmlspecialchars($v['judul_film']); ?> — Ep <?= (int)$episode; ?>
    </h5>

    <div class="text-muted small mb-3">Wibuku</div>

    <!-- NAV EPISODE -->
    <div class="d-flex gap-2 mb-3">
        <?php if ($prevEp) { ?>
            <a href="nontonnya.php?id=<?= $prevEp['id']; ?>" class="btn btn-outline-secondary btn-sm">
                ⏮ Episode Sebelumnya
            </a>
        <?php } ?>

        <?php if ($nextEp) { ?>
            <a href="nontonnya.php?id=<?= $nextEp['id']; ?>" class="btn btn-primary btn-sm">
                ▶ Episode Selanjutnya
            </a>
        <?php } ?>
    </div>

    <hr>

    <p class="text-muted">
        <?= nl2br(htmlspecialchars($v['description'])); ?>
    </p>

</div>

<!-- SIDEBAR -->
<div class="col-lg-4">

    <h6 class="mb-2">📂 Daftar Episode</h6>

    <?php
    $list = mysqli_query($conn, "
        SELECT id, episode 
        FROM videos 
        WHERE judul_id = $judul_id
        ORDER BY episode ASC
    ");
    while ($e = mysqli_fetch_assoc($list)) {
    ?>
        <a href="nontonnya.php?id=<?= $e['id']; ?>"
           class="d-block mb-2 <?= $e['id']==$id?'fw-bold text-primary':'' ?>">
           Episode <?= $e['episode']; ?>
        </a>
    <?php } ?>

    <hr>

    <h6 class="mb-3">📌 Video Lainnya</h6>

    <?php while ($r = mysqli_fetch_assoc($other)) { ?>
        <a href="nontonnya.php?id=<?= $r['id']; ?>" class="text-decoration-none text-dark">
            <div class="d-flex mb-3 video-side">
                <video class="side-thumb me-2" muted preload="metadata">
                    <source src="vid/<?= htmlspecialchars($r['folder_judul']); ?>/<?= htmlspecialchars($r['filename']); ?>" type="video/mp4">
                </video>
                <div>
                    <div class="side-title">
                        <?= htmlspecialchars($r['judul_film']); ?>
                        <small class="text-muted">Ep <?= $r['episode']; ?></small>
                    </div>
                    <div class="text-muted small">Wibuku</div>
                </div>
            </div>
        </a>
    <?php } ?>

</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
