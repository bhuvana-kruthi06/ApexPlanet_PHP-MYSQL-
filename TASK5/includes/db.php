<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_manager";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Auto-insert admin if users table is empty
$checkUser = $conn->query("SELECT COUNT(*) as total FROM users");
$row = $checkUser->fetch_assoc();
if ($row['total'] == 0) {
    $email = 'admin@example.com';
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
}
?>

