<?php
// /inc/db.php

$db_file = __DIR__ . '/../database/data.sqlite';

try {
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT CHECK(role IN ('admin', 'user')) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS files (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            filename TEXT NOT NULL,
            md5 TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            added_by TEXT NOT NULL,
            date_added TEXT DEFAULT CURRENT_TIMESTAMP
        );
    ");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>