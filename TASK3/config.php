<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Features Implementation</title>
</head>
<body>
    <?php
$conn = new mysqli("localhost", "root", "", "apex_task3_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
</body>
</html>