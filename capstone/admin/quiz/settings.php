<?php
include "../../DB_connection.php";
include "../../data/settings.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scoring_method = $_POST['scoring_method'];
    $language = $_POST['language'];

    updateSetting($conn, 'scoring_method', $scoring_method);
    updateSetting($conn, 'default_language', $language);

    header("Location: settings.php?success=Settings updated successfully");
    exit;
}

$scoring_method = getSetting($conn, 'scoring_method');
$language = getSetting($conn, 'default_language');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Quiz Settings</h1>
        <form method="post">
            <div class="mb-3">
                <label for="scoring_method" class="form-label">Scoring Method</label>
                <select id="scoring_method" name="scoring_method" class="form-control" required>
                    <option value="sum" <?= $scoring_method === 'sum' ? 'selected' : '' ?>>Sum</option>
                    <option value="average" <?= $scoring_method === 'average' ? 'selected' : '' ?>>Average</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="language" class="form-label">Default Language</label>
                <select id="language" name="language" class="form-control" required>
                    <option value="en" <?= $language === 'en' ? 'selected' : '' ?>>English</option>
                    <option value="tl" <?= $language === 'tl' ? 'selected' : '' ?>>Tagalog</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</body>
</html>