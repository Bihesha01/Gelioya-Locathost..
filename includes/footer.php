<footer class="site-footer mt-5">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-6">
                <h5>Local Tourist Day-Visit Planner</h5>
                <p class="mb-0">Discover attractions, explore the map and build a practical one-day itinerary.</p>
            </div>
            <div class="col-md-3">
                <h6>Quick Links</h6>
                <a href="<?= $basePath ?? '' ?>attractions.php">Attractions</a>
                <a href="<?= $basePath ?? '' ?>map.php">Map</a>
                <a href="<?= $basePath ?? '' ?>planner.php">Plan Your Day</a>
            </div>
            <div class="col-md-2"> <h6>Contact Us</h6> <p class="mb-1"> <strong>Email:</strong><br> <a href="mailto:info@localtouristplannergelioya.lk"> info@localtouristplannergelioya.lk </a> </p>
             <p class="mb-0"> <strong>Phone:</strong><br> <a href="tel:+94812335677"> +94 81 233 5677 </a> </p> </div>
            <div class="col-md-3">
                <h6>Project Area</h6>
                <p class="mb-0">Gelioya &amp; Kandy, Sri Lanka</p>
            </div>
        </div>
        <hr>
        <small>&copy; <?= date('Y') ?> Local Tourist Planner. Academic project.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $basePath ?? '' ?>js/script.js"></script>
</body>
</html>
