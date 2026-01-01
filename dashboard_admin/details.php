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
<style>
      .section0 nav a {
    text-decoration: none;
    color:rgba(0, 0, 0, 0.7); 
    font-weight: bold;
    font-size: 18px;
    transition: 0.2s;
}
.section0 nav a:hover {
    color: rgb(114, 171, 169);
    transform: scale(1.1);
}
</style>
</head>

<body style="background-color:#f4f8f8;">

<section class="section0"
style="
width:100%;
height:100px;
padding:20px 50px;
box-sizing:border-box;
color:rgb(114,171,169);
display:flex;
background-color:#ffffff;
justify-content:space-between;
align-items:center;
">

  <div class="logo-title"
  style="
  display:flex;
  align-items:center;
  gap:5px;
  ">
    <img src="../assets/logo.jpg" alt="SALUS Logo"
         class="logo"
         style="width:100px;height:auto;">
         
    <h1 style="
        margin:0;
        font-size:40px;
        letter-spacing:2px;
        color:rgb(114,171,169);
    ">SALUS</h1>
  </div>

  <nav style="display:flex;gap:20px;">
    <a href="manage_appointments.php" style="text-decoration:none;font-weight:bold;font-size:18px;color:rgba(0,0,0,0.7);;">Admin Dashboard</a>
    <a href="../php/logout.php" style="text-decoration:none;font-weight:bold;font-size:18px;color:rgba(0,0,0,0.7);">Log out</a>
  </nav>

</section>
<div class="container mt-5" style="
     background:#ffffff;
     padding:30px;
     border-radius:12px;
     box-shadow:0 8px 25px rgba(0,0,0,0.08);
     ">

<h2 style="margin-bottom:20px;
font-weight:bold;
letter-spacing:1px;color:rgb(114,171,169);">Appointment Details</h2>

<table class="table table-bordered" style="border:1px solid black;">
<?php foreach ($appointment as $key => $value): ?>
<tr>
<th><?= htmlspecialchars(ucwords(str_replace('_',' ',$key))) ?></th>

<td style="background-color:#f4f8f8;">
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
