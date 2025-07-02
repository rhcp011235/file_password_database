<?php
// /index.php
require_once './inc/db.php';

$search = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = trim($_POST['search']);

    if ($search) {
        $stmt = $pdo->prepare("
            SELECT filename, md5, password, added_by, date_added
            FROM files
            WHERE filename LIKE ? OR md5 LIKE ?
            ORDER BY date_added DESC
        ");
        $wild = '%' . $search . '%';
        $stmt->execute([$wild, $wild]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Password Search</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>🔍 File Password Lookup</h1>

        <form method="POST">
            <input type="text" name="search" placeholder="Enter Filename or MD5" value="<?= htmlspecialchars($search) ?>" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <h2>Results:</h2>
            <?php if (count($results) > 0): ?>
                <table>
                    <tr>
                        <th>Filename</th>
                        <th>MD5</th>
                        <th>Password</th>
                        <th>Added By</th>
                        <th>Date</th>
                    </tr>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['filename']) ?></td>
                            <td><?= htmlspecialchars($row['md5']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td><?= htmlspecialchars($row['added_by']) ?></td>
                            <td><?= htmlspecialchars($row['date_added']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No matching results found.</p>
            <?php endif; ?>
        <?php endif; ?>

        <button onclick="toggleTheme()">Toggle Dark/Light Mode</button>

        <p style="margin-top: 20px; font-size: 0.9em;">
            <a href="admin/login.php">Admin Login</a>
        </p>
    </div>
</body>
</html>