<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$attraction = $id ? get_attraction($pdo, $id) : null;

if (!$attraction) {
    http_response_code(404);
    $pageTitle = 'Attraction Not Found';
    $basePath = '';
    include __DIR__ . '/includes/header.php';
    echo '<main class="container py-5"><div class="alert alert-danger">Attraction not found.</div></main>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $name    = trim($_POST['name'] ?? '');
    $rating  = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment = trim($_POST['comment'] ?? '');

    if ($name === '') $errors[] = 'Please enter your name.';
    if (!$rating || $rating < 1 || $rating > 5) $errors[] = 'Please choose a rating from 1 to 5.';
    if ($comment === '') $errors[] = 'Please write a comment.';

    if (!$errors) {
        add_feedback($pdo, $attraction['id'], $name, $rating, $comment);
        header('Location: attraction.php?id=' . $attraction['id'] . '#feedback');
        exit;
    }
}

$feedbackList = get_feedback($pdo, $attraction['id']);
$avgRating    = get_average_rating($pdo, $attraction['id']);

$pageTitle = $attraction['name'];
$basePath = '';

include __DIR__ . '/includes/header.php';
?>

<main class="container py-5">
    <a href="attractions.php" class="text-success text-decoration-none">← Back to Attractions</a>

    <div class="row g-5 mt-1">
        <div class="col-lg-7">
            <img class="detail-image" src="<?= e($attraction['image_url']) ?>" alt="<?= e($attraction['name']) ?>">
        </div>

        <div class="col-lg-5">
            <span class="badge badge-category rounded-pill mb-3"><?= e($attraction['category']) ?></span>
            <h1 class="fw-bold"><?= e($attraction['name']) ?></h1>
            <p class="text-muted"><?= e($attraction['description']) ?></p>

            <div class="row g-3 my-3">
                <div class="col-6">
                    <div class="info-box">
                        <small class="text-muted">Location</small>
                        <div class="fw-semibold">📍 <?= e($attraction['location']) ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-box">
                        <small class="text-muted">Opening Hours</small>
                        <div class="fw-semibold">🕐 <?= e($attraction['opening_hours']) ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-box">
                        <small class="text-muted">Entrance Fee</small>
                        <div class="fw-semibold">🎟 <?= money((float)$attraction['entrance_fee']) ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-box">
                        <small class="text-muted">Suggested Visit</small>
                        <div class="fw-semibold">⏱ <?= (int)$attraction['estimated_visit_minutes'] ?> min</div>
                    </div>
                </div>
            </div>

            <div class="alert alert-success">
                <strong>Safety guidelines</strong><br>
                <?= e($attraction['safety_guidelines']) ?>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="map.php?focus=<?= (int)$attraction['id'] ?>" class="btn btn-outline-success rounded-pill">View on Map</a>
                <a href="planner.php?add=<?= (int)$attraction['id'] ?>" class="btn btn-green rounded-pill">Add to Day Plan</a>
            </div>
        </div>
    </div>

    <section id="feedback" class="mt-5 pt-4 border-top">
        <h3 class="fw-bold">Visitor feedback <?php if ($avgRating): ?>
            <span class="text-muted fs-6">(avg <?= $avgRating ?> / 5, <?= count($feedbackList) ?> reviews)</span>
        <?php endif; ?></h3>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endforeach; ?>

        <form method="POST" class="row g-3 my-3">
            <div class="col-md-6">
                <label class="form-label">Your name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                    <option value="">Select</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?> star<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Comment</label>
                <textarea name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-12">
                <button type="submit" name="submit_feedback" class="btn btn-green rounded-pill">Submit feedback</button>
            </div>
        </form>

        <?php if (!$feedbackList): ?>
            <p class="text-muted">No feedback yet. Be the first to review.</p>
        <?php else: ?>
            <?php foreach ($feedbackList as $fb): ?>
                <div class="border rounded p-3 mb-2">
                    <strong><?= e($fb['name']) ?></strong> — <?= str_repeat('★', (int)$fb['rating']) ?><?= str_repeat('☆', 5 - (int)$fb['rating']) ?>
                    <p class="mb-0 text-muted"><?= e($fb['comment']) ?></p>
                    <small class="text-muted"><?= date('d M Y', strtotime($fb['created_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
