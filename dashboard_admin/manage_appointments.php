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

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>
<body>
<div class="container mt-5">
<h2>Manage Appointments</h2>

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
</body>
</html>