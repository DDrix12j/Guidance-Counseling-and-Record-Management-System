<!-- filepath: d:\aaaa\htdocs\capstonework\capstone\admin\violations-add.php -->
<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Fetch all students from the database
    $students = $conn->query("SELECT lrn, fname AS first_name, lname AS last_name, grade AS grade_level, section FROM students")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch violation counts for each student (LRN)
    $violation_counts = [];
    $violationStmt = $conn->query("SELECT lrn, COUNT(*) as count FROM violations_records GROUP BY lrn");
    foreach ($violationStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $violation_counts[$row['lrn']] = $row['count'];
    }

    // Define holidays and non-working days
    $holidays = [
        '2025-01-01', '2025-04-01', '2025-04-09', '2025-04-17', '2025-04-18',
        '2025-05-01', '2025-06-12', '2025-08-21', '2025-08-25', '2025-10-31',
        '2025-11-01', '2025-11-30', '2025-12-08', '2025-12-24', '2025-12-25',
        '2025-12-30', '2025-12-31'
    ];

    // Limit scheduling to the next 3 months
    $minDate = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+3 months'));

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

        $sql = "INSERT INTO violations_records (lrn, name, grade_level, section, violation, offense, type_of_offense, sanction, date, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$lrn, $name, $grade_level, $section, $violation, $offense, $type_of_offense, $sanction, $date, $status]);

        header("Location: violations.php?success=Violation added successfully");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Violation</title>
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
    </style>
    <script>
        const students = <?= json_encode($students) ?>;
        const disabledDates = <?= json_encode($holidays) ?>;
        const violationCounts = <?= json_encode($violation_counts) ?>;

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
            document.getElementById('name').value = `${student.first_name} ${student.last_name}`;
            document.getElementById('grade_level').value = student.grade_level;
            document.getElementById('section').value = student.section;

            // Show violation history and recommendation
            showViolationHistory(student.lrn);

            document.querySelectorAll('.suggestions').forEach(suggestion => {
                suggestion.style.display = 'none';
            });
        }

        function showViolationHistory(lrn) {
            const historyDiv = document.getElementById('violation-history');
            let count = violationCounts[lrn] ? violationCounts[lrn] : 0;
            let recommendation = '';
            if (count === 0) {
                recommendation = '<span class="badge bg-success">First Offense - Recommend Warning</span>';
            } else if (count === 1) {
                recommendation = '<span class="badge bg-warning text-dark">Second Offense - Recommend Parent Conference</span>';
            } else {
                recommendation = '<span class="badge bg-danger">Multiple Offenses - Recommend Suspension or Higher Sanction</span>';
            }
            historyDiv.innerHTML = `<strong>Prior Violations:</strong> ${count}<br>${recommendation}`;
            historyDiv.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date');
            dateInput.setAttribute('min', '<?= $minDate ?>');
            dateInput.setAttribute('max', '<?= $maxDate ?>');

            dateInput.addEventListener('input', function () {
                const selectedDate = this.value.split('T')[0];
                if (disabledDates.includes(selectedDate)) {
                    alert('The selected date is a holiday or non-working day. Please choose another date.');
                    this.value = '';
                }
            });

            // Show violation history if LRN is already filled
            const lrnInput = document.getElementById('lrn');
            lrnInput.addEventListener('blur', function () {
                if (this.value.trim() !== '') {
                    showViolationHistory(this.value.trim());
                }
            });
        });
    </script>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Add Student Violation</h1>
        <div id="violation-history" class="mb-3" style="display:none;"></div>
        <form method="post" action="" class="shadow p-4 mt-4 bg-light rounded">
            <div class="mb-3 position-relative">
                <label for="lrn" class="form-label">LRN</label>
                <input type="text" class="form-control" id="lrn" name="lrn" placeholder="Enter LRN" 
                       oninput="showSuggestions('lrn', 'lrn-suggestions')" autocomplete="off" required>
                <div id="lrn-suggestions" class="suggestions"></div>
            </div>
            <div class="mb-3 position-relative">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" 
                       oninput="showSuggestions('name', 'name-suggestions')" autocomplete="off" required>
                <div id="name-suggestions" class="suggestions"></div>
            </div>
            <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <input type="text" class="form-control" id="grade_level" name="grade_level" required>
            </div>
            <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" required>
            </div>
            <div class="mb-3">
                <label for="violation" class="form-label">Violation</label>
                <select class="form-control" id="violation" name="violation" required>
                    <option value="">Select a Violation</option>
                    <option value="1. Carrying deadly weapons within school premises.">1. Carrying deadly weapons within school premises.</option>
                    <option value="2. Possession or drinking of alcoholic beverages on campus.">2. Possession or drinking of alcoholic beverages on campus.</option>
                    <option value="3. Possession, trafficking, or use of prohibited drugs.">3. Possession, trafficking, or use of prohibited drugs.</option>
                    <option value="4. Involvement in fistfights or physical harm to others.">4. Involvement in fistfights or physical harm to others.</option>
                    <option value="5. Vandalism or destruction of school property.">5. Vandalism or destruction of school property.</option>
                    <option value="6. Any form of cheating.">6. Any form of cheating.</option>
                    <option value="7. Extortion, blackmail, or theft.">7. Extortion, blackmail, or theft.</option>
                    <option value="8. Gambling or betting within campus.">8. Gambling or betting within campus.</option>
                    <option value="9. Disrupting school activities that cause disorder.">9. Disrupting school activities that cause disorder.</option>
                    <option value="10. Unauthorized solicitation.">10. Unauthorized solicitation.</option>
                    <option value="11. Using cellphones/electronic gadgets for personal use in restricted areas.">11. Using cellphones/electronic gadgets for personal use in restricted areas.</option>
                    <option value="12. Wearing improper attire (e.g., shorts, caps, slippers, spaghetti straps).">12. Wearing improper attire (e.g., shorts, caps, slippers, spaghetti straps).</option>
                    <option value="13. Unkempt hair or faddish hairstyles.">13. Unkempt hair or faddish hairstyles.</option>
                    <option value="14. Colored hair, nail polish, or excessive makeup.">14. Colored hair, nail polish, or excessive makeup.</option>
                    <option value="15. Wearing earrings (for boys) or multiple earrings (for girls).">15. Wearing earrings (for boys) or multiple earrings (for girls).</option>
                    <option value="16. Body piercings (except for earrings).">16. Body piercings (except for earrings).</option>
                    <option value="17. Visible tattoos.">17. Visible tattoos.</option>
                    <option value="18. Unauthorized use of school facilities.">18. Unauthorized use of school facilities.</option>
                    <option value="19. Unexcused absences.">19. Unexcused absences.</option>
                    <option value="20. Littering.">20. Littering.</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="offense" class="form-label">Offense</label>
                <select class="form-control" id="offense" name="offense" required>
                    <option value="1st">1st Offense</option>
                    <option value="2nd">2nd Offense</option>
                    <option value="3rd">3rd Offense</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_of_offense" class="form-label">Type of Offense</label>
                <select class="form-control" id="type_of_offense" name="type_of_offense" required>
                    <option value="Minor">Minor</option>
                    <option value="Major">Major</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sanction" class="form-label">Sanction</label>
                <select class="form-control" id="sanction" name="sanction" required>
                    <option value="Warning">Warning</option>
                    <option value="1-Day Suspension">1-Day Suspension</option>
                    <option value="2-Days Suspension">2-Days Suspension</option>
                    <option value="5-Days Suspension">5-Days Suspension</option>
                    <option value="Forced Transfer">Forced Transfer</option>
                    <option value="Preventive Suspension">Preventive Suspension</option>
                    <option value="Punitive Suspension">Punitive Suspension</option>
                    <option value="Expulsion">Expulsion</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="date" name="date" required>
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
            <button type="submit" class="btn btn-primary">Add Violation</button>
        </form>
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