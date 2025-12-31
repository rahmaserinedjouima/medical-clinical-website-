<?php
session_start();
require_once '../php/connection.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../php/login.php");
    exit;
}

if (!isset($_GET['id'])) die("No appointment selected.");
$id = intval($_GET['id']);

// Optional: delete uploaded file
$stmt = $pdo->prepare("SELECT medical_file FROM appointments WHERE id=?");
$stmt->execute([$id]);
$file = $stmt->fetchColumn();
if($file && file_exists("../$file")) unlink("../$file");

// Delete record
$stmt = $pdo->prepare("DELETE FROM appointments WHERE id=?");
$stmt->execute([$id]);

header("Location: manage_appointments.php");
exit;
