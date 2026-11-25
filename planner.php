<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Plan Your Day';
$basePath = '';

$all = $pdo->query("SELECT * FROM attractions ORDER BY featured DESC, name ASC")->fetchAll();

$selectedIds = $_POST['attractions'] ?? [];
if (!is_array($selectedIds)) {
    $selectedIds = [];
}

$selectedIds = array_values(array_unique(array_filter(array_map('intval', $selectedIds))));

$addId = filter_input(INPUT_GET, 'add', FILTER_VALIDATE_INT);
if ($addId && !in_array($addId, $selectedIds, true)) {
    $selectedIds[] = $addId;
}

$selected = [];
foreach ($all as $row) {
    if (in_array((int)$row['id'], $selectedIds, true)) {
        $selected[] = $row;
    }
}

$plan = [];
$startMinutes = 8 * 60 + 30;
$lunchInserted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($selected) > 0) {
    foreach ($selected as $index => $row) {
        if (!$lunchInserted && $startMinutes >= 12 * 60) {
            $plan[] = [
                'type' => 'break',
                'time' => '12:30 PM',
                'name' => 'Lunch / Rest Break',
                'description' => 'Use this time for lunch and a short rest.'
            ];
            $startMinutes = 13 * 60;
            $lunchInserted = true;
        }

        $hour = intdiv($startMinutes, 60);
        $minute = $startMinutes % 60;
        $time = date('g:i A', mktime($hour, $minute));

        $plan[] = [
            'type' => 'attraction',
            'time' => $time,
            'name' => $row['name'],
            'description' => $row['location'] . ' · ' . $row['estimated_visit_minutes'] . ' min'
        ];

        $startMinutes += (int)$row['estimated_visit_minutes'] + 30;
    }

    if (!$lunchInserted && $startMinutes > 12 * 60) {
        $plan[] = [
            'type' => 'break',
            'time' => '12:30 PM',
            'name' => 'Lunch / Rest Break',
            'description' => 'Use this time for lunch and a short rest.'
        ];
    }
}

include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1 class="fw-bold">Plan Your One-Day Visit</h1>
        <p class="mb-0">Select attractions and generate a simple itinerary.</p>
    </div>
</section>

<main class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0">Choose Attractions</h3>
                <span class="badge text-bg-success" id="selectedCount">0 selected</span>
            </div>

            <form method="post" id="plannerForm">
                <?php foreach ($all as $row): ?>
                    <label class="planner-item">
                        <input
                            class="form-check-input planner-checkbox"
                            type="checkbox"
                            name="attractions[]"
                            value="<?= (int)$row['id'] ?>"
                            <?= in_array((int)$row['id'], $selectedIds, true) ? 'checked' : '' ?>
                        >
                        <img src="<?= e($row['image_url']) ?>" alt="">
                        <span class="flex-grow-1">
                            <strong><?= e($row['name']) ?></strong><br>
                            <small class="text-muted"><?= e($row['category']) ?> · <?= e($row['location']) ?></small>
                        </span>
                    </label>
                <?php endforeach; ?>

                <button class="btn btn-green btn-lg rounded-pill w-100 mt-2" type="submit">
                    Generate Plan
                </button>
            </form>
        </div>

        <div class="col-lg-6">
            <div class="feature-panel p-4">
                <h3 class="fw-bold mb-4">Your One-Day Itinerary</h3>

                <?php if (!$plan): ?>
                    <div class="text-center py-5">
                        <div style="font-size:3rem">🗺️</div>
                        <h5 class="fw-bold mt-3">Your plan will appear here</h5>
                        <p class="text-muted">Select at least one attraction and click Generate Plan.</p>
                    </div>
                <?php else: ?>
                    <div class="timeline">
                        <?php foreach ($plan as $item): ?>
                            <div class="timeline-item">
                                <small class="text-success fw-bold"><?= e($item['time']) ?></small>
                                <h5 class="fw-bold mb-1"><?= e($item['name']) ?></h5>
                                <p class="text-muted mb-0"><?= e($item['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a href="map.php" class="btn btn-outline-success rounded-pill">View Attractions on Map</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
const checkboxes = document.querySelectorAll('.planner-checkbox');
const count = document.getElementById('selectedCount');

function updateCount() {
    const selected = document.querySelectorAll('.planner-checkbox:checked').length;
    count.textContent = selected + (selected === 1 ? ' selected' : ' selected');
}
checkboxes.forEach(c => c.addEventListener('change', updateCount));
updateCount();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
