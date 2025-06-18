<?php
// filepath: admin/quiz/manage-quiz.php
include "../../DB_connection.php";
include "../../data/quiz.php";

$quizzes = getAllQuizzes($conn);
?>
<h1>Manage Quizzes</h1>
<a href="quiz-add.php">Add New Quiz</a>
<table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($quizzes as $quiz): ?>
    <tr>
        <td><?= $quiz['title'] ?></td>
        <td><?= $quiz['description'] ?></td>
        <td>
            <a href="quiz-edit.php?id=<?= $quiz['id'] ?>">Edit</a>
            <a href="quiz-delete.php?id=<?= $quiz['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>