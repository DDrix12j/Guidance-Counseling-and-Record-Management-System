<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../logout.php");
    exit;
}

include "../DB_connection.php";
include "data/student.php";
include "data/grade.php";
include "data/section.php";
include "data/class.php";

$student_id = $_GET['student_id'] ?? null;
if (!$student_id) {
    header("Location: student.php?error=No student selected");
    exit;
}

$student = getStudentById($student_id, $conn);
if (!$student) {
    header("Location: student.php?error=Student not found");
    exit;
}

$classes = getAllClasses($conn);
$grades = getAllGrades($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Student Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Student Info</h3>
    <form action="req/student-edit.php" method="POST">
        <input type="hidden" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>">
        <div class="mb-3">
            <label>First name</label>
            <input type="text" class="form-control" name="fname" value="<?= htmlspecialchars($student['fname'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Last name</label>
            <input type="text" class="form-control" name="lname" value="<?= htmlspecialchars($student['lname'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>LRN</label>
            <input type="text" class="form-control" name="lrn" value="<?= htmlspecialchars($student['lrn'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Guardian</label>
            <input type="text" class="form-control" name="guardian" value="<?= htmlspecialchars($student['guardian'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($student['address'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Birthday</label>
            <input type="date" class="form-control" name="birthday" value="<?= htmlspecialchars($student['birthday'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Birthplace</label>
            <input type="text" class="form-control" name="birthplace" value="<?= htmlspecialchars($student['birthplace'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select class="form-select" name="gender" required>
                <option value="Male" <?= ($student['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($student['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Grade</label>
            <select class="form-select" name="grade" required>
                <?php foreach ($grades as $grade): ?>
                    <option value="<?= $grade['grade_id'] ?>" <?= ($student['grade'] ?? '') == $grade['grade_id'] ? 'selected' : '' ?>>
                        <?= $grade['grade_code'] . '-' . $grade['grade'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Class (Section)</label>
            <select class="form-select" name="class_id" required>
                <?php foreach ($classes as $class):
                    $grade = getGradeById($class['grade'], $conn);
                    $section = getSectioById($class['section'], $conn);
                    $label = $grade['grade_code'].'-'.$grade['grade'].' '.$section['section'];
                ?>
                    <option value="<?= $class['class_id'] ?>" <?= ($student['class_id'] ?? '') == $class['class_id'] ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Adviser</label>
            <input type="text" class="form-control" name="adviser" value="<?= htmlspecialchars($student['adviser'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form