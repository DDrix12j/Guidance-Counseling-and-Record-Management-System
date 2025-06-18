<?php
include "DB_connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $language = $_POST['language'];
    $results = [];
    $total_scores = [];

    // Fetch the scoring method from the database
    $scoring_method = $conn->query("SELECT setting_value FROM quiz_settings WHERE setting_key = 'scoring_method'")->fetchColumn();

    // Fetch all categories from the database
    $categories = $conn->query("SELECT * FROM quiz_categories WHERE language = '$language'")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch question weights (if scoring method is weighted)
    $weights = [];
    if ($scoring_method === 'weighted') {
        $weights_stmt = $conn->query("SELECT question_id, weight FROM question_weights");
        while ($row = $weights_stmt->fetch(PDO::FETCH_ASSOC)) {
            $weights[$row['question_id']] = $row['weight'];
        }
    }

    foreach ($categories as $category) {
        $category_id = $category['id'];

        // Check if answers for this category exist in the POST data
        if (isset($_POST["category_$category_id"])) {
            $scores = $_POST["category_$category_id"];
            $total_score = 0;

            foreach ($scores as $question_id => $score) {
                $weight = $weights[$question_id] ?? 1; // Default weight is 1
                $total_score += $score * $weight;
            }

            // Apply scoring method
            if ($scoring_method === 'average') {
                $total_score /= count($scores);
            }

            $results[$category['name']] = $total_score;
            $total_scores[$category['name']] = $total_score;
        } else {
            // Handle missing or incomplete answers
            $results[$category['name']] = 0;
            $total_scores[$category['name']] = 0;
        }
    }

    // Sort categories by score in descending order
    arsort($total_scores);
    $top_categories = array_slice($total_scores, 0, 3, true);

    // Fetch career suggestions dynamically
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

    // Store results in session
    $_SESSION['results'] = $results;
    $_SESSION['top_categories'] = $top_categories;
    $_SESSION['career_suggestions'] = $career_suggestions;

    // Redirect to the results page
    header("Location: career-results.php");
    exit;
}
?>