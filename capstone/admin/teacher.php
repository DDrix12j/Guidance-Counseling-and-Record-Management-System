<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/teacher.php";

        // Fetch sorting and search options
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'teacher_id';
        $search_key = isset($_GET['searchKey']) ? $_GET['searchKey'] : '';

        // Fetch teachers based on sorting and search
        $teachers = getFilteredTeachers($conn, $sort_by, $search_key);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers</title>
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
        <!-- Buttons to add, upload, and download sample -->


        <!-- Sort and Search Form -->
        <form action="teacher.php" method="get" class="mt-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="sort_by" class="form-label">Sort By</label>
                    <select name="sort_by" id="sort_by" class="form-select">
                        <option value="teacher_id" <?= $sort_by === 'teacher_id' ? 'selected' : '' ?>>Default</option>
                        <option value="name" <?= $sort_by === 'name' ? 'selected' : '' ?>>Name</option>
                        <option value="position" <?= $sort_by === 'position' ? 'selected' : '' ?>>Position</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="searchKey" class="form-label">Search</label>
                    <input type="text" name="searchKey" id="searchKey" class="form-control" value="<?= htmlspecialchars($search_key) ?>" placeholder="Search by name, email, etc.">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </form>

        <?php if ($teachers != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <!-- Removed numbering column -->
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Position</th>
                            <th scope="col">Address</th>
                            <th scope="col">Employee Number</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Class</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($teachers as $teacher ) { ?>
                      <tr>
                        <!-- Removed numbering cell -->
                        <td><?=$teacher['fname']?></td>
                        <td><?=$teacher['lname']?></td>
                        <td><?=$teacher['username']?></td>
                        <td><?=$teacher['email_address']?></td>
                        <td><?=$teacher['phone_number']?></td>
                        <td><?= $teacher['position'] ?? 'N/A' ?></td>
                        <td><?=$teacher['address']?></td>
                        <td><?=$teacher['employee_number']?></td>
                        <td>
                            <?php
                                if (!empty($teacher['date_of_birth'])) {
                                    echo date('F d, Y', strtotime($teacher['date_of_birth']));
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
                        <td><?=$teacher['qualification']?></td>
                        <td><?=$teacher['gender']?></td>
                        <td>
                            <?php
                            if (!empty($teacher['subject'])) {
                                echo htmlspecialchars($teacher['subject']);
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td><?=$teacher['class']?></td>
                        <td>
                            <a href="teacher-edit.php?teacher_id=<?=$teacher['teacher_id']?>" class="btn btn-warning">Edit</a>
                            <a href="teacher-delete.php?teacher_id=<?=$teacher['teacher_id']?>" class="btn btn-danger">Delete</a>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
               </div>
             <?php } else { ?>
                 <div class="alert alert-info mt-3" role="alert">
                    No teachers found!
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