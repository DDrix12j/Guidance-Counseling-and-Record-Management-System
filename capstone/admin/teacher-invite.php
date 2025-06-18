<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../vendor/autoload.php';

session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $position = trim($_POST['position']);

        if (empty($email) || empty($position)) {
            $message = "Both email and position are required.";
        } else {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 day'));

            // Store the invite in a new table (create this table in your DB)
            $stmt = $conn->prepare("INSERT INTO teacher_invites (email, position, token, expires_at) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, $position, $token, $expires]);

            // Prepare signup link
            $signup_link = "http://localhost/capstone_ralph/capstone/admin/teacher-signup.php?token=$token";

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth   = true;
                $mail->Username   = '45206a70c3f8aa';
                $mail->Password   = 'a97aac911a40ec';
                $mail->Port       = 2525;
                $mail->setFrom('no-reply@yourdomain.com', 'Admin');
                $mail->addAddress($email);
                $mail->isHTML(false);
                $mail->Subject = "Teacher Signup Invitation";
                $mail->Body    = "You have been invited to sign up as a teacher. Click the link below to complete your registration:\n\n$signup_link\n\nThis link will expire in 24 hours.";

                $mail->send();
                $message = "Signup link sent to $email";
            } catch (Exception $e) {
                $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invite Teacher</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="icon" href="../logo.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <style>
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
            <h3>Invite Teacher</h3>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="post" class="shadow p-3 mt-3 form-w">
                <div class="mb-3">
                    <label class="form-label">Teacher Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Position</label>
                    <input type="text" class="form-control" name="position" required>
                </div>
                <button type="submit" class="btn btn-primary">Send Invite</button>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: ../login.php");
    exit;
}
?>