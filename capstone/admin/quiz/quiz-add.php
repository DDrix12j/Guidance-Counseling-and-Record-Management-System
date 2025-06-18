<?php
include "../../DB_connection.php";
include "../../data/quiz.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        addQuiz($conn, $title, $description);
        header("Location: manage-quiz.php?success=Quiz added successfully");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<h1>Add New Quiz</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <label for="title">Quiz Title</label>
    <input type="text" id="title" name="title" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" required></textarea>
    <button type="submit">Add Quiz</button>
</form>