<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";

        // Fetch archived counseling records
        $sql = "SELECT * FROM counseling_records WHERE is_archived = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Counseling Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Archived Counseling Records</h1>
        <a href="counseling.php" class="btn btn-primary mb-3">Back to Active Records</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>LRN</th>
                        <th>Name</th>
                        <th>Grade Level</th>
                        <th>Gender</th>
                        <th>Section</th>
                        <th>Adviser</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Additional Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record) { ?>
                        <tr>
                            <td><?= $record['id'] ?></td>
                            <td><?= $record['lrn'] ?></td>
                            <td><?= $record['name'] ?></td>
                            <td><?= $record['grade_level'] ?></td>
                            <td><?= $record['gender'] ?></td>
                            <td><?= $record['section'] ?></td>
                            <td><?= $record['adviser'] ?></td>
                            <td><?= $record['schedule'] ?></td>
                            <td><?= $record['status'] ?></td>
                            <td><?= $record['additional_details'] ?></td>
                            <td>
                                <form method="post" action="req/counseling-delete.php" onsubmit="return confirm('Are you sure you want to delete this record?');" style="display: inline-block;">
                                    <input type="hidden" name="record_id" value="<?= $record['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form method="post" action="req/counseling-restore.php" onsubmit="return confirm('Are you sure you want to restore this record?');" style="display: inline-block;">
                                    <input type="hidden" name="record_id" value="<?= $record['id'] ?>">
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>
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
} else {
    header("Location: ../login.php");
    exit;
}
?>