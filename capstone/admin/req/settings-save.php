<?php
include "../../DB_connection.php";
include "../../data/settings.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        updateSetting($conn, $key, $value);
    }
    header("Location: ../settings.php?success=Settings saved successfully");
    exit;
}
?>