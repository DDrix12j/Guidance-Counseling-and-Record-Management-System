<?php
include "../../DB_connection.php";
include "../../data/category.php";

if (isset($_GET['id'])) {
    $category = getCategoryById($conn, $_GET['id']);
    if (!$category) {
        header("Location: category-manage.php?error=Category not found");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($description)) {
        updateCategory($conn, $id, $name, $description);
        header("Location: category-manage.php?success=Category updated successfully");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<h1>Edit Category</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <label for="name">Category Name</label>
    <input type="text" id="name" name="name" value="<?= $category['name'] ?>" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" required><?= $category['description'] ?></textarea>
    <button type="submit">Update Category</button>
</form>