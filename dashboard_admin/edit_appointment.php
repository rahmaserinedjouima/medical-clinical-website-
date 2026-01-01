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
<style>
.mb-3 {
    margin-bottom: 20px;
    font-weight: bold;
    
}
.form-control {
padding: 10px 12px !important;                    
    border-radius: 8px !important;                      
    border: 1px solid black !important;    
    font-size: 16px !important;                        
    color: rgb(0,0,0) !important;                      
    background-color:#f4f8f8; !important;             
    box-sizing: border-box !important;                
    width: 100% !important;
}
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body  style="background-color:#f4f8f8;">
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
letter-spacing:1px;color:rgb(114,171,169);">Edit Appointment</h2>
<form method="POST">

<div class="mb-3"  >
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
