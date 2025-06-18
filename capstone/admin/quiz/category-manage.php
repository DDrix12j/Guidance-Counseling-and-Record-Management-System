<?php
include "../../DB_connection.php";
include "../../data/question.php";

$category_id = $_GET['category_id'];
$questions = getQuestionsByCategory($conn, $category_id);
?>
<h1>Manage Questions</h1>
<a href="question-add.php?category_id=<?= $category_id ?>">Add New Question</a>
<table>
    <tr>
        <th>Question</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($questions as $question): ?>
    <tr>
        <td><?= $question['question_text'] ?></td>
        <td>
            <a href="question-edit.php?id=<?= $question['id'] ?>">Edit</a>
            <a href="question-delete.php?id=<?= $question['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>