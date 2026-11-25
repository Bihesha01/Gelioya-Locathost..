<?php
$pageTitle = 'Add Attraction';
include __DIR__ . '/header.php';

$row = [];
$error = '';

// Get categories from the categories table
$categoryStmt = $pdo->query(
    "SELECT id, name FROM categories ORDER BY name"
);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = $_POST;

    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);

    // Find the selected category name
    $categoryStmt = $pdo->prepare(
        "SELECT name FROM categories WHERE id = ?"
    );
    $categoryStmt->execute([$category_id]);
    $category_name = $categoryStmt->fetchColumn();

    if ($name === '' || !$category_name) {
        $error = 'Please enter an attraction name and select a valid category.';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO attractions
            (
                name, category, category_id, description, location,
                latitude, longitude, opening_hours, entrance_fee,
                estimated_visit_minutes, safety_guidelines, image_url,
                featured
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $name,
            $category_name,
            $category_id,
            trim($_POST['description'] ?? ''),
            trim($_POST['location'] ?? ''),
            (float)($_POST['latitude'] ?? 0),
            (float)($_POST['longitude'] ?? 0),
            trim($_POST['opening_hours'] ?? ''),
            (float)($_POST['entrance_fee'] ?? 0),
            (int)($_POST['estimated_visit_minutes'] ?? 90),
            trim($_POST['safety_guidelines'] ?? ''),
            trim($_POST['image_url'] ?? ''),
            isset($_POST['featured']) ? 1 : 0
        ]);

        header('Location: attractions.php');
        exit;
    }
}
?>

<h1 class="fw-bold">Add Attraction</h1>
<p class="text-muted">Create a new attraction record.</p>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= e($error) ?>
    </div>
<?php endif; ?>

<form method="post" class="feature-panel p-4">
    <div class="row g-3">

        <div class="col-md-8">
            <label class="form-label">Attraction Name</label>
            <input
                name="name"
                class="form-control"
                required
                value="<?= e($row['name'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>

                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?= (int)$category['id'] ?>"
                        <?= ((int)($row['category_id'] ?? 0) === (int)$category['id']) ? 'selected' : '' ?>>
                        <?= e($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea
                name="description"
                class="form-control"
                rows="4"
                required><?= e($row['description'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Location</label>
            <input
                name="location"
                class="form-control"
                required
                value="<?= e($row['location'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Latitude</label>
            <input
                type="number"
                step="0.0000001"
                name="latitude"
                class="form-control"
                required
                value="<?= e((string)($row['latitude'] ?? '')) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Longitude</label>
            <input
                type="number"
                step="0.0000001"
                name="longitude"
                class="form-control"
                required
                value="<?= e((string)($row['longitude'] ?? '')) ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Opening Hours</label>
            <input
                name="opening_hours"
                class="form-control"
                value="<?= e($row['opening_hours'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Entrance Fee (Rs.)</label>
            <input
                type="number"
                step="0.01"
                name="entrance_fee"
                class="form-control"
                value="<?= e((string)($row['entrance_fee'] ?? '0')) ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Estimated Visit (minutes)</label>
            <input
                type="number"
                name="estimated_visit_minutes"
                class="form-control"
                value="<?= e((string)($row['estimated_visit_minutes'] ?? '90')) ?>">
        </div>

        <div class="col-12">
            <label class="form-label">Safety Guidelines</label>
            <textarea
                name="safety_guidelines"
                class="form-control"
                rows="3"><?= e($row['safety_guidelines'] ?? '') ?></textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Image URL</label>
            <input
                type="url"
                name="image_url"
                class="form-control"
                value="<?= e($row['image_url'] ?? '') ?>">
        </div>

        <div class="col-12">
            <div class="form-check">
                <input
                    type="checkbox"
                    name="featured"
                    value="1"
                    class="form-check-input"
                    id="featured"
                    <?= !empty($row['featured']) ? 'checked' : '' ?>>

                <label class="form-check-label" for="featured">
                    Show on Home page as a featured attraction
                </label>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-green rounded-pill">
            Save Attraction
        </button>

        <a href="attractions.php"
           class="btn btn-outline-secondary rounded-pill">
            Cancel
        </a>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>