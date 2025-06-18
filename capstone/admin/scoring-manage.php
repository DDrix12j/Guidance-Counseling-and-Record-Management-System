<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Handle form submission for updating career suggestions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['results'])) {
            foreach ($_POST['results'] as $category_id => $data) {
                $jobs = isset($data['jobs']) ? implode(', ', $data['jobs']) : '';
                $courses = isset($data['courses']) ? implode(', ', $data['courses']) : '';
                $track = isset($data['track']) ? implode(', ', $data['track']) : '';
                $clusters = isset($data['clusters']) ? implode(', ', $data['clusters']) : '';

                $stmt = $conn->prepare("INSERT INTO career_suggestions (category_id, jobs, courses, track, clusters) 
                                        VALUES (?, ?, ?, ?, ?) 
                                        ON DUPLICATE KEY UPDATE 
                                        jobs = VALUES(jobs), 
                                        courses = VALUES(courses), 
                                        track = VALUES(track), 
                                        clusters = VALUES(clusters)");
                if (!$stmt->execute([$category_id, $jobs, $courses, $track, $clusters])) {
                    echo "Error: " . implode(", ", $stmt->errorInfo());
                    exit;
                }
            }
        }

        header("Location: scoring-manage.php?success=Results updated successfully");
        exit;
    }

    // Fetch career suggestions
    $career_suggestions = $conn->query("SELECT cs.*, qc.name AS category_name 
                                        FROM career_suggestions cs 
                                        JOIN quiz_categories qc ON cs.category_id = qc.id")->fetchAll(PDO::FETCH_ASSOC);
    $career_suggestions_map = [];
    foreach ($career_suggestions as $suggestion) {
        $career_suggestions_map[$suggestion['category_id']] = $suggestion;
    }

    // Fetch all categories
    $categories = $conn->query("SELECT * FROM quiz_categories")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch distinct suggestions for jobs, courses, tracks, and clusters
    $all_jobs = $conn->query("SELECT DISTINCT jobs FROM career_suggestions")->fetchAll(PDO::FETCH_COLUMN);
    $all_courses = $conn->query("SELECT DISTINCT courses FROM career_suggestions")->fetchAll(PDO::FETCH_COLUMN);
    $all_tracks = ['Academic Track', 'Technical Professional (TechPro) Track']; // Fixed to only include valid tracks
    $all_clusters = $conn->query("SELECT DISTINCT clusters FROM career_suggestions WHERE clusters IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);
    $all_clusters = array_unique(array_filter(array_map('trim', explode(',', implode(',', $all_clusters)))));

    // Define keywords for dynamic recommendations
    $keywords = [
        // Logical and Analytical Thinking
        'Logical' => [
            'jobs' => ['Software Developer', 'Data Analyst', 'Engineer'],
            'courses' => ['Computer Science', 'Information Technology', 'Engineering'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],
        'Analysis' => [
            'jobs' => ['Data Scientist', 'Statistician', 'Business Analyst'],
            'courses' => ['Data Science', 'Statistics', 'Business Analytics'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],
        'Problem Solving' => [
            'jobs' => ['Systems Analyst', 'Operations Research Analyst', 'Mathematician'],
            'courses' => ['Operations Research', 'Mathematics', 'Systems Engineering'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],

        // Creativity and Artistic Expression
        'Creativity' => [
            'jobs' => ['Graphic Designer', 'Animator', 'Illustrator'],
            'courses' => ['Fine Arts', 'Art Studies', 'Art Education'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],
        'Art' => [
            'jobs' => ['Painter', 'Sculptor', 'Art Director'],
            'courses' => ['Visual Arts', 'Art History', 'Fine Arts'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],
        'Design' => [
            'jobs' => ['Interior Designer', 'Fashion Designer', 'Industrial Designer'],
            'courses' => ['Interior Design', 'Fashion Design', 'Industrial Design'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],

        // Social and Communication Skills
        'Communication' => [
            'jobs' => ['Journalist', 'Teacher', 'Public Relations Specialist'],
            'courses' => ['Communication Arts', 'Education', 'Public Relations'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],
        'Social' => [
            'jobs' => ['Social Worker', 'Counselor', 'Human Rights Advocate'],
            'courses' => ['Social Work', 'Counseling', 'Sociology'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],
        'Leadership' => [
            'jobs' => ['Manager', 'Team Leader', 'Project Manager'],
            'courses' => ['Management', 'Leadership Studies', 'Business Administration'],
            'track' => ['Academic Track'],
            'clusters' => ['Business and Entrepreneurship']
        ],

        // Business and Entrepreneurship
        'Business' => [
            'jobs' => ['Entrepreneur', 'Marketing Specialist', 'Accountant'],
            'courses' => ['Business Administration', 'Marketing', 'Accountancy'],
            'track' => ['Academic Track'],
            'clusters' => ['Business and Entrepreneurship']
        ],
        'Finance' => [
            'jobs' => ['Financial Analyst', 'Investment Banker', 'Auditor'],
            'courses' => ['Finance', 'Economics', 'Accountancy'],
            'track' => ['Academic Track'],
            'clusters' => ['Business and Entrepreneurship']
        ],
        'Entrepreneurship' => [
            'jobs' => ['Startup Founder', 'Small Business Owner', 'Business Consultant'],
            'courses' => ['Entrepreneurship', 'Business Management', 'Strategic Planning'],
            'track' => ['Academic Track'],
            'clusters' => ['Business and Entrepreneurship']
        ],

        // Healthcare and Service-Oriented Careers
        'Health' => [
            'jobs' => ['Doctor', 'Nurse', 'Pharmacist'],
            'courses' => ['Medicine', 'Nursing', 'Pharmacy'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],
        'Service' => [
            'jobs' => ['Customer Service Representative', 'Hotel Manager', 'Event Planner'],
            'courses' => ['Hospitality Management', 'Tourism', 'Event Management'],
            'track' => ['Academic Track'],
            'clusters' => ['Business and Entrepreneurship']
        ],
        'Care' => [
            'jobs' => ['Caregiver', 'Social Worker', 'Therapist'],
            'courses' => ['Social Work', 'Counseling', 'Therapy'],
            'track' => ['Academic Track'],
            'clusters' => ['Arts, Social Sciences, and Humanities']
        ],

        // Technical and Vocational Careers
        'Technical' => [
            'jobs' => ['Mechanic', 'Electrician', 'Automotive Technician'],
            'courses' => ['Automotive Technology', 'Electrical Installation', 'Mechatronics'],
            'track' => ['Technical Professional (TechPro) Track'],
            'clusters' => ['Industrial Arts and Maritime']
        ],
        'Industrial' => [
            'jobs' => ['HVAC Technician', 'Machinist', 'Industrial Technician'],
            'courses' => ['HVAC Technology', 'Machine Operations', 'Industrial Technology'],
            'track' => ['Technical Professional (TechPro) Track'],
            'clusters' => ['Industrial Arts and Maritime']
        ],
        'Construction' => [
            'jobs' => ['Plumber', 'Welder', 'Carpenter'],
            'courses' => ['Construction Services', 'Welding Technology', 'Plumbing'],
            'track' => ['Technical Professional (TechPro) Track'],
            'clusters' => ['Industrial Arts and Maritime']
        ],

        // STEM and Science Careers
        'Science' => [
            'jobs' => ['Biologist', 'Chemist', 'Physicist'],
            'courses' => ['Biology', 'Chemistry', 'Physics'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],
        'Technology' => [
            'jobs' => ['IT Specialist', 'Web Developer', 'Cybersecurity Analyst'],
            'courses' => ['Information Technology', 'Computer Science', 'Cybersecurity'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],
        'Engineering' => [
            'jobs' => ['Civil Engineer', 'Mechanical Engineer', 'Electrical Engineer'],
            'courses' => ['Civil Engineering', 'Mechanical Engineering', 'Electrical Engineering'],
            'track' => ['Academic Track'],
            'clusters' => ['STEM']
        ],

        // Default Recommendations
        'default' => [
            'jobs' => ['General Worker', 'Assistant', 'Technician'],
            'courses' => ['General Studies', 'Vocational Training'],
            'track' => ['Academic Track', 'Technical Professional (TechPro) Track'],
            'clusters' => ['General']
        ]
    ];

    // Function to get dynamic recommendations
    function getDynamicRecommendations($categoryName, $keywords) {
        $recommendations = [
            'jobs' => [],
            'courses' => [],
            'track' => [],
            'clusters' => []
        ];

        foreach ($keywords as $keyword => $options) {
            if (stripos($categoryName, $keyword) !== false) {
                $recommendations['jobs'] = array_merge($recommendations['jobs'], $options['jobs']);
                $recommendations['courses'] = array_merge($recommendations['courses'], $options['courses']);
                $recommendations['track'] = array_merge($recommendations['track'], $options['track']);
                $recommendations['clusters'] = array_merge($recommendations['clusters'], $options['clusters']);
            }
        }

        // Ensure only two tracks are available and remove duplicates
        $recommendations['track'] = array_unique(['Academic Track', 'Technical Professional (TechPro) Track']);

        // Fallback to default recommendations if no match is found
        if (empty($recommendations['jobs']) && empty($recommendations['courses']) && empty($recommendations['clusters'])) {
            $recommendations = [
                'jobs' => $keywords['default']['jobs'],
                'courses' => $keywords['default']['courses'],
                'track' => array_unique($keywords['default']['track']),
                'clusters' => $keywords['default']['clusters']
            ];
        }

        return $recommendations;
    }

    // Generate recommendations for each category
    $dynamicRecommendations = [];
    foreach ($categories as $category) {
        $dynamicRecommendations[$category['name']] = getDynamicRecommendations($category['name'], $keywords);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Management</title>
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

        .modal-body {
            padding: 20px;
        }

        .form-check-label {
            font-size: 15px;
        }
    </style>
</head>
<body>
<?php include "inc/navbar.php"; ?>
<div class="container mt-5">
    <h1>Results Management</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= $_GET['success'] ?></div>
    <?php endif; ?>

    <div class="alert alert-info">
        <h4>Instructions:</h4>
        <ul>
            <li><strong>Category Results:</strong> Click on a specific column (Jobs, College Courses, Track, or Clusters) to view and edit the options for that column.</li>
        </ul>
    </div>

    <form method="post">
        <h2>Category Results</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Category</th>
                <th>Jobs</th>
                <th>College Courses</th>
                <th>Track</th>
                <th>Clusters</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <?php
                $suggestion = $career_suggestions_map[$category['id']] ?? ['jobs' => '', 'courses' => '', 'track' => '', 'clusters' => ''];
                ?>
                <tr>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td onclick="openModal('jobs', <?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')">
                        <?= htmlspecialchars($suggestion['jobs']) ?>
                    </td>
                    <td onclick="openModal('courses', <?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')">
                        <?= htmlspecialchars($suggestion['courses']) ?>
                    </td>
                    <td onclick="openModal('track', <?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')">
                        <?= htmlspecialchars($suggestion['track']) ?>
                    </td>
                    <td onclick="openModal('clusters', <?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')">
                        <?= htmlspecialchars($suggestion['clusters']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="selectionModal" tabindex="-1" aria-labelledby="selectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectionModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody" style="max-height: 400px; overflow-y: auto;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(type, categoryId, categoryName) {
        const modal = new bootstrap.Modal(document.getElementById('selectionModal'));
        const modalTitle = document.getElementById('selectionModalLabel');
        const modalBody = document.getElementById('modalBody');

        let titleText = '';
        let data = [];
        let recommendations = [];

        const allRecommendations = <?= json_encode($dynamicRecommendations) ?>;

        if (type === 'jobs') {
            titleText = 'Edit Jobs';
            data = <?= json_encode($all_jobs) ?>;
            recommendations = allRecommendations[categoryName]?.jobs || [];
        } else if (type === 'courses') {
            titleText = 'Edit College Courses';
            data = <?= json_encode($all_courses) ?>;
            recommendations = allRecommendations[categoryName]?.courses || [];
        } else if (type === 'track') {
            titleText = 'Edit Track';
            data = ['Academic Track', 'Technical Professional (TechPro) Track'];
            recommendations = [...new Set(allRecommendations[categoryName]?.track || [])]; // Ensure unique tracks
        } else if (type === 'clusters') {
            titleText = 'Edit Clusters';
            data = <?= json_encode($all_clusters) ?>;
            recommendations = allRecommendations[categoryName]?.clusters || [];
        }

        modalTitle.textContent = titleText;

        let options = '';
        recommendations.forEach((item, index) => {
            const safeId = `${type}_${categoryId}_rec_${index}`;
            options += `
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="results[${categoryId}][${type}][]" value="${item}" id="${safeId}">
                    <label class="form-check-label" for="${safeId}">${item}${type !== 'track' ? ' (Recommended)' : ''}</label>
                </div>
            `;
        });

        data.forEach((item, index) => {
            if (!recommendations.includes(item)) {
                const safeId = `${type}_${categoryId}_${index}`;
                options += `
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="results[${categoryId}][${type}][]" value="${item}" id="${safeId}">
                        <label class="form-check-label" for="${safeId}">${item}</label>
                    </div>
                `;
            }
        });

        modalBody.innerHTML = options;
        modal.show();

        document.getElementById('saveChangesBtn').onclick = function () {
            const selectedValues = [];
            const checkboxes = modalBody.querySelectorAll('input[type="checkbox"]:checked');
            checkboxes.forEach(function (checkbox) {
                selectedValues.push(checkbox.value);
            });

            const tableCell = document.querySelector(`td[onclick="openModal('${type}', ${categoryId}, '${categoryName}')"]`);
            tableCell.textContent = selectedValues.join(', ');

            const form = document.querySelector('form');
            const inputName = `results[${categoryId}][${type}][]`;

            const existingInputs = form.querySelectorAll(`input[name="${inputName}"]`);
            existingInputs.forEach(input => input.remove());

            selectedValues.forEach(value => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = inputName;
                hiddenInput.value = value;
                form.appendChild(hiddenInput);
            });

            modal.hide();
        };
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
?>