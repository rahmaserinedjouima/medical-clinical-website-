<?php
session_start();
require_once 'connection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'All fields are required';
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM authentication WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = 'Username already exists';
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $pdo->prepare(
                "INSERT INTO authentication (username, password) VALUES (?, ?)"
            );
            $stmt->execute([$username, $hashedPassword]);

            header("Location: login.php?signup=success");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Sign Up - SALUS Clinic</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<section class="section0">
    <div class="logo-title">
        <img src="../assets/logo.jpg" alt="SALUS Logo" class="logo">
        <h1>SALUS</h1>
    </div>

    <nav>
        <a href="../index.html">Home</a>
        <a href="../about.html">About Us</a>
        <a href="../services.html">Services</a>
        <a href="../appointment.html">Appointment</a>
        <a href="../contact.html">Contact</a>
        <a href="login.php">Login</a>
        <a href="sign.php" style="color: rgb(114, 171, 169);;">Sign Up</a>
    </nav>
</section>

<section class="section">
    <h2>Sign Up</h2>

    <?php if ($error): ?>
        <p class="login-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green; text-align: center;">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="sign.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Create Account</button>

    </form>
</section>

<footer>
    <div class="footer-container">
        <div class="footer-info">
            <div class="info-item"><strong>Clinic Address:</strong> quartier 400 logements Ville Nouvelle Ali Mendjeli, Constantine</div>
            <div class="info-item"><strong>Emergency Hotline:</strong> +213 77 88 62 55</div>
            <div class="info-item"><strong>Email:</strong> contact@salusclinic.com</div>
            <div class="info-item"><strong>Working Hours:</strong> Mon–Sat: 8:00–18:00</div>
        </div>

        <div class="footer-social">
            <a href="#"><img src="../assets/facebook.png" alt="Facebook"></a>
            <a href="#"><img src="../assets/twitter.png" alt="Twitter"></a>
            <a href="#"><img src="../assets/instagram.png" alt="Instagram"></a>
        </div>

        <div class="footer-copy">
            <p>© 2025 SALUS Clinic</p>
        </div>
    </div>
</footer>

</body>
</html>

