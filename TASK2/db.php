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
$host = 'localhost';
$db   = 'blog';
$user = 'root';
$pass = ''; // change based on your setup

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>
</body>
</html>