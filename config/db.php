<?php
// config/db.php

$host   = "localhost";
$dbname = "evara";   // make sure this matches your database
$user   = "root";
$pass   = "20ROOT-MySql";        // XAMPP default is empty password

// ---------- PDO connection (optional, for future pages) ----------
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("PDO connection failed: " . $e->getMessage());
}

// ---------- MySQLi connection (required for Pen and Pencils.php) ----------
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("MySQLi connection failed: " . $conn->connect_error);
}


