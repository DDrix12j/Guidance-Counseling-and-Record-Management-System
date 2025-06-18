<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Fetch all categories
    $categories = $conn->query("SELECT * FROM quiz_categories")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all career suggestions
    $suggestions = $conn->query("SELECT cs.*, qc.name AS category_name 
                                 FROM career_suggestions cs 
                                 JOIN quiz_categories qc ON cs.category_id = qc.id")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category_id = $_POST['category_id'];
        $jobs = $_POST['jobs'];
        $courses = $_POST['courses'];
        $strand = $_POST['strand'];

        if (!empty($category_id) && !empty($jobs) && !empty($courses) && !empty($strand)) {
            $stmt = $conn->prepare("INSERT INTO career_suggestions (category_id, jobs, courses, strand) VALUES (?, ?, ?, ?)");
            $stmt->execute([$category_id, $jobs, $courses, $strand]);
            header("Location: career-suggestions-manage.php?success=Suggestion added successfully");
            exit;
        } else {
            $error = "All fields are required.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Career Suggestions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Career Suggestions</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= $_GET['success'] ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select a Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jobs" class="form-label">Jobs</label>
                <textarea class="form-control" id="jobs" name="jobs" required></textarea>
            </div>
            <div class="mb-3">
                <label for="courses" class="form-label">College Courses</label>
                <textarea class="form-control" id="courses" name="courses" required></textarea>
            </div>
            <div class="mb-3">
                <label for="strand" class="form-label">Senior High School Strand</label>
                <input type="text" class="form-control" id="strand" name="strand" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Suggestion</button>
        </form>
        <hr>
        <h2>Existing Career Suggestions</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Jobs</th>
                    <th>Courses</th>
                    <th>Strand</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suggestions as $suggestion): ?>
                <tr>
                    <td><?= $suggestion['category_name'] ?></td>
                    <td><?= $suggestion['jobs'] ?></td>
                    <td><?= $suggestion['courses'] ?></td>
                    <td><?= $suggestion['strand'] ?></td>
                    <td>
                        <a href="career-suggestions-edit.php?id=<?= $suggestion['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="career-suggestions-delete.php?id=<?= $suggestion['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>