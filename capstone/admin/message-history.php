<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";

        // Fetch the history of changes from the `message` table
        $query = "SELECT message_id, sender_full_name, sender_email, message, status, admin_message, date_time 
                  FROM message 
                  ORDER BY date_time DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .container-fluid {
            width: 100%;
            padding: 0;
        }
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
        .table tbody tr {
            height: 70px;
        }
        .table {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container-fluid mt-5">
        <h1 class="text-center">Message History</h1>
        <div class="mb-3 text-center">
            <a href="message.php" class="btn btn-primary">Back to Request and Support</a>
        </div>
        <?php if ($history) { ?>
        <div class="table-container table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sender Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Admin Message</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($history as $entry) { $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= htmlspecialchars($entry['sender_full_name']) ?></td>
                        <td><?= htmlspecialchars($entry['sender_email']) ?></td>
                        <td><?= htmlspecialchars($entry['message']) ?></td>
                        <td><?= htmlspecialchars($entry['status'] ?? 'Pending') ?></td>
                        <td><?= htmlspecialchars($entry['admin_message'] ?? 'No message yet') ?></td>
                        <td><?= htmlspecialchars($entry['date_time']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="alert alert-info text-center" role="alert">
            No history found!
        </div>
        <?php } ?>
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