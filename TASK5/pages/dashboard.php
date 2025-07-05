<?php
echo getcwd(); // shows current working directory
?>

<?php
include('../includes/db.php');
session_start();

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user'] = $email;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid email!";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: dashboard.php");
    exit();
}

// Add student
if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['student_email'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $course);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <h2>📋 Student Dashboard</h2>

    <?php if (!isset($_SESSION['user'])): ?>
        <form method="POST" class="box">
            <h3>🔐 Login</h3>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    <?php else: ?>
        <p>👋 Welcome, <?= $_SESSION['user'] ?> | <a href="?logout=true">Logout</a></p>

        <form method="POST" class="box">
            <h3>➕ Add Student</h3>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="student_email" placeholder="Email" required>
            <input type="text" name="course" placeholder="Course" required>
            <button type="submit" name="add_student">Add Student</button>
        </form>

        <div class="list">
            <h3>📚 All Students</h3>
            <ul>
                <?php
                $students = $conn->query("SELECT * FROM students ORDER BY id DESC");
                while ($row = $students->fetch_assoc()): ?>
                    <li><strong><?= htmlspecialchars($row['name']) ?></strong> - <?= htmlspecialchars($row['email']) ?> - <?= htmlspecialchars($row['course']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

