<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "../data/news.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);

        // Debugging statements
        if (!is_dir("../uploads/")) {
            echo "Uploads directory does not exist.";
        } elseif (!is_writable("../uploads/")) {
            echo "Uploads directory is not writable.";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $sql = "INSERT INTO news (title, content, image, date) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute([$title, $content, $image])) {
                    header("Location: news.php?success=News added successfully");
                    exit;
                } else {
                    $errorInfo = $stmt->errorInfo();
                    echo "Error executing query: " . $errorInfo[2];
                }
            } else {
                echo "Failed to upload image";
            }
        }
    }

    $news = getNews($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - News</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
</head>
<style>
        body {
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h3>Manage News and Announcements</h3>
        <form method="post" enctype="multipart/form-data" class="shadow p-3 mt-5">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add News</button>
        </form>
        <h3 class="mt-5">Existing News</h3>
        <ul>
            <?php foreach ($news as $item) { ?>
                <li>
                    <?php if (!empty($item['image'])) { ?>
                        <img src="../uploads/<?=$item['image']?>" alt="<?=$item['title']?>" style="max-width: 100px;">
                    <?php } ?>
                    <strong><?=$item['title']?></strong>: <?=$item['content']?><br><small>Posted on: <?=$item['date']?></small>
                    <br>
                    <a href="edit_news.php?id=<?=$item['id']?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_news.php?id=<?=$item['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this news?');">Delete</a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>