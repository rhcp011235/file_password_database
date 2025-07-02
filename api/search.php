<?php
// /api/search.php
require_once '../inc/db.php';
require_once '../inc/env.php';

// Basic API key check
$api_key = $_GET['api_key'] ?? '';
if ($api_key !== $_ENV['APP_SECRET']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$search = trim($_GET['q'] ?? '');

header('Content-Type: application/json');

if (!$search) {
    echo json_encode(['error' => 'Missing search query']);
    exit();
}

$stmt = $pdo->prepare("
    SELECT filename, md5, password, added_by, date_added
    FROM files
    WHERE filename LIKE ? OR md5 LIKE ?
    ORDER BY date_added DESC
    LIMIT 5
");

$wild = '%' . $search . '%';
$stmt->execute([$wild, $wild]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
