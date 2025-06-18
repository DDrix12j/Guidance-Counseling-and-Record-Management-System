<!-- filepath: d:\aaaa\htdocs\capstonework\capstone\admin\violations-edit.php -->
<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the record to edit
        $sql = "SELECT * FROM violations_records WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            header("Location: violations.php?error=Record not found");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lrn = $_POST['lrn'];
            $name = $_POST['name'];
            $grade_level = $_POST['grade_level'];
            $section = $_POST['section'];
            $violation = $_POST['violation'];
            $offense = $_POST['offense'];
            $type_of_offense = $_POST['type_of_offense'];
            $sanction = $_POST['sanction'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            // Update the record
            $sql = "UPDATE violations_records SET lrn = ?, name = ?, grade_level = ?, section = ?, violation = ?, offense = ?, type_of_offense = ?, sanction = ?, date = ?, status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$lrn, $name, $grade_level, $section, $violation, $offense, $type_of_offense, $sanction, $date, $status, $id]);

            header("Location: violations.php?success=Record updated successfully");
            exit;
        }
    } else {
        header("Location: violations.php?error=No ID provided");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violations Records Edit</title>
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
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Edit Violation</h1>
        <form method="post" action="" class="shadow p-4 mt-4 bg-light rounded">
            <div class="mb-3">
                <label for="lrn" class="form-label">LRN</label>
                <input type="text" class="form-control" id="lrn" name="lrn" value="<?= htmlspecialchars($record['lrn']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($record['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?= htmlspecialchars($record['grade_level']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" value="<?= htmlspecialchars($record['section']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="violation" class="form-label">Violation</label>
                <input type="text" class="form-control" id="violation" name="violation" value="<?= htmlspecialchars($record['violation']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="offense" class="form-label">Offense</label>
                <select class="form-control" id="offense" name="offense" required>
                    <option value="1st" <?= $record['offense'] == '1st' ? 'selected' : '' ?>>1st Offense</option>
                    <option value="2nd" <?= $record['offense'] == '2nd' ? 'selected' : '' ?>>2nd Offense</option>
                    <option value="3rd" <?= $record['offense'] == '3rd' ? 'selected' : '' ?>>3rd Offense</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_of_offense" class="form-label">Type of Offense</label>
                <select class="form-control" id="type_of_offense" name="type_of_offense" required>
                    <option value="Minor" <?= $record['type_of_offense'] == 'Minor' ? 'selected' : '' ?>>Minor</option>
                    <option value="Major" <?= $record['type_of_offense'] == 'Major' ? 'selected' : '' ?>>Major</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sanction" class="form-label">Sanction</label>
                <input type="text" class="form-control" id="sanction" name="sanction" value="<?= htmlspecialchars($record['sanction']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($record['date']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending" <?= $record['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Scheduled" <?= $record['status'] == 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="Ongoing" <?= $record['status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <option value="Completed" <?= $record['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Cancelled" <?= $record['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="No Show" <?= $record['status'] == 'No Show' ? 'selected' : '' ?>>No Show</option>
                    <option value="Rescheduled" <?= $record['status'] == 'Rescheduled' ? 'selected' : '' ?>>Rescheduled</option>
                    <option value="Referred" <?= $record['status'] == 'Referred' ? 'selected' : '' ?>>Referred</option>
                    <option value="Follow-Up Needed" <?= $record['status'] == 'Follow-Up Needed' ? 'selected' : '' ?>>Follow-Up Needed</option>
                    <option value="Closed" <?= $record['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Violation</button>
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