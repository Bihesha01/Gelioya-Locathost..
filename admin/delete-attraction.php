<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM attractions WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: attractions.php');
exit;
