<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Attractions';
$basePath = '';

$category = trim($_GET['category'] ?? '');
$search = trim($_GET['search'] ?? '');

$sql = "SELECT * FROM attractions WHERE 1=1";
$params = [];

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
}
if ($search !== '') {
    $sql .= " AND (name LIKE ? OR location LIKE ? OR description LIKE ?)";
    $term = "%{$search}%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
}
$sql .= " ORDER BY featured DESC, name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$attractions = $stmt->fetchAll();
$categories = get_categories($pdo);

include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1 class="fw-bold">Explore Attractions</h1>
        <p class="mb-0">Find Religious, heritage, nature and adventure places around Kandy.</p>
    </div>
</section>

<main class="container py-5">
    <form class="row g-2 mb-4" method="get">
        <div class="col-lg-6">
            <input id="liveSearch" name="search" value="<?= e($search) ?>" class="form-control form-control-lg" placeholder="Search attractions...">
        </div>
        <div class="col-lg-3">
            <select name="category" class="form-select form-select-lg">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-3">
            <button class="btn btn-green btn-lg w-100">Search</button>
        </div>
    </form>

    <div class="row g-4">
        <?php if (!$attractions): ?>
            <div class="col-12">
                <div class="alert alert-warning">No attractions found.</div>
            </div>
        <?php endif; ?>

        <?php foreach ($attractions as $row): ?>
            <div class="col-12 col-md-6 col-lg-4 attraction-column">
                <div class="attraction-card" data-attraction-card>
                    <img src="<?= e($row['image_url']) ?>" alt="<?= e($row['name']) ?>">
                    <div class="card-body">
                        <span class="badge badge-category rounded-pill mb-2"><?= e($row['category']) ?></span>
                        <h5 class="fw-bold"><?= e($row['name']) ?></h5>
                        <p class="text-muted"><?= e(mb_strimwidth($row['description'], 0, 145, '...')) ?></p>
                        <div class="small text-muted mb-3">
                            📍 <?= e($row['location']) ?> · ⏱ <?= (int)$row['estimated_visit_minutes'] ?> min
                        </div>
                        <a href="attraction.php?id=<?= (int)$row['id'] ?>" class="btn btn-outline-success rounded-pill">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
