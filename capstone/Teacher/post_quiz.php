<?php
include "../DB_connection.php";
include "../data/setting.php";
session_start();

if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) != 'teacher' && strtolower($_SESSION['role']) != 'admin')) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_name = $_POST['teacher_name'];
    $subject = $_POST['subject'];
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO quizzes (title, description, teacher_name, subject, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $teacher_name, $subject, $created_by);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../index.php?success=Quiz posted successfully");
    } else {
        echo "Failed to post quiz.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Quiz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form-title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Post a Quiz</h2>
            <form method="post" action="post_quiz.php">
                <div class="mb-3">
                    <label for="title" class="form-label">Quiz Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="teacher_name" class="form-label">Teacher's Name</label>
                    <input type="text" class="form-control" id="teacher_name" name="teacher_name" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <button type="submit" class="btn btn-primary">Post Quiz</button>
            </form>
        </div>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>
</html>