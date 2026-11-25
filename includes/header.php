<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Local Tourist Day-Visit Planner';
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | Local Tourist Planner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= $basePath ?? '' ?>css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg site-nav sticky-top">
     <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= $basePath ?? '' ?>home.php">
            <img src="<?= $basePath ?? '' ?>Images/logo-icon.png" alt="Local Tourist Planner logo" class="brand-logo" width="36" height="36">
            Local Tourist Planner
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'home.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'attractions.php' || $currentPage === 'attraction.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>attractions.php">Attractions</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'map.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>map.php">Map</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'planner.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>planner.php">Plan Your Day</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'travel-tips.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>travel-tips.php">Travel Tips</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'about.php' ? 'active' : '' ?>" href="<?= $basePath ?? '' ?>about.php">About Us</a></li>
            </ul>
        </div>
    </div>
</nav>
