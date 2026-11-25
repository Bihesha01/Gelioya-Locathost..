<?php
$pageTitle = 'Dashboard';
include __DIR__ . '/header.php';

$count = (int)$pdo->query("SELECT COUNT(*) FROM attractions")->fetchColumn();
$featured = (int)$pdo->query("SELECT COUNT(*) FROM attractions WHERE featured = 1")->fetchColumn();
$categories = (int)$pdo->query("SELECT COUNT(DISTINCT category) FROM attractions")->fetchColumn();
$feedbackCount = (int)$pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn();

?>

<h1 class="fw-bold">Dashboard</h1>
<p class="text-muted">Welcome, <?= e($_SESSION['admin_name'] ?? 'Administrator') ?>.</p>

<div class="row g-4 mt-2">
    <div class="col-md-3">
        <div class="feature-panel p-4">
            <small class="text-muted">Total Attractions</small>
            <div class="display-5 fw-bold"><?= $count ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="feature-panel p-4">
            <small class="text-muted">Featured Attractions</small>
            <div class="display-5 fw-bold"><?= $featured ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="feature-panel p-4">
            <small class="text-muted">Categories</small>
            <div class="display-5 fw-bold"><?= $categories ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <a href="feedback.php" class="text-decoration-none text-reset">
            <div class="feature-panel p-4">
                <small class="text-muted">Visitor Feedback</small>
                <div class="display-5 fw-bold"><?= $feedbackCount ?></div>
            </div>
        </a>
    </div>
</div>

<div class="mt-5">
    <a href="add-attraction.php" class="btn btn-green rounded-pill">+ Add New Attraction</a>
    <a href="attractions.php" class="btn btn-outline-success rounded-pill">Manage Attractions</a>
    <a href="feedback.php" class="btn btn-outline-success rounded-pill">View Feedback</a>
</div>
<?php include __DIR__ . '/footer.php'; ?>
