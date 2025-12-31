<?php
session_start();
require_once '../php/connection.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../php/login.php");
    exit;
}

if (!isset($_GET['id'])) die("No appointment selected.");
$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->execute([$id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$appointment) die("Appointment not found.");

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE appointments SET first_name=?, last_name=?, birthdate=?, gender=?, requested_service=?, preferred_date=?, preferred_time=?, email=?, phone=?, address=?, allergies_history=?, selected_doctor=? WHERE id=?");
    $stmt->execute([
        $_POST['first_name'], $_POST['last_name'], $_POST['birthdate'], $_POST['gender'],
        $_POST['requested_service'], $_POST['preferred_date'], $_POST['preferred_time'],
        $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['allergies_history'],
        $_POST['selected_doctor'], $id
    ]);
    header("Location: manage_appointments.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Appointment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Edit Appointment</h2>
<form method="POST">
<div class="mb-3">
<label>First Name</label>
<input name="first_name" class="form-control" value="<?= htmlspecialchars($appointment['first_name']) ?>">
</div>
<div class="mb-3">
<label>Last Name</label>
<input name="last_name" class="form-control" value="<?= htmlspecialchars($appointment['last_name']) ?>">
</div>
<div class="mb-3">
<label>Birthdate</label>
<input type="date" name="birthdate" class="form-control" value="<?= $appointment['birthdate'] ?>">
</div>
<div class="mb-3">
<label>Gender</label>
<select name="gender" class="form-control">
<option value="Male" <?= $appointment['gender']=='Male'?'selected':'' ?>>Male</option>
<option value="Female" <?= $appointment['gender']=='Female'?'selected':'' ?>>Female</option>
<option value="Other" <?= $appointment['gender']=='Other'?'selected':'' ?>>Other</option>
</select>
</div>
<div class="mb-3">
<label>Requested Service</label>
<input name="requested_service" class="form-control" value="<?= htmlspecialchars($appointment['requested_service']) ?>">
</div>
<div class="mb-3">
<label>Preferred Date</label>
<input type="date" name="preferred_date" class="form-control" value="<?= $appointment['preferred_date'] ?>">
</div>
<div class="mb-3">
<label>Preferred Time</label>
<input type="time" name="preferred_time" class="form-control" value="<?= $appointment['preferred_time'] ?>">
</div>
<div class="mb-3">
<label>Email</label>
<input name="email" class="form-control" value="<?= htmlspecialchars($appointment['email']) ?>">
</div>
<div class="mb-3">
<label>Phone</label>
<input name="phone" class="form-control" value="<?= htmlspecialchars($appointment['phone']) ?>">
</div>
<div class="mb-3">
<label>Address</label>
<input name="address" class="form-control" value="<?= htmlspecialchars($appointment['address']) ?>">
</div>
<div class="mb-3">
<label>Allergies / History</label>
<textarea name="allergies_history" class="form-control"><?= htmlspecialchars($appointment['allergies_history']) ?></textarea>
</div>
<div class="mb-3">
<label>Doctor</label>
<input name="selected_doctor" class="form-control" value="<?= htmlspecialchars($appointment['selected_doctor']) ?>">
</div>
<button class="btn btn-success" type="submit">Update</button>
<a href="manage_appointments.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</body>
</html>
