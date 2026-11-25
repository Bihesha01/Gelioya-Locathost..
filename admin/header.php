<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'Admin';

// Current admin page, used to highlight the sidebar link
$currentPage = basename($_SERVER['PHP_SELF']);

function navActive(array $pages): string {
    global $currentPage;
    return in_array($currentPage, $pages, true) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-sidebar a {
            display: block;
            padding: 12px 16px;
            border-left: 4px solid transparent;
            border-radius: 6px;
            transition: background .15s, color .15s;
        }
        .admin-sidebar a:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .admin-sidebar a.active {
            background: #25573b;
            color: #ffffff;
            font-weight: 600;
            border-left-color: #fcc53e;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark" style="background:#FFFAFA;">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="dashboard.php"><h2><b>Tourist Planner Admin</b></h2></a>
        <a class="btn btn-outline-success btn-sm" href="logout.php">Logout</a>
    </div>
</nav>
<div class="container-fluid">
<div class="row">
    <aside class="col-lg-2 admin-sidebar p-3">
        <a href="dashboard.php" class="<?= navActive(['dashboard.php']) ?>">Dashboard</a>
        <a href="attractions.php" class="<?= navActive(['attractions.php', 'edit-attraction.php']) ?>">Manage Attractions</a>
        <a href="add-attraction.php" class="<?= navActive(['add-attraction.php']) ?>">Add Attraction</a>
        <a href="feedback.php" class="<?= navActive(['feedback.php']) ?>">Feedback</a>
        <a href="../home.php" target="_blank" rel="noopener">View Website ↗</a>
    </aside>
    <section class="col-lg-10 p-4 p-lg-5">