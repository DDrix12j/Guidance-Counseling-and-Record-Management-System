<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $grade_level = $_POST['grade_level'];
        $gender = $_POST['gender'];
        $section = $_POST['section'];
        $adviser = $_POST['adviser'];
        $schedule = $_POST['schedule'];
        $status = $_POST['status'];

        $sql = "UPDATE counseling_records 
                SET first_name = ?, last_name = ?, grade_level = ?, gender = ?, section = ?, adviser = ?, schedule = ?, status = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$first_name, $last_name, $grade_level, $gender, $section, $adviser, $schedule, $status, $id]);

        header("Location: counseling.php?success=Record updated successfully");
        exit;
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM counseling_records WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: counseling.php?error=Invalid record ID");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Counseling Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Edit Counseling Record</h1>
        <form method="post" class="shadow p-4 mt-4 bg-light rounded">
            <input type="hidden" name="id" value="<?= $record['id'] ?>">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $record['first_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $record['last_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?= $record['grade_level'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="M" <?= $record['gender'] == 'M' ? 'selected' : '' ?>>Male</option>
                    <option value="F" <?= $record['gender'] == 'F' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" value="<?= $record['section'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="adviser" class="form-label">Adviser</label>
                <input type="text" class="form-control" id="adviser" name="adviser" value="<?= $record['adviser'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="schedule" class="form-label">Schedule</label>
                <input type="datetime-local" class="form-control" id="schedule" name="schedule" value="<?= date('Y-m-d\TH:i', strtotime($record['schedule'])) ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="<?= $record['status'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Record</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
}
?>