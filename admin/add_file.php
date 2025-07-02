<?php
// /admin/add_file.php
require_once '../inc/db.php';
require_once '../inc/auth.php';
requireLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = trim($_POST['filename']);
    $md5 = trim($_POST['md5']);
    $password = trim($_POST['password']);
    $added_by = $_SESSION['username'];

    if ($filename && $md5 && $password) {
        $stmt = $pdo->prepare("INSERT INTO files (filename, md5, password, added_by) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$filename, $md5, $password, $added_by]);
            $message = "✅ File entry added!";
        } catch (PDOException $e) {
            $message = "❌ Error: " . $e->getMessage();
        }
    } else {
        $message = "❌ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New File</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New File</h1>
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="filename" placeholder="File Name" required><br>
            <input type="text" name="md5" placeholder="MD5 Hash" required><br>
            <input type="text" name="password" placeholder="File Password" required><br>
            <button type="submit">Add File</button>
        </form>
        <p><a href="dashboard.php">⬅️ Back to Dashboard</a></p>
    </div>
</body>
</html>