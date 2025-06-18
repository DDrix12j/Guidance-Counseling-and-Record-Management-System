<?php
include "../../DB_connection.php";
include "../../data/question.php";

$category_id = $_GET['category_id'];
$questions = getAllQuestions($conn, $category_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Questions</h1>
        <a href="question-add.php?category_id=<?= $category_id ?>" class="btn btn-primary mb-3">Add New Question</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?= $question['question_text'] ?></td>
                    <td>
                        <a href="question-edit.php?id=<?= $question['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="question-delete.php?id=<?= $question['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>