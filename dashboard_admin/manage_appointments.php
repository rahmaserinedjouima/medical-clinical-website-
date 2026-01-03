<?php
session_start();
if (
    !isset($_SESSION['logged_in']) ||
    $_SESSION['role'] !== 'admin'
) {
    header('Location: ../index.html');
    exit;
}
require_once '../php/connection.php';


$stmt = $pdo->query("SELECT id, first_name, last_name, requested_service, preferred_date, medical_file FROM appointments ORDER BY created_at DESC");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Appointments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
justify-content:space-between;
align-items:center;
background-color:#ffffff;
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
    <a href="manage_appointments.php" style="text-decoration:none;font-weight:bold;font-size:18px;color: rgb(114, 171, 169);;">Admin Dashboard</a>
    <a href="../php/logout.php" style="text-decoration:none;font-weight:bold;font-size:18px;color:rgba(0,0,0,0.7);">Log out</a>
  </nav>

</section>

<div class="container mt-5"  style="
     background:#ffffff;
     padding:30px;
     border-radius:12px;
     box-shadow:0 8px 25px rgba(0,0,0,0.08);
     " >
<h2 style="margin-bottom:20px;
font-weight:bold;
letter-spacing:1px;color:rgb(114,171,169);">Manage Appointments</h2>

<table id="appointments" class="table table-striped table-bordered">
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

<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
    Delete
</button>

<?php if($a['medical_file']): ?>

<a href="../<?= $a['medical_file'] ?>" class="btn btn-secondary btn-sm" download>Download File</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#appointments').DataTable({
        "paging": true,    
        "searching": true,  
        "ordering": true    
    });
});
</script>
<!-- Simple Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:rgb(114,171,169); color:white;">
        <h5 class="modal-title">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this appointment?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="delete_appointment.php?id=<?= $a['id'] ?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>