<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "student_manager";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$insertedStudent = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $course = trim($_POST["course"]);

    $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $course);

    if ($stmt->execute()) {
        $insertedStudent = [
            'name' => $name,
            'email' => $email,
            'course' => $course
        ];
    } else {
        $error = "Failed to insert: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px #ccc; width: 350px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; }
        button { background: #28a745; color: #fff; border: none; }
        button:hover { background: #218838; }
        .logout { float: right; margin-top: -40px; }
        .message { background: #e9ffe9; padding: 15px; border-left: 5px solid #28a745; margin-top: 20px; }
    </style>
</head>
<body>
<h2>Add Student</h2>
<a href="dashboard.php">📋 Back to Dashboard</a>
<a class="logout" href="?logout=true">🔒 Logout</a>

<form method="post">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Course:</label>
    <input type="text" name="course" required>

    <button type="submit">Add Student</button>
</form>

<?php if (!empty($insertedStudent)): ?>
    <div class="message">
        <h3>✅ Student Inserted Successfully!</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($insertedStudent['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($insertedStudent['email']) ?></p>
        <p><strong>Course:</strong> <?= htmlspecialchars($insertedStudent['course']) ?></p>
    </div>
<?php elseif (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<script src="../js/script.js"></script>

</body>
</html>
