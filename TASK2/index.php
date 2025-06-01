<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<?php
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id");

echo "<a href='create.php'>Add New Post</a> | <a href='logout.php'>Logout</a><br><br>";

while ($row = $result->fetch_assoc()) {
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<a href='edit.php?id={$row['id']}'>Edit</a> | ";
    echo "<a href='delete.php?id={$row['id']}'>Delete</a><hr>";
}
?>
</body>
</html>