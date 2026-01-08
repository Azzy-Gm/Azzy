<?php
include "auth.php";
include "koneksi.php";

$series = mysqli_query($conn, "
    SELECT j.*,
    (SELECT COUNT(*) FROM videos v WHERE v.judul_id = j.id) AS total_eps
    FROM judul j
    ORDER BY j.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home | Wibuku</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/istri2.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="home.php">▶ Wibuku</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav me-auto">
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

            <!-- CLOCK -->
            <span class="text-white me-3" id="clock">00:00:00</span>

            <!-- USER -->
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

    <div class="home-card">
        <h3>👋 Selamat Datang, <?= $_SESSION['user']; ?></h3>
        <p class="text-muted mb-3">
            [!IMPORTANT] Web ini hanya hasil gabut, selamat menjelajahi.
        </p>

        <div class="d-flex gap-2 flex-wrap">
            <a href="video.php" class="btn btn-primary">🎬 Lihat Video Lainnya</a>
            <a href="search.php" class="btn btn-outline-secondary">🔍 Cari Video</a>
        </div>
    </div>

    <div class="mt-5">
    <h5 class="mb-3">Judul film</h5>

<div class="row g-4">
<?php while ($s = mysqli_fetch_assoc($series)) { ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <a href="judul.php?id=<?= $s['id']; ?>" class="text-decoration-none">
            <div class="card series-card h-100">

                <img src="img/<?= htmlspecialchars($s['thumbnail']); ?>"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($s['judul']); ?>">

                <div class="card-body">
                    <h6 class="fw-bold mb-1">
                        <?= htmlspecialchars($s['judul']); ?>
                    </h6>
                    <div class="text-muted small">
                        <?= $s['total_eps']; ?> Episode
                    </div>
                </div>

            </div>
        </a>
    </div>
<?php } ?>
    </div>
</div>


</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/liat-jam-kon.js"></script>

</body>
</html>
