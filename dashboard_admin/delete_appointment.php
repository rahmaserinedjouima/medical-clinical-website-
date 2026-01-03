<?php
session_start();
if (
    empty($_SESSION['logged_in']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../php/login.php");
    exit;
}
require_once '../php/connection.php';

if (!isset($_GET['id'])) die("No appointment selected.");
$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT medical_file FROM appointments WHERE id=?");
$stmt->execute([$id]);
$file = $stmt->fetchColumn();
if($file && file_exists("../$file")) unlink("../$file");

$stmt = $pdo->prepare("DELETE FROM appointments WHERE id=?");
$stmt->execute([$id]);

header("Location: manage_appointments.php");
exit;
