<?php
session_start();
require_once 'connection.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare(
        "SELECT id, username, password
         FROM authentication
         WHERE username = ?"
    );
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo 'Redirecting...';
        echo '<a href="../dashboard_admin/manage_appointments.php">Go to Dashboard</a>';
        header('Location: ../dashboard_admin/manage_appointments.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - SALUS Clinic</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <section class="section0">
      <div class="logo-title">
          <img src="assets/logo.jpg" alt="SALUS Logo" class="logo">
          <h1>SALUS</h1>
      </div>

      <nav>
          <a href="index.html">Home</a>
          <a href="about.html">About Us</a>
          <a href="services.html">Services</a>
          <a href="appointment.html">Appointment</a>
          <a href="contact.html">Contact</a>
          <a href="login.php">Login</a> <!-- Highlight active page if you like -->
      </nav>
  </section>

  <section class="section">
      <h2>Admin Login</h2>
      <?php if($error): ?>
          <p style="color:red;"><?= $error ?></p>
      <?php endif; ?>

      <form method="POST" action="login.php">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Login</button>
      </form>
  </section>

</body>
</html>