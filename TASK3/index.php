<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Listing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">

<div class="container">
    <h2 class="mb-4">Post Listing</h2>
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search by title or content" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </form>

    <?php
    $search = $_GET['search'] ?? '';
    $limit = 5;
    $page = $_GET['page'] ?? 1;
    $offset = ($page - 1) * $limit;

    $where = $search ? "WHERE title LIKE '%$search%' OR content LIKE '%$search%'" : "";

    $total_result = $conn->query("SELECT COUNT(*) as total FROM posts $where")->fetch_assoc();
    $total_pages = ceil($total_result['total'] / $limit);

    $result = $conn->query("SELECT * FROM posts $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card mb-3'><div class='card-body'>";
            echo "<h5>{$row['title']}</h5>";
            echo "<p>{$row['content']}</p>";
            echo "<small class='text-muted'>Posted on: {$row['created_at']}</small>";
            echo "</div></div>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
    ?>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?search=<?= $search ?>&page=<?= $page - 1 ?>">Prev</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= $search ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?search=<?= $search ?>&page=<?= $page + 1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

</body>
</html>
