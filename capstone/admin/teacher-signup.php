<?php
session_start();
include "../DB_connection.php";
include "data/subject.php";
include "data/class.php";
include "data/grade.php";
include "data/section.php";

$token = $_GET['token'] ?? '';
$error = '';
$invite = null;
$subjects = getAllSubjects($conn);
$classes = getAllClasses($conn);

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM teacher_invites WHERE token = ? AND expires_at > NOW() AND used = 0");
    $stmt->execute([$token]);
    $invite = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$invite) {
        $error = "Invalid or expired signup link.";
    }
} else {
    $error = "No signup token provided.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $invite) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $employee_number = trim($_POST['employee_number']);
    $phone_number = trim($_POST['phone_number']);
    $qualification = trim($_POST['qualification']);
    $gender = $_POST['gender'] ?? '';
    $date_of_birth = $_POST['date_of_birth'];
    $subjects_selected = isset($_POST['subjects']) ? implode(',', $_POST['subjects']) : '';
    $classes_selected = isset($_POST['classes']) ? implode(',', $_POST['classes']) : '';

    if (
        !$fname || !$lname || !$username || !$password || !$address ||
        !$employee_number || !$phone_number || !$qualification ||
        !$gender || !$date_of_birth || !$subjects_selected || !$classes_selected
    ) {
        $error = "All fields are required.";
    } else {
        // Check if username is unique
        $stmt = $conn->prepare("SELECT * FROM teachers WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username already taken.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO teachers 
                (username, password, fname, lname, address, employee_number, phone_number, qualification, email_address, position, gender, date_of_birth, subject, class)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $username, $hashed, $fname, $lname, $address, $employee_number, $phone_number,
                $qualification, $invite['email'], $invite['position'], $gender, $date_of_birth, $subjects_selected, $classes_selected
            ]);
            // Mark invite as used
            $conn->prepare("UPDATE teacher_invites SET used = 1 WHERE id = ?")->execute([$invite['id']]);
            header("Location: ../login.php?success=Account created. You can now log in.");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Signup</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
        <style>
        body {
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }
        </style>
</head>
<body>
<div class="container mt-5">
    <h3>Teacher Signup</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($invite && !$error): ?>
        <form method="post" class="shadow p-3 mt-3 form-w">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($invite['email']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($invite['position']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Employee Number</label>
                <input type="text" class="form-control" name="employee_number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Qualification</label>
                <input type="text" class="form-control" name="qualification" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" value="Male" name="gender" required> Male
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" value="Female" name="gender" required> Female
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="date_of_birth" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subjects</label>
                <select multiple class="form-control" name="subjects[]" required>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['subject_id'] ?>"><?= $subject['subject'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Class</label>
                <div class="row row-cols-5">
                    <?php foreach ($classes as $class): ?>
                        <div class="col">
                            <input type="checkbox" name="classes[]" value="<?= $class['class_id'] ?>" required>
                            <?php 
                                $grade = getGradeById($class['grade'], $conn); 
                                $section = getSectioById($class['section'], $conn); 
                            ?>
                            <?= $grade['grade_code'] . '-' . $grade['grade'] . $section['section'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>