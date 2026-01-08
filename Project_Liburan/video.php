<?php
include "auth.php";
include "koneksi.php";

$limit = 8;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* DATA VIDEO + FOLDER */
$q = mysqli_query($conn, "
    SELECT 
        v.id,
        v.judul_id,
        v.filename,
        v.judul AS judul_video,
        v.uploaded_at,
        s.folder_judul,
        s.judul AS judul_film
    FROM videos v
    JOIN judul s ON v.judul_id = s.id
    ORDER BY v.uploaded_at DESC
    LIMIT $start, $limit
");

/* TOTAL DATA */
$total = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM videos")
);

$pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<title>List Video | Wibuku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/istri2.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        
        <!-- LOGO -->
        <a class="navbar-brand fw-bold" href="home.php">
            ▶ Wibuku
        </a>

        <!-- TOGGLE MOBILE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- LEFT MENU -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="video.php">List Video</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>
            </ul>

            <!-- SEARCH BAR -->
            <form class="d-flex me-3" method="GET" action="search.php">
                <input class="form-control form-control-sm me-2"
                       type="search"
                       name="q"
                       placeholder="Cari video...">
                <button class="btn btn-outline-light btn-sm">Search</button>
            </form>

            <!-- USER -->
            <div class="dropdown">
                <a class="btn btn-outline-light btn-sm dropdown-toggle"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown">
                    <?= $_SESSION['user']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<div class="container mt-4">
<div class="row g-4">

<?php while ($v = mysqli_fetch_assoc($q)) { ?>
<div class="col-lg-3 col-md-4 col-sm-6">
<a href="judul.php?id=<?= (int)$v['judul_id']; ?>" class="text-decoration-none text-dark">
    <div class="video-card">
        <video class="video-thumb" muted preload="metadata" playsinline>
            <source src="vid/<?= $v['folder_judul']; ?>/<?= $v['filename']; ?>" type="video/mp4">
        </video>
        <div class="video-title">
    <?= htmlspecialchars($v['judul_film']); ?><br>
    <small class="text-muted"><?= htmlspecialchars($v['judul_video']); ?></small>
</div>
    </div>
</a>
</div>
<?php } ?>

</div>

<!-- PAGINATION -->
<div class="mt-4 text-center">
<?php for ($i=1; $i<=$pages; $i++) { ?>
    <a class="btn btn-outline-primary btn-sm" href="?page=<?= $i ?>"><?= $i ?></a>
<?php } ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/istri2.js"></script>

</body>
</html>
