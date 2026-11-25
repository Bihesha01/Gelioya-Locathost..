<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'About Us';
$basePath = '';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1 class="fw-bold">About the System</h1>
        <p class="mb-0">Local Tourist Day-Visit Planner &amp; Information System</p>
    </div>
</section>

<main class="container py-5">
    <div class="row g-5 align-items-center">
        <div class="col-lg-7">
            <h2 class="fw-bold">What is this application?</h2>
            <p class="lead text-muted">
                This web application helps visitors discover tourist attractions around the Kandy area,
                view them on an interactive map and create a practical one-day visit plan.
            </p>
            <p>
                The system combines a MySQL attraction database, PHP server-side processing,
                responsive Bootstrap interfaces and Leaflet map functionality.
            </p>
        </div>
        <div class="col-lg-5">
            <div class="feature-panel p-4">
                <h5 class="fw-bold">Main Functions</h5>
                <ul class="mb-0">
                    <li>Attraction information</li>
                    <li>Search and category filtering</li>
                    <li>25 km map-based attraction view</li>
                    <li>One-day itinerary generation</li>
                    <li>Administrative CRUD operations</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
