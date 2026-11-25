<?php
$pageTitle = 'Manage Attractions';
include __DIR__ . '/header.php';

$rows = $pdo->query("SELECT * FROM attractions ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Manage Attractions</h1>
        <p class="text-muted mb-0">Create, read, update and delete attraction records.</p>
    </div>
    <a href="add-attraction.php" class="btn btn-green rounded-pill">+ Add Attraction</a>
</div>

<div class="table-responsive">
<table class="table align-middle">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Location</th>
            <th>Featured</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><img src="<?= e($row['image_url']) ?>" style="width:70px;height:50px;object-fit:cover;border-radius:8px;"></td>
            <td class="fw-semibold"><?= e($row['name']) ?></td>
            <td><?= e($row['category']) ?></td>
            <td><?= e($row['location']) ?></td>
            <td><?= $row['featured'] ? 'Yes' : 'No' ?></td>
            <td class="text-end">
                <a href="edit-attraction.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-outline-success">Edit</a>
                <a href="delete-attraction.php?id=<?= (int)$row['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   data-confirm="Delete this attraction?">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
