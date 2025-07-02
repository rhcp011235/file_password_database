<?php
// /admin/edit_file.php
require_once '../inc/db.php';
require_once '../inc/auth.php';
requireLogin();

// Handle delete
if (isset($_GET['delete']) && isAdmin()) {
    $fileId = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM files WHERE id = ?")->execute([$fileId]);
    header('Location: edit_file.php');
    exit();
}

$files = $pdo->query("SELECT * FROM files ORDER BY date_added DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Files</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Files</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Filename</th>
                <th>MD5</th>
                <th>Password</th>
                <th>Added By</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($files as $file): ?>
            <tr>
                <td><?= $file['id'] ?></td>
                <td><?= htmlspecialchars($file['filename']) ?></td>
                <td><?= htmlspecialchars($file['md5']) ?></td>
                <td><?= htmlspecialchars($file['password']) ?></td>
                <td><?= htmlspecialchars($file['added_by']) ?></td>
                <td>
                    <?php if (isAdmin()): ?>
                        <a href="?delete=<?= $file['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="dashboard.php">⬅️ Back to Dashboard</a></p>
    </div>
</body>
</html>