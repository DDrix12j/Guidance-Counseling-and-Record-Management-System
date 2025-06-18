<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Fetch quiz results from the database
    $results = $conn->query("SELECT * FROM quiz_results")->fetchAll(PDO::FETCH_ASSOC);

 

    // Fetch career suggestions for each category
    $suggestions_stmt = $conn->query("SELECT cs.*, qc.name AS category_name 
                                      FROM career_suggestions cs 
                                      JOIN quiz_categories qc ON cs.category_id = qc.id");
    $career_suggestions = [];
    while ($row = $suggestions_stmt->fetch(PDO::FETCH_ASSOC)) {
        $career_suggestions[$row['category_name']] = [
            'jobs' => $row['jobs'] ?? 'No jobs available',
            'courses' => $row['courses'] ?? 'No courses available',
            'strand' => $row['strand'] ?? 'No strand available'
        ];
    }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h1>Quiz Results</h1>
        <hr>
        <h2>Results Overview</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Result ID</th>
                    <th>Category</th>
                    <th>Score</th>
                    <th>Top Recommendations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                <?php
                    // Decode the JSON-encoded results
                    $decoded_results = json_decode($result['results'], true);

                   

                    arsort($decoded_results); // Sort by score in descending order
                    $top_categories = array_slice($decoded_results, 0, 3, true);
                ?>
                <tr>
                    <td><?= $result['id'] ?></td>
                    <td>
                        <?php foreach ($decoded_results as $category => $score): ?>
                            <strong><?= htmlspecialchars($category) ?>:</strong> <?= $score ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td><?= array_sum($decoded_results) ?></td>
                    <td>
                        <?php foreach ($top_categories as $category => $score): ?>
                            <strong><?= htmlspecialchars($category) ?>:</strong><br>
                            Jobs: <?= isset($career_suggestions[$category]) ? $career_suggestions[$category]['jobs'] : 'No jobs available' ?><br>
                            Courses: <?= isset($career_suggestions[$category]) ? $career_suggestions[$category]['courses'] : 'No courses available' ?><br>
                            Strand: <?= isset($career_suggestions[$category]) ? $career_suggestions[$category]['strand'] : 'No strand available' ?><br><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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