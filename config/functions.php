<?php
declare(strict_types=1);

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function money(float $amount): string {
    return $amount <= 0 ? 'Free' : 'Rs. ' . number_format($amount, 0);
}

function get_categories(PDO $pdo): array {
    return $pdo->query("SELECT DISTINCT category FROM attractions ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
}

function get_attraction(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM attractions WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function distance_km(float $lat1, float $lon1, float $lat2, float $lon2): float {
    $earth = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) ** 2
       + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
       * sin($dLon / 2) ** 2;
    return $earth * 2 * atan2(sqrt($a), sqrt(1 - $a));
}
function add_feedback(PDO $pdo, int $attractionId, string $name, int $rating, string $comment): void {
    $stmt = $pdo->prepare(
        "INSERT INTO feedback (attraction_id, name, rating, comment) VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$attractionId, $name, $rating, $comment]);
}

function get_feedback(PDO $pdo, int $attractionId): array {
    $stmt = $pdo->prepare(
        "SELECT * FROM feedback WHERE attraction_id = ? ORDER BY created_at DESC"
    );
    $stmt->execute([$attractionId]);
    return $stmt->fetchAll();
}

function get_average_rating(PDO $pdo, int $attractionId): ?float {
    $stmt = $pdo->prepare(
        "SELECT AVG(rating) FROM feedback WHERE attraction_id = ?"
    );
    $stmt->execute([$attractionId]);
    $avg = $stmt->fetchColumn();
    return $avg !== null ? round((float)$avg, 1) : null;
}
