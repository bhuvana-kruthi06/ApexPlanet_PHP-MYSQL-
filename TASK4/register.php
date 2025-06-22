<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Enhancements</title>
</head>
<body>
    <?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    echo "User registered successfully.";
}
?>

<form method="post" onsubmit="return validateForm()">
    Username: <input name="username" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    Role:
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <button type="submit">Register</button><br><br>
</form>

<script>
function validateForm() {
    const pass = document.querySelector('input[name="password"]').value;
    if (pass.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    return true;
}
</script>
</body>
</html>