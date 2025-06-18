<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/student.php";
        include "data/grade.php";
        include "data/section.php";
        include "data/class.php"; // <-- Add this line

        // Fetch sorting and search options
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'fname';
        $search_key = isset($_GET['searchKey']) ? $_GET['searchKey'] : '';

        // Fetch students based on sorting and search
        $students = getFilteredStudents($conn, $sort_by, $search_key);
        
        // Check if a specific LRN needs to be highlighted
        $highlight_lrn = isset($_GET['highlight_lrn']) ? $_GET['highlight_lrn'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Students</title>
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
        <a href="student-add.php" class="btn btn-dark">Add New Student</a>
        <a href="student-upload.php" class="btn btn-primary">Upload Students</a>
        <a href="generate-sample.php" class="btn btn-success">Download Sample</a>

        <!-- Sort and Search Form -->
        <form action="student.php" method="get" class="mt-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="sort_by" class="form-label">Sort By</label>
                    <select name="sort_by" id="sort_by" class="form-select">
                        <option value="fname" <?= $sort_by === 'fname' ? 'selected' : '' ?>>First Name</option>
                        <option value="lname" <?= $sort_by === 'lname' ? 'selected' : '' ?>>Last Name</option>
                        <option value="grade" <?= $sort_by === 'grade' ? 'selected' : '' ?>>Grade</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="searchKey" class="form-label">Search</label>
                    <input type="text" name="searchKey" id="searchKey" class="form-control" value="<?= htmlspecialchars($search_key) ?>" placeholder="Search by name, LRN, etc.">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </form>

        <?php if ($students != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <!-- Removed numbering column -->
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">LRN</th>
                            <th scope="col">Guardian</th>
                            <th scope="col">Address</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Birthplace</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Section</th>
                            <th scope="col">Adviser</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) { ?>
                        <tr class="<?= $student['lrn'] === $highlight_lrn ? 'table-warning' : '' ?>">
                            <!-- Removed numbering cell -->
                            <td><?= htmlspecialchars($student['fname']) ?></td>
                            <td><?= htmlspecialchars($student['lname']) ?></td>
                            <td><?= htmlspecialchars($student['lrn']) ?></td>
                            <td><?= htmlspecialchars($student['guardian']) ?></td>
                            <td><?= htmlspecialchars($student['address']) ?></td>
                            <td>
                                <?php
                                    if (!empty($student['birthday'])) {
                                        echo date('F d, Y', strtotime($student['birthday']));
                                    } else {
                                        echo 'N/A';
                                    }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($student['birthplace']) ?></td>
                            <td><?= htmlspecialchars($student['gender']) ?></td>
                            <td>
                              <?php
                                $grade = getGradeById($student['grade'], $conn);
                                echo is_array($grade) ? $grade['grade_code'].'-'.$grade['grade'] : 'N/A';
                              ?>
                            </td>
                            <td>
                              <?php
                                if (!empty($student['class_id'])) {
                                  $class = getClassById($student['class_id'], $conn);
                                  if (is_array($class)) {
                                    $grade = getGradeById($class['grade'], $conn);
                                    $section = getSectioById($class['section'], $conn);
                                    echo $grade['grade_code'].'-'.$grade['grade'].$section['section'];
                                  } else {
                                    echo 'N/A';
                                  }
                                } else {
                                  echo 'N/A';
                                }
                              ?>
                            </td>
                            <td><?= htmlspecialchars($student['adviser']) ?></td>
                            <td>
                                <button class="btn btn-warning" onclick="showConfirmationModal('student-edit.php?student_id=<?= $student['student_id'] ?>', 'Edit')">Edit</button>
                                <button class="btn btn-danger" onclick="showConfirmationModal('student-delete.php?student_id=<?= $student['student_id'] ?>', 'Delete')">Delete</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                  </table>
               </div>
             <?php } else { ?>
                 <div class="alert alert-info mt-3" role="alert">
                    No students found!
                  </div>
             <?php } ?>
         </div>
         
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to <span id="actionType"></span> this student?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" id="confirmActionButton" class="btn btn-danger">Confirm</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showConfirmationModal(url, action) {
                const confirmButton = document.getElementById('confirmActionButton');
                const actionType = document.getElementById('actionType');
                confirmButton.href = url;
                actionType.textContent = action.toLowerCase();
                confirmButton.className = action === 'Delete' ? 'btn btn-danger' : 'btn btn-warning';
                const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                modal.show();
            }
        </script>
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