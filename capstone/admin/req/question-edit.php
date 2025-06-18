<?php
// filepath: d:\aaaa\htdocs\capstonework\capstone\admin\req\question-edit.php
include "../../DB_connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the question details
    $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$id]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$question) {
        header("Location: ../question-manage.php?error=Question not found");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_text = $_POST['question_text'];

        if (!empty($question_text)) {
            $stmt = $conn->prepare("UPDATE questions SET question_text = ? WHERE id = ?");
            $stmt->execute([$question_text, $id]);
            header("Location: ../question-manage.php?success=Question updated successfully");
            exit;
        } else {
            $error = "Question text is required.";
        }
    }
} else {
    header("Location: ../question-manage.php?error=Question ID is required");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Question</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="question_text" class="form-label">Question Text</label>
                <textarea class="form-control" id="question_text" name="question_text" required><?= $question['question_text'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="../question-manage.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>