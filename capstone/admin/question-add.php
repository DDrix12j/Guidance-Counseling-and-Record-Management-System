<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php"; // Corrected path

    if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
        echo "Debug: category_id is missing or empty.";
        exit;
    }
    $category_id = $_GET['category_id'];

    // Validate if the category_id exists in the categories table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM quiz_categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $categoryExists = $stmt->fetchColumn();

    if (!$categoryExists) {
        header("Location: question-manage.php?error=Invalid category ID");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_text = $_POST['question_text'];

        if (!empty($question_text)) {
            $stmt = $conn->prepare("INSERT INTO questions (category_id, question_text) VALUES (?, ?)");
            $stmt->execute([$category_id, $question_text]);
            header("Location: question-manage.php?category_id=$category_id&success=Question added successfully");
            exit;
        } else {
            $error = "Question text is required.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Question</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="question_text" class="form-label">Question Text</label>
                <textarea class="form-control" id="question_text" name="question_text" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Question</button>
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