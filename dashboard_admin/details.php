<?php
session_start();
require_once '../php/connection.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../php/login.php");
    exit;
}

if (!isset($_GET['id'])) { die("No appointment selected."); }

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->execute([$id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$appointment) die("Appointment not found.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Appointment Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Appointment Details</h2>
<table class="table table-bordered">
<?php foreach ($appointment as $key => $value): ?>
<tr>
<th><?= htmlspecialchars(ucwords(str_replace('_',' ',$key))) ?></th>
<td>
<?php 
if($key === 'medical_file' && $value){
    echo "<a href='../$value' download>Download File</a>";
} else {
    echo htmlspecialchars($value);
}
?>
</td>
</tr>
<?php endforeach; ?>
</table>
<a href="manage_appointments.php" class="btn btn-secondary">Back</a>
</div>
</body>
</html>
