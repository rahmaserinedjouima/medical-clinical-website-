<?php
require_once 'connection.php'; // Include database connection

$errors = []; // Array to store errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get inputs (matching your HTML names)
    $first_name        = htmlspecialchars(trim($_POST['firstName']));
    $last_name         = htmlspecialchars(trim($_POST['lastName']));
    $birthdate         = $_POST['birthdate'];
    $gender            = htmlspecialchars(trim($_POST['gender']));
    $requested_service = htmlspecialchars(trim($_POST['service']));
    $preferred_date    = $_POST['prefDate'];
    $preferred_time    = $_POST['prefTime'] ?? null;
    $email             = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone             = htmlspecialchars(trim($_POST['phone']));
    $address           = htmlspecialchars(trim($_POST['address']));
    $allergies_history = htmlspecialchars(trim($_POST['history']));
    $selected_doctor   = htmlspecialchars(trim($_POST['doctor']));

    // Validate required fields
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($birthdate)) $errors[] = "Birthdate is required.";
    if (empty($gender)) $errors[] = "Gender is required.";
    if (empty($requested_service)) $errors[] = "Requested service is required.";
    if (empty($preferred_date)) $errors[] = "Preferred date is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($phone)) $errors[] = "Phone number is required.";
    if (empty($selected_doctor)) $errors[] = "Doctor selection is required.";

    // Handle file upload (optional)
    $medical_file_path = null;
    if (isset($_FILES['medicalFile']) && $_FILES['medicalFile']['error'] === 0) {
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        $file_ext = pathinfo($_FILES['medicalFile']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_ext), $allowed)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $medical_file_path = $upload_dir . time() . '_' . basename($_FILES['medicalFile']['name']);
            move_uploaded_file($_FILES['medicalFile']['tmp_name'], $medical_file_path);
        } else {
            $errors[] = "Invalid file type. Allowed: PDF, JPG, PNG.";
        }
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO appointments 
            (first_name, last_name, birthdate, gender, requested_service, preferred_date, preferred_time, email, phone, address, allergies_history, selected_doctor, medical_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $first_name, $last_name, $birthdate, $gender, $requested_service,
            $preferred_date, $preferred_time, $email, $phone, $address,
            $allergies_history, $selected_doctor, $medical_file_path
        ]);

        echo "<p style='color:green;'>Your appointment request has been submitted successfully.</p>";
        exit;
    } else {
        // Display all errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
} else {
    echo "Invalid request.";
}
?>
