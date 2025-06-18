<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";

        // Fetch counseling records (excluding archived)
        $searchKey = isset($_GET['searchKey']) ? trim($_GET['searchKey']) : '';
        if (!empty($searchKey)) {
            // Search query
            $sql = "SELECT * FROM counseling_records 
                    WHERE is_archived = 0 
                    AND (lrn LIKE ? OR name LIKE ? OR grade_level LIKE ? OR section LIKE ? OR adviser LIKE ?)";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%$searchKey%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        } else {
            // Default query
            $sql = "SELECT * FROM counseling_records WHERE is_archived = 0";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Counseling Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <h1 class="text-center">Counseling Records</h1>
        <div class="d-flex justify-content-between mb-3">
    <div>
        <a href="counseling-add.php" class="btn btn-dark">Add New</a>
        <a href="counseling-archive.php" class="btn btn-secondary ms-2">View Archived</a>
    </div>
    <form action="counseling.php" method="get" class="d-flex align-items-center">
        <input type="text" name="searchKey" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($searchKey) ?>" style="height: 38px;">
        <button class="btn btn-primary ms-2 d-flex align-items-center justify-content-center" style="height: 38px; width: 38px;">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>
<script>
    // JavaScript to handle inline editing of the status column
    function makeStatusEditable(recordId, currentStatus) {
        const statusCell = document.getElementById(`status-${recordId}`);
        const statusOptions = [
            'Pending', 'Scheduled', 'Ongoing', 'Completed', 
            'Cancelled', 'No Show', 'Rescheduled', 
            'Referred', 'Follow-Up Needed', 'Closed'
        ];

        // Create a dropdown
        const select = document.createElement('select');
        select.className = 'form-select form-select-sm';
        select.style.width = '150px';

        // Populate the dropdown with options
        statusOptions.forEach(status => {
            const option = document.createElement('option');
            option.value = status;
            option.textContent = status;
            if (status === currentStatus) {
                option.selected = true;
            }
            select.appendChild(option);
        });

        // Replace the cell content with the dropdown
        statusCell.innerHTML = '';
        statusCell.appendChild(select);

        // Add an event listener to save the new status
        select.addEventListener('change', () => {
            const newStatus = select.value;

            // Send the updated status to the server
            fetch('req/update-status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: recordId, status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the cell with the new status
                    statusCell.innerHTML = newStatus;
                } else {
                    alert('Failed to update status. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
        });
    }
</script>

<div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Grade Level</th>
                        <th>Gender</th>
                        <th>Section</th>
                        <th>Adviser</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record) { ?>
                        <tr>
                            <td><?= htmlspecialchars($record['first_name']) ?></td>
                            <td><?= htmlspecialchars($record['last_name']) ?></td>
                            <td><?= htmlspecialchars($record['grade_level']) ?></td>
                            <td><?= htmlspecialchars($record['gender']) ?></td>
                            <td><?= htmlspecialchars($record['section']) ?></td>
                            <td><?= htmlspecialchars($record['adviser']) ?></td>
                            <td><?= date('M d Y', strtotime($record['schedule'])) ?></td>
                            <td id="status-<?= $record['id'] ?>" onclick="makeStatusEditable(<?= $record['id'] ?>, '<?= htmlspecialchars($record['status']) ?>')">
                                <?= htmlspecialchars($record['status']) ?>
                            </td>
                            <td>
                                <a href="counseling-details.php?id=<?= $record['id'] ?>" class="btn btn-info">Details</a>
                                <a href="counseling-edit.php?id=<?= $record['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="req/counseling-archive.php?id=<?= $record['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to archive this record?');">Archive</a>
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