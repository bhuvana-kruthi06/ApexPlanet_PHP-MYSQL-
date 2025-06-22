<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome to the Dashboard</h2>";
echo "<p>You are logged in as: <strong>{$_SESSION['role']}</strong></p>";

if ($_SESSION['role'] === 'admin') {
    echo "<p>This is admin content only.</p>";
} else {
    echo "<p>This is user content.</p>";
}
echo '<a href="logout.php">Logout</a>';
?>
