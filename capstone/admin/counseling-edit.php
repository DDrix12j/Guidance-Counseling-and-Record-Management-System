<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the counseling record
        $sql = "SELECT * FROM counseling_records WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            header("Location: counseling.php?error=Record not found");
            exit;
        }

        // Fetch existing data for Students
        $students = $conn->query("SELECT lrn, name, grade AS grade_level, gender, section, adviser FROM students")->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lrn = $_POST['lrn'];
            $name = $_POST['name'];
            $grade_level = $_POST['grade_level'];
            $gender = $_POST['gender'];
            $section = $_POST['section'];
            $adviser = $_POST['adviser'];
            $schedule = $_POST['schedule'];
            $status = $_POST['status'];
            $additional_details = $_POST['additional_details']; // New field

            $sql = "UPDATE counseling_records SET lrn = ?, name = ?, grade_level = ?, gender = ?, section = ?, adviser = ?, schedule = ?, status = ?, additional_details = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$lrn, $name, $grade_level, $gender, $section, $adviser, $schedule, $status, $additional_details, $id]);

            header("Location: counseling.php?success=Record updated successfully");
            exit;
        }
    } else {
        header("Location: counseling.php?error=Invalid record ID");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Counseling details </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <style>
        body {
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
    <script>
        // JavaScript to handle autofill functionality
        const students = <?= json_encode($students) ?>;

        function autofillFields(selectedLRN) {
            const student = students.find(s => s.lrn === selectedLRN);
            if (student) {
                document.getElementById('name').value = student.name;
                document.getElementById('grade_level').value = student.grade_level;
                document.getElementById('gender').value = student.gender;
                document.getElementById('section').value = student.section;
                document.getElementById('adviser').value = student.adviser;
            }
        }
    </script>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Edit Counseling Record</h1>
        <form method="post" action="req/counseling-edit.php" class="shadow p-4 mt-4 bg-light rounded">
            <input type="hidden" name="id" value="<?= $record['id'] ?>">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($record['first_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($record['last_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="schedule" class="form-label">Schedule</label>
                <input type="datetime-local" class="form-control" id="schedule" name="schedule" value="<?= date('Y-m-d\TH:i', strtotime($record['schedule'])) ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <?php
                    $statuses = [
                        'Pending', 'Scheduled', 'Ongoing', 'Completed', 
                        'Cancelled', 'No Show', 'Rescheduled', 
                        'Referred', 'Follow-Up Needed', 'Closed'
                    ];
                    foreach ($statuses as $status) {
                        $selected = $record['status'] === $status ? 'selected' : '';
                        echo "<option value=\"$status\" $selected>$status</option>";
                    }
                    ?>
                </select>
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