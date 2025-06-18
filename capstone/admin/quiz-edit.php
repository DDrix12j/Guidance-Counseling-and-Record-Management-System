<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $category = $conn->prepare("SELECT * FROM quiz_categories WHERE id = ?");
        $category->execute([$id]);
        $category = $category->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            header("Location: quiz-manage.php?error=Category not found");
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (!empty($name)) {
            $stmt = $conn->prepare("UPDATE quiz_categories SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $description, $id]);
            header("Location: quiz-manage.php?success=Category updated successfully");
            exit;
        } else {
            $error = "Category name is required";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1>Edit Category</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?= $category['description'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>