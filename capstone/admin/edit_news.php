<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "../data/news.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);

        if (!empty($image)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $sql = "UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $image, $id]);
            }
        } else {
            $sql = "UPDATE news SET title = ?, content = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $content, $id]);
        }

        header("Location: news.php?success=News updated successfully");
        exit;
    }

    $id = $_GET['id'];
    $news = getNewsById($conn, $id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h3>Edit News</h3>
        <form method="post" enctype="multipart/form-data" class="shadow p-3 mt-5">
            <input type="hidden" name="id" value="<?=$news['id']?>">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?=$news['title']?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" name="content" rows="5" required><?=$news['content']?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="image">
                <?php if (!empty($news['image'])) { ?>
                    <img src="../uploads/<?=$news['image']?>" alt="<?=$news['title']?>" style="max-width: 100px;">
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Update News</button>
        </form>
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