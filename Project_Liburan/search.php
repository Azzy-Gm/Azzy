<?php
include "auth.php";
include "koneksi.php";

$keyword = '';
$result  = null;

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $keyword = mysqli_real_escape_string($conn, $_GET['q']);

   $result = mysqli_query($conn, "
    SELECT
        v.id,
        v.filename,
        v.judul AS judul_video,
        j.folder_judul,
        j.judul AS judul_film
    FROM videos v
    JOIN judul j ON v.judul_id = j.id
    WHERE v.judul LIKE '%$keyword%'
       OR j.judul LIKE '%$keyword%'
    ORDER BY j.judul ASC, v.episode ASC
");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Search Video | Wibuku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/istri2.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="home.php">▶ Wibuku</a>

        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="video.php">List Video</a></li>
                <li class="nav-item"><a class="nav-link active" href="search.php">Search</a></li>
            </ul>

            <form class="d-flex me-3" method="GET">
                <input class="form-control form-control-sm me-2"
                       type="search"
                       name="q"
                       placeholder="Cari judul / episode..."
                       value="<?= htmlspecialchars($keyword); ?>">
                <button class="btn btn-outline-light btn-sm">Search</button>
            </form>

            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <?= $_SESSION['user']; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <h5 class="mb-3">🔍 Hasil Pencarian</h5>

    <?php if ($keyword === '') { ?>
        <div class="alert alert-info">
            Ketik judul film atau episode untuk mencari
        </div>
    <?php } ?>

    <div class="row g-4">

    <?php
    if ($keyword !== '') {

        if (mysqli_num_rows($result) === 0) {
            echo "<div class='alert alert-warning'>Video tidak ditemukan</div>";
        }

        while ($v = mysqli_fetch_assoc($result)) {
    ?>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <a href="nontonnya.php?id=<?= $v['id']; ?>" class="text-decoration-none text-dark">
                <div class="video-card">

                    <video class="video-thumb" muted preload="metadata" playsinline>
                        <source src="vid/<?= htmlspecialchars($v['folder_judul']); ?>/<?= htmlspecialchars($v['filename']); ?>" type="video/mp4">
                    </video>
                    
                    <div class="video-title mt-2">
                        <?= htmlspecialchars($v['judul_film']); ?><br>
                        <small class="text-muted">
                            <?= htmlspecialchars($v['judul_video']); ?>
                        </small>
                    </div>

                </div>
            </a>
        </div>
    <?php
        }
    }
    ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/istri2.js"></script>
</body>
</html>
