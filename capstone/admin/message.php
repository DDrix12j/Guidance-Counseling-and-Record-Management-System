<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/message.php";

        // Reset the new messages count
        $sql = "UPDATE message SET is_new = 0 WHERE is_new = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Handle status update and admin message
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['update_status'])) {
                $message_id = $_POST['message_id'];
                $admin_message = $_POST['admin_message'];

                $sql = "UPDATE message SET status = 'In Progress', admin_message = ? WHERE message_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$admin_message, $message_id]);

                header("Location: message.php?success=Status and message updated successfully");
                exit;
            }
            // Handle archiving a message
            if (isset($_POST['archive_message'])) {
                $message_id = $_POST['message_id'];

                $sql = "UPDATE message SET is_archived = 1 WHERE message_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$message_id]);

                header("Location: message.php?success=Message archived successfully");
                exit;
            }

            // Handle deleting a message
            if (isset($_POST['delete_message'])) {
                $message_id = $_POST['message_id'];

                $sql = "DELETE FROM message WHERE message_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$message_id]);

                // Redirect based on the current view
                if (isset($_GET['view']) && $_GET['view'] === 'archived') {
                    header("Location: message.php?view=archived&success=Message deleted successfully");
                } else {
                    header("Location: message.php?success=Message deleted successfully");
                }
                exit;
            }

            // Handle marking a message as completed
            if (isset($_POST['mark_completed'])) {
                $message_id = $_POST['message_id'];

                $sql = "UPDATE message SET status = 'Completed' WHERE message_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$message_id]);

                header("Location: message.php?success=Request marked as Completed successfully");
                exit;
            }
        }

        // Handle sorting, filtering, and searching
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'message_id';
        $filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
        $search_tracking = isset($_GET['search_tracking']) ? $_GET['search_tracking'] : '';

        // Build the query dynamically
        $query = "SELECT * FROM message WHERE is_archived = " . (isset($_GET['view']) && $_GET['view'] === 'archived' ? "1" : "0");
        if (!empty($filter_status)) {
            $query .= " AND status = :filter_status";
        }
        if (!empty($search_tracking)) {
            $query .= " AND tracking_number LIKE :search_tracking";
        }
        $query .= " ORDER BY $sort_by DESC";

        $stmt = $conn->prepare($query);
        if (!empty($filter_status)) {
            $stmt->bindParam(':filter_status', $filter_status);
        }
        if (!empty($search_tracking)) {
            $search_tracking = "%$search_tracking%";
            $stmt->bindParam(':search_tracking', $search_tracking);
        }
        $stmt->execute();
        $messages = $stmt->fetchAll();

        // Fetch all LRNs from the students table
        $student_lrns = $conn->query("SELECT lrn FROM students")->fetchAll(PDO::FETCH_COLUMN);

        // Add a column to indicate if the sender's LRN is valid
        foreach ($messages as &$message) {
            $message['is_lrn_valid'] = in_array($message['sender_full_name'], $student_lrns);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Request and Support</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="../logo.png">
    <style>
        body {
            overflow-y: auto;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }

        .table-container {
            max-height: 600px; /* Set a larger fixed height for scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .table tbody tr {
            height: 70px; /* Increase the height of each row */
        }

        .table {
            font-size: 1.1rem; /* Increase font size for better readability */
        }

        .btn-icon {
            padding: 5px;
            font-size: 0.9rem;
        }

        .btn-icon i {
            margin: 0;
        }

        .form-label {
            font-weight: bold;
        }

        .mb-3, .table-container {
            margin-bottom: 20px; /* Add spacing between elements */
        }

        .table th, .table td {
            vertical-align: middle; /* Center align text vertically */
        }

        .btn-group {
            display: flex;
            gap: 5px; /* Add spacing between buttons */
        }

        .status-column {
            width: 10%; /* Make the status column smaller */
        }

        .admin-message-column {
            width: 30%; /* Make the admin message column bigger */
        }

        .actions-column {
            width: 10%;
        }
    </style>
    <style>
        .table td, .table th {
            vertical-align: middle; /* Center content vertically */
            text-align: center; /* Center content horizontally */
        }

        .btn-info {
            display: inline-block; /* Ensure the button is treated as an inline element */
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container-fluid mt-5">
        <h1 class="text-center mb-4"><?= isset($_GET['view']) && $_GET['view'] === 'archived' ? 'Archived Requests' : 'Request and Support' ?></h1>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php } ?>

        <div class="mb-4 text-center">
            <?php if (isset($_GET['view']) && $_GET['view'] === 'archived') { ?>
                <a href="message.php" class="btn btn-primary btn-icon">
                    <i class="fa fa-arrow-left"></i>
                </a>
            <?php } else { ?>
                <a href="message.php?view=archived" class="btn btn-secondary btn-icon">
                    <i class="fa fa-archive"></i>
                </a>
                <a href="message-history.php" class="btn btn-info btn-icon">
                    <i class="fa fa-history"></i>
                </a>
            <?php } ?>
        </div>

        <!-- Sorting, Filtering, and Search Form -->
        <form method="get" class="row g-3 mb-4 mx-3">
            <input type="hidden" name="view" value="<?= isset($_GET['view']) && $_GET['view'] === 'archived' ? 'archived' : '' ?>">
            <div class="col-md-4">
                <label for="sort_by" class="form-label">Sort By</label>
                <select name="sort_by" id="sort_by" class="form-select">
                    <option value="message_id" <?= $sort_by === 'message_id' ? 'selected' : '' ?>>Default</option>
                    <option value="sender_full_name" <?= $sort_by === 'sender_full_name' ? 'selected' : '' ?>>Sender Name</option>
                    <option value="status" <?= $sort_by === 'status' ? 'selected' : '' ?>>Status</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter_status" class="form-label">Filter by Status</label>
                <select name="filter_status" id="filter_status" class="form-select">
                    <option value="">All</option>
                    <option value="Pending" <?= $filter_status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $filter_status === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Completed" <?= $filter_status === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search_tracking" class="form-label">Search by Tracking Number</label>
                <input type="text" name="search_tracking" id="search_tracking" class="form-control" value="<?= htmlspecialchars($search_tracking) ?>" placeholder="Enter tracking number">
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="fa fa-filter"></i> Apply
                </button>
                <a href="message.php" class="btn btn-secondary btn-icon">
                    <i class="fa fa-undo"></i> Reset
                </a>
            </div>
        </form>

        <?php if ($messages) { ?>
        <div class="table-container table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>LRN</th>
                        <th>Email</th>
                        <th>Type of Request</th>
                        <th>Sender Message</th> <!-- Updated column header -->
                        <th>Tracking Number</th>
                        <th class="status-column">Status</th>
                        <th class="admin-message-column">Admin Message</th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($messages as $message) { $i++; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>
                            <?php if ($message['is_lrn_valid']) { ?>
                                
                                <a href="student.php?highlight_lrn=<?= urlencode($message['sender_full_name']) ?>" class="text-decoration-none" style="color: black;">
                                   <?= htmlspecialchars($message['sender_full_name']) ?>
                                </a>
                             <?php } else { ?>
                <span style="color: red;"><?= htmlspecialchars($message['sender_full_name']) ?></span>
            <?php } ?>
                        </td>
                        <td><?= htmlspecialchars($message['sender_email']) ?></td>
                        <td><?= htmlspecialchars($message['type_of_request']) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewMessageModal<?= $message['message_id'] ?>">
                                View
                            </button>
                        </td>
                        <td><?= htmlspecialchars($message['tracking_number']) ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                <select class="form-select form-select-sm" name="status" required>
                                    <option value="Pending" <?= ($message['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                    <option value="In Progress" <?= ($message['status'] == 'In Progress') ? 'selected' : '' ?>>In Progress</option>
                                    <option value="Completed" <?= ($message['status'] == 'Completed') ? 'selected' : '' ?>>Completed</option>
                                </select>
                        </td>
                        <td>
                            <textarea class="form-control form-control-sm" name="admin_message" rows="3"><?= htmlspecialchars($message['admin_message'] ?? '') ?></textarea>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="submit" name="update_status" class="btn btn-primary btn-sm">
                                    Save
                                </button>
                            </form>
                            <?php if ($message['status'] !== 'Completed') { ?>
                                <form action="" method="post" style="display: inline-block;">
                                    <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                    <button type="submit" name="mark_completed" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to mark this request as Completed?')">
                                        Complete
                                    </button>
                                </form>
                            <?php } ?>
                            <?php if (!isset($_GET['view']) || $_GET['view'] !== 'archived') { ?>
                                <form action="" method="post" style="display: inline-block;">
                                    <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                    <button type="submit" name="archive_message" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to archive this request?')">
                                        Archive
                                    </button>
                                </form>
                            <?php } else { ?>
                                <form action="" method="post" style="display: inline-block;">
                                    <input type="hidden" name="message_id" value="<?= $message['message_id'] ?>">
                                    <button type="submit" name="delete_message" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this request?')">
                                        Delete
                                    </button>
                                </form>
                            <?php } ?>
                            </div>
                        </td>
                    </tr>

                    <!-- View Message Modal -->
                    <div class="modal fade" id="viewMessageModal<?= $message['message_id'] ?>" tabindex="-1" aria-labelledby="viewMessageModalLabel<?= $message['message_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewMessageModalLabel<?= $message['message_id'] ?>">Message Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= nl2br(htmlspecialchars($message['message'])) ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="alert alert-info text-center" role="alert">
            No requests found!
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