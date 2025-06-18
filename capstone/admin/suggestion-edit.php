<?php
// filepath: d:\aaaa\htdocs\capstonework\capstone\admin\req\suggestion-edit.php
include dirname(__DIR__, 2) . "/DB_connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the suggestion details
    $stmt = $conn->prepare("SELECT * FROM career_suggestions WHERE id = ?");
    $stmt->execute([$id]);
    $suggestion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$suggestion) {
        header("Location: ../suggestion-manage.php?error=Suggestion not found");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $suggestion_text = $_POST['suggestion_text'];

        if (!empty($suggestion_text)) {
            $stmt = $conn->prepare("UPDATE career_suggestions SET suggestion_text = ? WHERE id = ?");
            $stmt->execute([$suggestion_text, $id]);
            header("Location: ../suggestion-manage.php?success=Suggestion updated successfully");
            exit;
        } else {
            $error = "Suggestion text is required.";
        }
    }
} else {
    header("Location: ../suggestion-manage.php?error=Suggestion ID is required");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Suggestion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Suggestion</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="suggestion_text" class="form-label">Suggestion Text</label>
                <textarea class="form-control" id="suggestion_text" name="suggestion_text" required><?= htmlspecialchars($suggestion['suggestion_text']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="../suggestion-manage.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>