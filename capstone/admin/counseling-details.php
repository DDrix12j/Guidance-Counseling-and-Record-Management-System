<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
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
    <title>Counseling details </title>
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
        <h1 class="text-center">Counseling Details</h1>
        <table class="table table-bordered mt-4">
            <tr>
                <th>ID</th>
                <td><?= $record['id'] ?></td>
            </tr>
            <tr>
                <th>LRN</th>
                <td><?= $record['lrn'] ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= $record['name'] ?></td>
            </tr>
            <tr>
                <th>Grade Level</th>
                <td><?= $record['grade_level'] ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= $record['gender'] ?></td>
            </tr>
            <tr>
                <th>Section</th>
                <td><?= $record['section'] ?></td>
            </tr>
            <tr>
                <th>Adviser</th>
                <td><?= $record['adviser'] ?></td>
            </tr>
            <tr>
                <th>Schedule</th>
                <td><?= $record['schedule'] ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= $record['status'] ?></td>
            </tr>
            <tr>
                <th>Additional Details</th>
                <td><?= nl2br(htmlspecialchars($record['additional_details'])) ?></td>
            </tr>
        </table>
        <a href="counseling.php" class="btn btn-primary">Back to Counseling Records</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>