<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Interactive Map';
$basePath = '';

$rows = $pdo->query("SELECT * FROM attractions ORDER BY name")->fetchAll();
$focus = filter_input(INPUT_GET, 'focus', FILTER_VALIDATE_INT);

$mapData = array_map(function($r) {
    return [
        'id' => (int)$r['id'],
        'name' => $r['name'],
        'category' => $r['category'],
        'location' => $r['location'],
        'lat' => (float)$r['latitude'],
        'lng' => (float)$r['longitude'],
        'image' => $r['image_url']
    ];
}, $rows);

include __DIR__ . '/includes/header.php';
?>

<style>
    #map { width: 100%; height: 600px; border-radius: 16px; }
</style>

<main class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1">Interactive Tourist Map</h1>
            <p class="text-muted mb-0">Attractions within 25 km of Gelioya are highlighted in the list.</p>
        </div>
        <a href="planner.php" class="btn btn-green rounded-pill">Plan Your Day</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div id="map"></div>
        </div>

        <div class="col-lg-4">
            <div class="feature-panel p-3">
                <h5 class="fw-bold">Attractions within 25 km</h5>
                <p class="small text-muted">Click an item to focus the map.</p>
                <div id="nearbyList"></div>
            </div>
        </div>
    </div>
</main>

<script>
const attractions = <?= json_encode($mapData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
const focusId = <?= $focus ? (int)$focus : 'null' ?>;

const gelioya = { lat: 7.2056, lng: 80.5970 };
const radiusKm = 25;

let map;
const markers = {};

function haversine(lat1, lon1, lat2, lon2) {
    const R = 6371, rad = Math.PI / 180;
    const dLat = (lat2 - lat1) * rad;
    const dLon = (lon2 - lon1) * rad;
    const a = Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * rad) * Math.cos(lat2 * rad) * Math.sin(dLon / 2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[m]));
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: gelioya,
        zoom: 11
    });

   
    new google.maps.Circle({
        map: map,
        center: gelioya,
        radius: radiusKm * 1000,
        strokeColor: '#16713d',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#8ab99b',
        fillOpacity: 0.10
    });


    const gelioyaMarker = new google.maps.Marker({
        map: map,
        position: gelioya,
        title: 'Gelioya',
        icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
    });

    const info = new google.maps.InfoWindow();

    gelioyaMarker.addListener('click', () => {
        info.setContent('<strong>Gelioya</strong><br>Planning reference point');
        info.open(map, gelioyaMarker);
    });

    const nearby = [];

    attractions.forEach(a => {
        const distance = haversine(gelioya.lat, gelioya.lng, a.lat, a.lng);

        const marker = new google.maps.Marker({
            map: map,
            position: { lat: a.lat, lng: a.lng },
            title: a.name
        });
        markers[a.id] = marker;

        marker.addListener('click', () => {
            info.setContent(`
                <strong>${escapeHtml(a.name)}</strong><br>
                ${escapeHtml(a.category)}<br>
                ${distance.toFixed(1)} km from Gelioya<br>
                <a href="attraction.php?id=${a.id}">View details</a>
            `);
            info.open(map, marker);
        });

        if (distance <= radiusKm) {
            nearby.push({ ...a, distance });
        }

        if (focusId === a.id) {
            setTimeout(() => focusAttraction(a.id), 300);
        }
    });

    nearby.sort((a, b) => a.distance - b.distance);

    const list = document.getElementById('nearbyList');

    if (nearby.length === 0) {
        list.innerHTML = '<div class="alert alert-warning">No attractions found inside the radius.</div>';
    } else {
        nearby.forEach(a => {
            const item = document.createElement('div');
            item.className = 'border rounded-3 p-2 mb-2 bg-white';
            item.innerHTML = `
                <div class="fw-bold">${escapeHtml(a.name)}</div>
                <div class="small text-muted">${escapeHtml(a.category)} · ${a.distance.toFixed(1)} km</div>
                <button class="btn btn-sm btn-outline-success mt-2" onclick="focusAttraction(${a.id})">Show on map</button>
            `;
            list.appendChild(item);
        });
    }
}

function focusAttraction(id) {
    const marker = markers[id];
    if (marker) {
        map.setCenter(marker.getPosition());
        map.setZoom(15);
        google.maps.event.trigger(marker, 'click');
    }
}
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5o98U-7egA_cOk76ZkFQSJxpNF3jasXk&callback=initMap"></script>

<?php include __DIR__ . '/includes/footer.php'; ?>