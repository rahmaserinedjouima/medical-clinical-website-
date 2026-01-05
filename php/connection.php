<?php
// Database credentials
$host = "localhost";        // Usually localhost
$dbname = "medical_clinic";
$username = "root";        
$password = "";           

// Try to connect to MySQL using PDO
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Uncomment to check connection
    // echo "Connected successfully";

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
