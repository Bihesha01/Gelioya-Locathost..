<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Home';
$basePath = '';

$stmt = $pdo->query("SELECT * FROM attractions WHERE featured = 1 ORDER BY id LIMIT 4");
$featured = $stmt->fetchAll();


$mapRows = $pdo->query("SELECT id, name, category, latitude, longitude FROM attractions")->fetchAll();
$homeMapData = array_map(fn($r) => [
    'id' => (int)$r['id'],
    'name' => $r['name'],
    'category' => $r['category'],
    'lat' => (float)$r['latitude'],
    'lng' => (float)$r['longitude'],
], $mapRows);

include __DIR__ . '/includes/header.php';
?>

<main>
    <section class="container py-4 py-lg-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="hero">
                    <div class="hero-content">
                        <span class="badge rounded-pill bg-light text-success mb-3">Kandy District • Sri Lanka</span>
                        <h1>Explore Amazing Destinations</h1>
                        <p>Plan your perfect one-day visit around Gelioya and Kandy with attractions, maps and travel information.</p>
                        <a href="attractions.php" class="btn btn-green btn-lg rounded-pill px-4">Explore Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div style="position:relative; height:100%; min-height:380px; border-radius:24px; overflow:hidden;">
                    <div id="homeMap" style="position:absolute; inset:0;"></div>

                    <a href="map.php" class="btn btn-green rounded-pill px-4"
                       style="position:absolute; left:16px; bottom:16px; z-index:5;">
                       
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container pb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Top Attractions</h2>
            <a href="attractions.php" class="btn btn-outline-success rounded-pill">View All</a>
        </div>

        <div class="row g-4">
            <?php foreach ($featured as $row): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="attraction-card">
                        <img src="<?= e($row['image_url']) ?>" alt="<?= e($row['name']) ?>">
                        <div class="card-body">
                            <span class="badge badge-category rounded-pill mb-2"><?= e($row['category']) ?></span>
                            <h5 class="fw-bold"><?= e($row['name']) ?></h5>
                            <p class="text-muted small mb-3"><?= e(mb_strimwidth($row['description'], 0, 90, '...')) ?></p>
                            <a class="btn btn-sm btn-outline-success rounded-pill" href="attraction.php?id=<?= (int)$row['id'] ?>">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container py-4">
        <div class="feature-panel p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold">Ready to plan your one-day visit?</h2>
                    <p class="text-muted mb-0">Choose several attractions and generate a simple itinerary with suggested visit times.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="planner.php" class="btn btn-green btn-lg rounded-pill px-4">Plan Your Day</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
const homeAttractions = <?= json_encode($homeMapData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
const gelioyaHome = { lat: 7.2056, lng: 80.5970 };

function escapeHtmlHome(str) {
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[m]));
}

function initHomeMap() {
    const map = new google.maps.Map(document.getElementById('homeMap'), {
        center: gelioyaHome,
        zoom: 10,
        mapTypeControl: false,
        streetViewControl: false
    });

   
    const circle = new google.maps.Circle({
        map: map,
        center: gelioyaHome,
        radius: 25000,
        strokeColor: '#16713d',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#8ab99b',
        fillOpacity: 0.15
    });
    map.fitBounds(circle.getBounds());

    const info = new google.maps.InfoWindow();

    
    const centre = new google.maps.Marker({
        map: map,
        position: gelioyaHome,
        title: 'Gelioya',
        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
    });
    centre.addListener('click', () => {
        info.setContent('<strong>Gelioya</strong><br>25 km planning area');
        info.open(map, centre);
    });

   
    homeAttractions.forEach(a => {
        if (!a.lat || !a.lng) return;
        const marker = new google.maps.Marker({
            map: map,
            position: { lat: a.lat, lng: a.lng },
            title: a.name
        });
        marker.addListener('click', () => {
            info.setContent(`
                <strong>${escapeHtmlHome(a.name)}</strong><br>
                ${escapeHtmlHome(a.category)}<br>
                <a href="attraction.php?id=${a.id}">View details</a>
            `);
            info.open(map, marker);
        });
    });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?= htmlspecialchars($googleMapsKey) ?>&callback=initHomeMap"></script>

<?php include __DIR__ . '/includes/footer.php'; ?>