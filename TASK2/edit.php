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

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM posts WHERE id=$id");
$post = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<form method="post">
    <input type="text" name="title" value="<?php echo $post['title']; ?>"><br>
    <textarea name="content"><?php echo $post['content']; ?></textarea><br>
    <button type="submit">Update</button>
</form>
</body>
</html>