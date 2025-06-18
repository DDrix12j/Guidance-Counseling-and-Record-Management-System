<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";

        // Fetch statistics for counseling and messages
        function getCounselingStats($conn, $interval) {
            $sql = "SELECT COUNT(*) as count FROM counseling_records WHERE DATE(schedule) >= DATE_SUB(CURDATE(), INTERVAL $interval)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        function getMessageStats($conn, $interval) {
            $sql = "SELECT COUNT(*) as count FROM message WHERE DATE(date_time) >= DATE_SUB(CURDATE(), INTERVAL $interval)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        function getNewMessagesCount($conn) {
            $sql = "SELECT COUNT(*) as count FROM message WHERE is_new = 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        // Fetch additional statistics
        function getStudentCount($conn) {
            $sql = "SELECT COUNT(*) as count FROM students";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        function getNewsCount($conn) {
            $sql = "SELECT COUNT(*) as count FROM news";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        function getWebsiteVisits($conn) {
            $sql = "SELECT COUNT(*) as count FROM website_visits";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        }

        $counselingWeek = getCounselingStats($conn, '1 WEEK');
        $counselingMonth = getCounselingStats($conn, '1 MONTH');
        $counselingYear = getCounselingStats($conn, '1 YEAR');

        $messagesWeek = getMessageStats($conn, '1 WEEK');
        $messagesMonth = getMessageStats($conn, '1 MONTH');
        $messagesYear = getMessageStats($conn, '1 YEAR');

        $newMessagesCount = getNewMessagesCount($conn); // Fetch new messages count
        $studentCount = getStudentCount($conn);
        $newsCount = getNewsCount($conn);
        $websiteVisits = getWebsiteVisits($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="tntsannexicon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            margin-top: 30px;
        }
        .new-messages-tab {
            background-color: <?= $newMessagesCount > 0 ? '#ff4d4d' : '#ffffff' ?>; /* Red if new messages exist */
            color: <?= $newMessagesCount > 0 ? '#ffffff' : '#000000' ?>;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container dashboard-container">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h5>Counseling Statistics</h5>
                    <canvas id="counselingChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h5>Request and Support Statistics</h5>
                    <canvas id="messageChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center p-4 new-messages-tab">
                    <h5>New Messages</h5>
                    <a href="message.php" class="text-decoration-none">
                        <p class="fs-1 text-primary"><?= $newMessagesCount ?></p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Counseling This Week</h5>
                    <a href="counseling.php" class="text-decoration-none">
                        <p class="fs-1 text-success"><?= $counselingWeek ?></p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Total Messages</h5>
                    <a href="message.php" class="text-decoration-none">
                        <p class="fs-1 text-danger"><?= $messagesYear ?></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Total Students</h5>
                    <a href="student.php" class="text-decoration-none">
                        <p class="fs-1 text-info"><?= $studentCount ?></p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Total News Articles</h5>
                    <a href="news.php" class="text-decoration-none">
                        <p class="fs-1 text-warning"><?= $newsCount ?></p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5>Website Visits</h5>
                    <a href="index.php" class="text-decoration-none">
                        <p class="fs-1 text-secondary"><?= $websiteVisits ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const counselingData = {
            labels: ['This Week', 'This Month', 'This Year'],
            datasets: [{
                label: 'Counseling Records',
                data: [<?= $counselingWeek ?>, <?= $counselingMonth ?>, <?= $counselingYear ?>],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        };

        const messageData = {
            labels: ['This Week', 'This Month', 'This Year'],
            datasets: [{
                label: 'Messages',
                data: [<?= $messagesWeek ?>, <?= $messagesMonth ?>, <?= $messagesYear ?>],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        };

        const configCounseling = {
            type: 'bar',
            data: counselingData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        };

        const configMessages = {
            type: 'bar',
            data: messageData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        };

        new Chart(document.getElementById('counselingChart'), configCounseling);
        new Chart(document.getElementById('messageChart'), configMessages);
    </script>
</body>
</html>
<?php 
  } else {
    header("Location: ../login.php");
    exit;
  } 
} else {
    header("Location: ../login.php");
    exit;
} 
?>