<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";

        // Fetch existing data for Students
        $students = $conn->query("SELECT lrn, fname AS first_name, lname AS last_name, grade, gender, section, adviser FROM students")->fetchAll(PDO::FETCH_ASSOC);

        // Limit schedule within 3 months from now
        $minDate = date('Y-m-d\TH:i');
        $maxDate = date('Y-m-d\TH:i', strtotime('+3 months'));

        // Holiday / Non-working days (format: YYYY-MM-DD)
        $nonWorkingDays = [
            "2025-01-01", "2025-04-01", "2025-04-09", "2025-04-17",
            "2025-04-18", "2025-04-19", "2025-05-01", "2025-06-12",
            "2025-08-21", "2025-08-25", "2025-10-31", "2025-11-01",
            "2025-11-30", "2025-12-08", "2025-12-24", "2025-12-25",
            "2025-12-30", "2025-12-31"
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lrn = $_POST['lrn'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $grade_level = $_POST['grade_level'];
            $gender = $_POST['gender'];
            $section = $_POST['section'];
            $adviser = $_POST['adviser'];
            $schedule = $_POST['schedule'];
            $status = $_POST['status'];
            $additional_details = $_POST['additional_details'];

            $sql = "INSERT INTO counseling_records (lrn, first_name, last_name, grade_level, gender, section, adviser, schedule, status, additional_details) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$lrn, $first_name, $last_name, $grade_level, $gender, $section, $adviser, $schedule, $status, $additional_details]);

            header("Location: counseling.php?success=Record added successfully");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Counseling Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script>
        const students = <?= json_encode($students) ?>;
        const disabledDates = <?= json_encode($nonWorkingDays) ?>;
    </script>

    <style>
        .suggestions {
            border: 1px solid #ccc;
            background-color: #fff;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            width: 100%;
            display: none;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
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
        <h1 class="text-center">Add Counseling Record</h1>
        <form method="post" action="" class="shadow p-4 mt-4 bg-light rounded">
            <div class="mb-3 position-relative">
                <label for="lrn" class="form-label">LRN (12 Digits)</label>
                <input type="text" class="form-control" id="lrn" name="lrn" placeholder="Enter LRN" 
                       oninput="showSuggestions('lrn', 'lrn-suggestions')" autocomplete="off" required>
                <div id="lrn-suggestions" class="suggestions"></div>
            </div>
            <div class="mb-3 position-relative">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" 
                       oninput="showSuggestions('first_name', 'first-name-suggestions')" autocomplete="off" required>
                <div id="first-name-suggestions" class="suggestions"></div>
            </div>
            <div class="mb-3 position-relative">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" 
                       oninput="showSuggestions('last_name', 'last-name-suggestions')" autocomplete="off" required>
                <div id="last-name-suggestions" class="suggestions"></div>
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <input type="text" class="form-control" id="grade_level" name="grade_level" placeholder="Enter grade level" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" placeholder="Enter section" required>
            </div>
            <div class="mb-3">
                <label for="adviser" class="form-label">Adviser</label>
                <input type="text" class="form-control" id="adviser" name="adviser" placeholder="Enter adviser" required>
            </div>
            <div class="mb-3">
                <label for="schedule" class="form-label">Schedule</label>
                <input type="datetime-local" class="form-control" id="schedule" name="schedule" required 
                       min="<?= $minDate ?>" max="<?= $maxDate ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="No Show">No Show</option>
                    <option value="Rescheduled">Rescheduled</option>
                    <option value="Referred">Referred</option>
                    <option value="Follow-Up Needed">Follow-Up Needed</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="additional_details" class="form-label">Additional Details</label>
                <textarea class="form-control" id="additional_details" name="additional_details" placeholder="Enter additional details"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Record</button>
        </form>
    </div>

    <script>
        function showSuggestions(inputId, suggestionsId) {
            const input = document.getElementById(inputId);
            const suggestions = document.getElementById(suggestionsId);
            const query = input.value.trim().toLowerCase();

            suggestions.innerHTML = '';

            if (query.length > 0) {
                const filteredStudents = students.filter(student =>
                    student.lrn.toLowerCase().includes(query) ||
                    student.first_name.toLowerCase().includes(query) ||
                    student.last_name.toLowerCase().includes(query)
                );

                filteredStudents.forEach(student => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'suggestion-item';
                    suggestionItem.textContent = `${student.first_name} ${student.last_name} (${student.lrn})`;
                    suggestionItem.onclick = () => fillFields(student);
                    suggestions.appendChild(suggestionItem);
                });

                suggestions.style.display = filteredStudents.length > 0 ? 'block' : 'none';
            } else {
                suggestions.style.display = 'none';
            }
        }

        function fillFields(student) {
            document.getElementById('lrn').value = student.lrn;
            document.getElementById('first_name').value = student.first_name;
            document.getElementById('last_name').value = student.last_name;
            document.getElementById('grade_level').value = student.grade;
            document.getElementById('gender').value = student.gender;
            document.getElementById('section').value = student.section;
            document.getElementById('adviser').value = student.adviser;

            document.querySelectorAll('.suggestions').forEach(suggestion => {
                suggestion.style.display = 'none';
            });
        }

        document.getElementById('schedule').addEventListener('input', function () {
            const input = this;
            const selectedDate = new Date(input.value);
            const selectedDateOnly = selectedDate.toISOString().split('T')[0];

            if (disabledDates.includes(selectedDateOnly)) {
                alert("Selected date is a holiday or non-working day. Please choose another date.");
                input.value = '';
            }
        });
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
