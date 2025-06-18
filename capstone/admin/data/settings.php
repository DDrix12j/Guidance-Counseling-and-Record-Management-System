<?php
include "../../DB_connection.php";
include "../../data/settings.php";

function getSetting($conn, $key) {
    $stmt = $conn->prepare("SELECT setting_value FROM quiz_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    return $stmt->fetchColumn();
}

function updateSetting($conn, $key, $value) {
    $stmt = $conn->prepare("UPDATE quiz_settings SET setting_value = ? WHERE setting_key = ?");
    $stmt->execute([$value, $key]);
}

function addSetting($conn, $key, $value) {
    $stmt = $conn->prepare("INSERT INTO quiz_settings (setting_key, setting_value) VALUES (?, ?)");
    $stmt->execute([$key, $value]);
}

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
<h1>Quiz Settings</h1>
<form method="post">
    <label for="scoring_method">Scoring Method</label>
    <select id="scoring_method" name="scoring_method" required>
        <option value="sum" <?= $scoring_method === 'sum' ? 'selected' : '' ?>>Sum</option>
        <option value="average" <?= $scoring_method === 'average' ? 'selected' : '' ?>>Average</option>
    </select>
    <label for="language">Default Language</label>
    <select id="language" name="language" required>
        <option value="en" <?= $language === 'en' ? 'selected' : '' ?>>English</option>
        <option value="tl" <?= $language === 'tl' ? 'selected' : '' ?>>Tagalog</option>
    </select>
    <button type="submit">Save Settings</button>
</form>