<?php
// /admin/dashboard.php
require_once '../inc/db.php';
require_once '../inc/auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</p>

        <ul>
            <li><a href="add_file.php">➕ Add New File</a></li>
            <li><a href="edit_file.php">📝 Manage Files</a></li>
            <?php if (isAdmin()): ?>
                <li><a href="manage_users.php">👥 Manage Users</a></li>
            <?php endif; ?>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>
</body>
</html>