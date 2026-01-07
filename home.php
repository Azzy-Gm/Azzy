<?php include "auth.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand">Web gabut dihari libur
        <div id="clock">00:00:00</div>
    </span>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
</nav>

<h2>Selamat Datang, <?php echo $_SESSION['user']; ?> 👋</h2>
<p>Login sebagai: <b><?php echo $_SESSION['user']; ?></b></p>
<hr>
    <script>
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById("clock").textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
    </script>

<div class="container mt-4">
    <h4>Menu</h4>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="video.php">List Video</a></li>
        <li><a href="search.php">Search video</a></li>
    </ul>
</div>

</body>
</html>