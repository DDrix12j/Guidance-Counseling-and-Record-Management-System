<?php
include "../DB_connection.php";
include "data/suggestion.php";

// Check if category_id is provided in the URL
if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
    header("Location: quiz-manage.php?error=Category ID is required");
    exit;
}

$category_id = $_GET['category_id'];

// Validate if the category_id exists in the quiz_categories table
$stmt = $conn->prepare("SELECT COUNT(*) FROM quiz_categories WHERE id = ?");
$stmt->execute([$category_id]);
$categoryExists = $stmt->fetchColumn();

if (!$categoryExists) {
    header("Location: quiz-manage.php?error=Invalid category ID");
    exit;
}
if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
    echo "Debug: category_id is missing or empty.";
    exit;
}

// Fetch suggestions for the category
$suggestions = getAllSuggestions($conn, $category_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suggestions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Suggestions</h1>
        <a href="suggestion-add.php?category_id=<?= $category_id ?>" class="btn btn-primary mb-3">Add New Suggestion</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Suggestion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suggestions as $suggestion): ?>
                <tr>
                    <td><?= $suggestion['suggestion_text'] ?></td>
                    <td>
                        <a href="suggestion-edit.php?id=<?= $suggestion['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="suggestion-delete.php?id=<?= $suggestion['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>