-edit.php
<?php
include "../../DB_connection.php";
include "../../data/quiz.php";

if (isset($_GET['id'])) {
    $quiz = getQuizById($conn, $_GET['id']);
    if (!$quiz) {
        header("Location: manage-quiz.php?error=Quiz not found");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        updateQuiz($conn, $id, $title, $description);
        header("Location: manage-quiz.php?success=Quiz updated successfully");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<h1>Edit Quiz</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <input type="hidden" name="id" value="<?= $quiz['id'] ?>">
    <label for="title">Quiz Title</label>
    <input type="text" id="title" name="title" value="<?= $quiz['title'] ?>" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" required><?= $quiz['description'] ?></textarea>
    <button type="submit">Update Quiz</button>
</form>