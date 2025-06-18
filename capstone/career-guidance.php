<?php
include "DB_connection.php";
include "data/setting.php";
$setting = getSetting($conn);
session_start();

if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
    header("Location: career-guidance.php");
    exit;
}

$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';

$categories = $conn->prepare("SELECT * FROM quiz_categories WHERE language = ?");
$categories->execute([$language]);
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="tntsannexicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }


        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .progress {
            height: 20px;
        }

        .btn-group-toggle .btn {
            margin-right: 5px;
        }

        .navbar-nav .nav-link {
            color: <?= $setting['secondary_color'] ?> !important;
            font-family: 'Montserrat', sans-serif;
        }

        .about-bar {
            position: relative;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 4rem;
            color: white;
            background: url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center;
            background-size: cover;
            padding: 40px;
            border-radius: 10px;
            width: 98%;
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
        }

        .about-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        .about-bar h2 {
            position: relative;
            z-index: 1;
            letter-spacing: 1px;
            font-size: 3rem;
        }

        .quiz-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-height: 600px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #007bff #f1f1f1;
        }

        .quiz-container::-webkit-scrollbar {
            width: 8px;
        }

        .quiz-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .quiz-container::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }

        .quiz-title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
<?php include "inc/navbar.php"; ?>

<div class="about-bar">
    <h2><span>Career Guidance</span></h2>
</div>

<div class="container mt-5 mb-5">
    <div class="quiz-container">
        <h2 class="quiz-title">Career Assessment</h2>
        <form method="post" action="career-guidance.php">
            <div class="mb-3">
                <label for="language" class="form-label">Select Language</label>
                <select class="form-control" id="language" name="language" onchange="this.form.submit()">
                    <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
                    <option value="tl" <?= $language == 'tl' ? 'selected' : '' ?>>Tagalog/Filipino</option>
                </select>
            </div>
        </form>

        <form id="quizForm" method="post" action="process-quiz.php">
            <input type="hidden" name="language" value="<?= $language ?>">
            <div class="progress mb-3">
                <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
            </div>

            <div class="step active">
                <h4>Introduction</h4>
                <p>Welcome to the Career Guidance Assessment! This Assessment is designed to help you discover your strengths and preferences, and suggest potential career paths that align with your interests. Please answer each question honestly to get the most accurate results.</p>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Start Assessment</button>
            </div>

            <?php $step = 0;
            foreach ($categories as $category):
                $step++;
                $questions = $conn->prepare("SELECT * FROM questions WHERE category_id = ?");
                $questions->execute([$category['id']]);
                $questions = $questions->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="step">
                    <h4><?= $category['name'] ?></h4>
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="mb-3">
                            <label class="form-label"><?= $question['question_text'] ?></label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php
                                $default_answers = [
                                    1 => 'Strongly Disagree',
                                    2 => 'Disagree',
                                    3 => 'Neutral',
                                    4 => 'Agree',
                                    5 => 'Strongly Agree'
                                ];
                                foreach ($default_answers as $value => $label): ?>
                                    <label class="btn btn-outline-primary">
                                        <input type="radio" name="category_<?= $category['id'] ?>[<?= $question['id'] ?>]" value="<?= $value ?>" required> <?= $label ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                <button type="submit" class="btn btn-success" style="display: none;">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const prevButton = document.querySelector('.btn-secondary');
    const nextButton = document.querySelector('.btn-primary');
    const submitButton = document.querySelector('.btn-success');
    const progressBar = document.getElementById('progressBar');

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.classList.toggle('active', index === step);
        });

        prevButton.style.display = step === 0 ? 'none' : 'inline-block';
        nextButton.style.display = step === steps.length - 1 ? 'none' : 'inline-block';
        submitButton.style.display = step === steps.length - 1 ? 'inline-block' : 'none';

        progressBar.style.width = ((step + 1) / steps.length) * 100 + '%';

        const activeStep = document.querySelector('.step.active');
        window.scrollTo({
            top: activeStep.offsetTop - 20,
            behavior: 'smooth'
        });
    }

    function nextStep() {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }

    showStep(currentStep);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
