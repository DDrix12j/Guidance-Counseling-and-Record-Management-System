<?php
session_start();
require_once '../DB_connection.php';

if (isset($_POST['credential'])) {
    $client = new Google_Client(['client_id' => '440773337575-p06g9k7a13l7i46g4egklk1qo4fu3skf.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($_POST['credential']);
    if ($payload) {
        $userid = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'];

        // Check if user exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
        } else {
            // Register new user
            $stmt = $conn->prepare("INSERT INTO users (email, name, role) VALUES (?, ?, 'User')");
            $stmt->execute([$email, $name]);
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['role'] = 'User';
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../login.php?error=Invalid Google Sign-In");
    }
} else {
    header("Location: ../login.php");
}
?>