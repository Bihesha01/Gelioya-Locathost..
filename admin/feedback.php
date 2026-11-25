<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$pageTitle = 'Visitor Feedback';
include __DIR__ . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->execute([(int)$_POST['delete_id']]);
    header('Location: feedback.php');
    exit;
}

$rows = $pdo->query(
    "SELECT feedback.*, attractions.name AS attraction_name
     FROM feedback
     JOIN attractions ON attractions.id = feedback.attraction_id
     ORDER BY feedback.created_at DESC"
)->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Visitor Feedback</h1>
        <p class="text-muted mb-0">All feedback submitted by visitors, newest first.</p>
    </div>
</div>

<div class="table-responsive">
<table class="table align-middle">
    <thead>
        <tr>
            <th>Attraction</th>
            <th>Name</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$rows): ?>
        <tr><td colspan="6" class="text-muted">No feedback submitted yet.</td></tr>
    <?php endif; ?>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td class="fw-semibold"><?= e($row['attraction_name']) ?></td>
            <td><?= e($row['name']) ?></td>
            <td><?= str_repeat('★', (int)$row['rating']) ?><?= str_repeat('☆', 5 - (int)$row['rating']) ?></td>
            <td style="max-width:320px;"><?= e($row['comment']) ?></td>
            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
            <td class="text-end">
                <form method="POST" onsubmit="return confirm('Delete this feedback?');">
                    <input type="hidden" name="delete_id" value="<?= (int)$row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php include __DIR__ . '/footer.php'; ?>