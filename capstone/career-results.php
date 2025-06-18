<?php
include "DB_connection.php";
session_start();

if (!isset($_SESSION['results']) || !isset($_SESSION['top_categories'])) {
    header("Location: career-guidance.php");
    exit;
}

$results = $_SESSION['results'];
$top_categories = $_SESSION['top_categories'];

// Fetch career suggestions dynamically from the database
$suggestions_stmt = $conn->query("SELECT cs.*, qc.name AS category_name 
                                  FROM career_suggestions cs 
                                  JOIN quiz_categories qc ON cs.category_id = qc.id");
$career_suggestions = [];
while ($row = $suggestions_stmt->fetch(PDO::FETCH_ASSOC)) {
    $career_suggestions[$row['category_name']] = [
        'jobs' => $row['jobs'] ?? 'No jobs available',
        'courses' => $row['courses'] ?? 'No courses available',
        'track' => $row['track'] ?? 'No track available',
        'clusters' => $row['clusters'] ?? 'No clusters available'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Career Guidance Results</h1>
        <canvas id="resultsChart"></canvas>
        <script>
            const ctx = document.getElementById('resultsChart').getContext('2d');
            const resultsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_keys($results)) ?>,
                    datasets: [{
                        label: 'Scores',
                        data: <?= json_encode(array_values($results)) ?>,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <h2>Top Recommendations</h2>
        <?php foreach ($top_categories as $category => $score): ?>
            <h3><?= htmlspecialchars($category) ?></h3>
            <p><strong>Jobs:</strong> <?= isset($career_suggestions[$category]) ? htmlspecialchars($career_suggestions[$category]['jobs']) : 'No suggestions available' ?></p>
            <p><strong>College Courses:</strong> <?= isset($career_suggestions[$category]) ? htmlspecialchars($career_suggestions[$category]['courses']) : 'No suggestions available' ?></p>
            <p><strong>Track:</strong> <?= isset($career_suggestions[$category]) ? htmlspecialchars($career_suggestions[$category]['track']) : 'No track available' ?></p>
            <p><strong>Clusters:</strong> <?= isset($career_suggestions[$category]) ? htmlspecialchars($career_suggestions[$category]['clusters']) : 'No clusters available' ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>