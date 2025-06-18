<!-- filepath: d:\aaaa\htdocs\capstonework\capstone\admin\violations.php -->
<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Fetch violations records
    $sql = "SELECT * FROM violations_records";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violations Records</title>
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
        <h1 class="text-center">Violations Records</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="violations-add.php" class="btn btn-dark">Add New Violation</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>LRN</th>
                        <th>Name</th>
                        <th>Grade Level</th>
                        <th>Section</th>
                        <th>Violation</th>
                        <th>Offense</th>
                        <th>Type of Offense</th>
                        <th>Sanction</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record) { ?>
                        <tr>
                            <td><?= htmlspecialchars($record['lrn']) ?></td>
                            <td><?= htmlspecialchars($record['name']) ?></td>
                            <td><?= htmlspecialchars($record['grade_level']) ?></td>
                            <td><?= htmlspecialchars($record['section']) ?></td>
                            <td><?= htmlspecialchars($record['violation']) ?></td>
                            <td><?= htmlspecialchars($record['offense']) ?></td>
                            <td><?= htmlspecialchars($record['type_of_offense']) ?></td>
                            <td><?= htmlspecialchars($record['sanction']) ?></td>
                            <td>
                                <?php
                                    $date = $record['date'];
                                    // If your DB stores as 'Y-m-d H:i:s' or 'Y-m-d H:i'
                                    $timestamp = strtotime($date);
                                    echo date('F j, Y g:i A', $timestamp);
                                ?>
                            </td>
                            <td><?= htmlspecialchars($record['status']) ?></td>
                            <td>
                                <a href="violations-edit.php?id=<?= $record['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="req/violations-delete.php?id=<?= $record['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
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