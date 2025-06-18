<?php 
include "DB_connection.php";
include "data/setting.php";
include "data/about.php";
$setting = getSetting($conn);
$boxes = getAllAboutBoxes($conn);


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_request'])) {
    $lrn = $_POST['lrn'];
    $email = $_POST['email'];
    $type_of_request = $_POST['type_of_request'];
    $message = $_POST['message'];
    $tracking_number = uniqid('REQ-'); // Generate a unique tracking number

    if (!empty($lrn) && !empty($email) && !empty($type_of_request) && !empty($message)) {
        // Validate LRN format
        if (!preg_match('/^\d{12}$/', $lrn)) {
            $error_message = "LRN must be a 12-digit number.";
        } else {
            // SQL insertion logic
            $sql = "INSERT INTO message (sender_full_name, sender_email, type_of_request, message, tracking_number) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$lrn, $email, $type_of_request, $message, $tracking_number])) {
                $success_message = "Request submitted successfully! <strong>Your tracking number is: $tracking_number</strong>. Please write it down or save it somewhere safe. You will need it to track the status of your request.";
            } else {
                $error_message = "An error occurred while submitting your request. Please try again.";
            }
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request and Support</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="tntsannexicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-size: cover;
            background-color: <?=$setting['background_color']?>;
            font-family: 'Poppins', sans-serif;
        }

        .body-home {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .scrollable-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .about-bar {
            position: relative;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            color: white;
            background: url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center;
            background-size: cover;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
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

        .about-content {
            text-align: left;
            color: black;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: normal;
        }

        .about-content p {
            margin: 0 0 10px 0;
            font-size: 1rem;
        }

        .about-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .about-content ul li {
            margin-bottom: 10px;
        }

        .about-content a {
            color: #ff0000;
            text-decoration: none;
            background-color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            border: 2px solid #ff0000;
            font-weight: normal;
        }

        .about-content a:hover {
            background-color: #ff0000;
            color: white;
        }

        .black-fill {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .btn-current-page {
            background-color: #ff0000;
            color: white;
            font-weight: normal;
        }

        .btn-current-page:hover {
            background-color: #ff0000;
            color: white;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    </style>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    
    <div class="scrollable-content">
        <div class="about-bar">
            <h2>
                <span>Request and Support</span>
            </h2>
        </div>
        <div class="d-flex justify-content-start mb-3" style="margin-left: 1%;">
            <a href="index.php" class="btn btn-light mx-2 text-danger">Home</a>
            <a href="contact.php" class="btn btn-light mx-2 text-danger" id="contactBtn">Contact</a>
            <a href="services.php" class="btn btn-light mx-2 text-danger">Guidance</a>
            <a href="services.php" class="btn btn-light mx-2 text-danger">Career Guidance</a>
            <a href="request-support.php" class="btn btn-light mx-2 btn-current-page">Request & Support</a>
        </div>
        <div class="black-fill">
    <div class="container mt-5">
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success">
                <?= $success_message ?>
            </div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php } ?>
        <div class="about-content">
            <p>The Guidance Office at Tanza National Trade School Annex provides essential services to assist students with their academic and personal needs. These services ensure a smooth and organized process for requesting important documents and addressing concerns.</p>
            <ul>
                <li><strong>Request for Clearance</strong> – Secure a school clearance for academic or extracurricular purposes.</li>
                <li><strong>Request for Temporary Card</strong> – Get a temporary school ID or card in case of loss or pending issuance of the original.</li>
                <li><strong>Request for Good Moral Certificate</strong> – Obtain a certification proving good conduct and behavior, often required for transfers or applications.</li>
                <li><strong>Request for Certificate</strong> – Request official school certificates needed for various purposes, such as competitions, scholarships, or enrollment.</li>
                <li><strong>Send Concern</strong> – Report issues related to academics, behavior, bullying, or personal matters that need the school's attention.</li>
            </ul>
            <p><strong>How the system works:</strong></p>
            <ol>
                <li>Click the <strong>"Request Now"</strong> button and fill out the form with the required details.</li>
                <li>Submit the form to generate a unique tracking number. <strong>Make sure to write down or save the tracking number.</strong></li>
                <li>Once the admin processes your request, you can click the <strong>"Track Request"</strong> button, enter your tracking number, and view the status of your request.</li>
            </ol>
            <p>The Guidance Office is always ready to assist. Simply submit your request, and we will process it as soon as possible!</p>
            <a href="#" class="btn btn-light text-danger" id="requestNowBtn">Request Now</a>
            <a href="#" class="btn btn-light text-danger" id="trackRequestBtn">Track Request</a>
        </div>
    </div>
</div>

    <!-- Request Form Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="contactModalLabel">Request Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="mb-3 position-relative">
                <label for="lrn" class="form-label">
                    LRN
                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="right" title="The LRN must be a 12-digit number. Example: 123456789012">
                        <i class="fa fa-exclamation-circle"></i>
                    </button>
                </label>
                <input type="text" class="form-control" id="lrn" name="lrn" placeholder="Enter your 12-digit LRN" required>
              </div>
              <div class="mb-3 position-relative">
                <label for="email" class="form-label">
                    Email
                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Enter a valid email address. Example: user@example.com">
                        <i class="fa fa-exclamation-circle"></i>
                    </button>
                </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
              </div>
              <div class="mb-3">
                <label for="typeOfRequest" class="form-label">Type of Request</label>
                <select class="form-select" id="typeOfRequest" name="type_of_request" required>
                  <option value="Request Clearance Form">Request Clearance Form</option>
                  <option value="Request Temporary Card">Request Temporary Card</option>
                  <option value="Request Good Moral">Request Good Moral</option>
                  <option value="Request for Certificate">Request for Certificate</option>
                  <option value="Send Concern">Send Concern</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
              </div>
              <button type="submit" name="submit_request" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Track Request Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="trackModalLabel">Track Your Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="trackRequestForm">
              <div class="mb-3">
                <label for="trackingNumber" class="form-label">Tracking Number</label>
                <input type="text" class="form-control" id="trackingNumber" name="tracking_number" required>
              </div>
              <button type="submit" class="btn btn-secondary">Track</button>
            </form>
            <div id="trackResult" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('requestNowBtn').addEventListener('click', function(event) {
            event.preventDefault();
            var contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
            contactModal.show();
        });

        document.getElementById('trackRequestBtn').addEventListener('click', function(event) {
            event.preventDefault();
            var trackModal = new bootstrap.Modal(document.getElementById('trackModal'));
            trackModal.show();
        });

        // Handle the form submission with AJAX
        document.getElementById('trackRequestForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var trackingNumber = document.getElementById('trackingNumber').value;

            // Send AJAX request to track-request.php
            fetch('track-request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ tracking_number: trackingNumber }),
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('trackResult').innerHTML = data; // Display the response in the modal
            })
            .catch(error => {
                document.getElementById('trackResult').innerHTML = '<p class="text-danger">An error occurred. Please try again.</p>';
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>