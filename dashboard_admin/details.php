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
<link rel="stylesheet" href="../style.css"> 
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="section0">
    <div class="logo-title">
        <img src="../assets\logo.jpg" alt="SALUS Logo" class="logo">
        <h1>SALUS</h1>
    </div>

    <nav>
        <a href="../index.html" style="color: rgb(114, 171, 169);;">Home</a>
        <a href="../about.html">About Us</a>
        <a href="../services.html">Services</a>
        <a href="../appointment.html">Appointment</a>
        <a href="../contact.html">Contact</a>
        <a href="../php/login.php">Login</a>

    </nav>
  </section>
<div class="container mt-5">
<h2>Appointment Details</h2>
<table style="
    width: 100%;
    border-collapse: collapse;
    background: linear-gradient(to right, rgba(114,171,169,0.7), rgba(0,181,173,0.7));
    color: black;
    border-radius: 10px;
    overflow: hidden;
    backdrop-filter: blur(5px);
    text-align: left;
" >
<?php foreach ($appointment as $key => $value): ?>
<tr>
<th style="padding: 10px; border-bottom: 1px solid rgba(0,0,0,0.2);">
    <?= htmlspecialchars(ucwords(str_replace('_',' ',$key))) ?>
  </th>
<td style="padding: 10px; border-bottom: 1px solid rgba(0,0,0,0.2);">
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
<footer>
  <div class="footer-container">

    <div class="footer-info">
      <div class="info-item"><strong>Clinic Address:</strong> quartier 400 logements Ville Nouvelle Ali Mendjeli, Constantine</div>
      <div class="info-item"><strong>Emergency Hotline:</strong> +213 77 88 62 55</div>
      <div class="info-item"><strong>Email:</strong> contact@salusclinic.com</div>
      <div class="info-item"><strong>Working Hours:</strong> Mon–Sat: 8:00–18:00</div>
    </div>

    <div class="footer-social">
      <a href="#" class="social-link"><img src="../assets/facebook.png" alt="Facebook"></a>
      <a href="#" class="social-twitter"><img src="../assets/twitter.png" alt="Twitter"></a>
      <a href="#" class="social-link"><img src="../assets/instagram.png" alt="Instagram"></a>
    </div>

    <div class="footer-copy">
      <p>© 2025 SALUS Clinic</p>
    </div>

  </div>
</footer>
</body>
</html>
