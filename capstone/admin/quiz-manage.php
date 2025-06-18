<?php
// filepath: d:\aaaa\htdocs\capstonework\capstone\admin\quiz-manage.php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Fetch all categories
    $categories = $conn->query("SELECT * FROM quiz_categories")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO quiz_categories (name, description) VALUES (?, ?)");
            $stmt->execute([$name, $description]);
            header("Location: quiz-manage.php?success=Category added successfully");
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
    <title>Manage Quizzes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1>Manage Categories</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= $_GET['success'] ?></div>
        <?php endif; ?>

        <!-- Add Category Form -->
        <form method="post" class="d-flex align-items-center">
            <div class="me-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="me-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="me-3">
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
            <!-- Scoring Management Button -->
            <div>
                <a href="scoring-manage.php" class="btn btn-secondary">Scoring Management</a>
            </div>
        </form>
        <hr>

        <!-- Existing Categories -->
        <h2>Existing Categories</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['name'] ?></td>
                    <td><?= $category['description'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="showEditModal('quiz-edit.php?id=<?= $category['id'] ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="showDeleteModal('quiz-delete.php?id=<?= $category['id'] ?>')">Delete</button>
                        <a href="question-manage.php?category_id=<?= urlencode($category['id']) ?>" class="btn btn-info btn-sm">Manage Questions</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with this action?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmActionButton" class="btn btn-danger">Confirm</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show the confirmation modal for delete
        function showDeleteModal(url) {
            const confirmButton = document.getElementById('confirmActionButton');
            confirmButton.href = url;
            confirmButton.classList.remove('btn-warning');
            confirmButton.classList.add('btn-danger');
            confirmButton.textContent = 'Delete';
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }

        // Show the confirmation modal for edit
        function showEditModal(url) {
            const confirmButton = document.getElementById('confirmActionButton');
            confirmButton.href = url;
            confirmButton.classList.remove('btn-danger');
            confirmButton.classList.add('btn-warning');
            confirmButton.textContent = 'Edit';
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>