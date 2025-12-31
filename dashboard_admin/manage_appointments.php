<?php
session_start();
require_once '../php/connection.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../php/login.php");
    exit;
}

$stmt = $pdo->query("SELECT id, first_name, last_name, requested_service, preferred_date, medical_file FROM appointments ORDER BY created_at DESC");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Appointments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css"> 
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

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
<section style="
    min-height: calc(100vh - 100px - 160px); /* keeps footer at bottom */
    background: linear-gradient(to right, rgba(0,181,173,0.2), rgba(0,181,173,0)),
                url('../assets/admin.jpeg') center/cover no-repeat;
">
<div class="container">
<h2>Manage Appointments</h2>

 <table style="
      width: 90%;
      border-collapse: collapse;
      background: linear-gradient(to right, rgba(114,171,169,0.7), rgba(0,181,173,0.7));
      color: black;
      border-radius: 10px;
      overflow: hidden;
      backdrop-filter: blur(5px);
      text-align: left;
  ">
<thead>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Requested Service</th>
<th>Preferred Date</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($appointments as $a): ?>
<tr>
<td><?= htmlspecialchars($a['first_name']) ?></td>
<td><?= htmlspecialchars($a['last_name']) ?></td>
<td><?= htmlspecialchars($a['requested_service']) ?></td>
<td><?= htmlspecialchars($a['preferred_date']) ?></td>
<td>
<a href="details.php?id=<?= $a['id'] ?>" class="btn btn-info btn-sm">Details</a>
<a href="edit_appointment.php?id=<?= $a['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
<a href="delete_appointment.php?id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment request?');">Delete</a>
<?php if($a['medical_file']): ?>
<a href="../<?= $a['medical_file'] ?>" class="btn btn-secondary btn-sm" download>Download File</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#appointments').DataTable({
        "paging": true,     // Enable pagination
        "searching": true,  // Enable search
        "ordering": true    // Enable sorting
    });
});
</script>
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