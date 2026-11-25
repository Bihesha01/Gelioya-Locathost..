<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

$pageTitle = 'Travel Tips';
$basePath = '';
include __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1 class="fw-bold">Travel Tips</h1>
        <p class="mb-0">Simple information to help visitors enjoy a safe day trip.</p>
    </div>
</section>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>🛕 Cultural Etiquette</h4>
                <p class="text-muted">Dress respectfully when visiting religious sites. Follow instructions about footwear, photography and behaviour.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>🚌 Transport</h4>
                <p class="text-muted">Plan travel time between attractions. Buses, tuk-tuks and private vehicles can be used depending on the route.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>💧 Stay Hydrated</h4>
                <p class="text-muted">Carry drinking water, especially when walking around gardens, forests and outdoor attractions.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>🌧 Weather</h4>
                <p class="text-muted">Check local weather before travelling and carry suitable rain protection for outdoor destinations.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>📱 Emergency Preparation</h4>
                <p class="text-muted">Keep your phone charged and save important contacts before leaving for a full-day trip.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="feature-panel p-4 h-100">
                <h4>🥾 Comfortable Shoes</h4>
                <p class="text-muted">Some attractions contain stairs, uneven paths or walking trails, so comfortable footwear is recommended.</p>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
