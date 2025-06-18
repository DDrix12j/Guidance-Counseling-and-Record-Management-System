<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

        if (isset($_POST['school_name']) &&
            isset($_POST['slogan']) &&
            isset($_POST['primary_color']) &&
            isset($_POST['secondary_color']) &&
            isset($_POST['background_color']) &&
            isset($_POST['news_section_color']) &&
            isset($_POST['news_section_font_color'])) {
            
            require_once '../../DB_connection.php';
            require_once '../data/setting.php'; // Include the file where getSetting is defined

            $school_name = $_POST['school_name'];
            $slogan = $_POST['slogan'];
            $primary_color = $_POST['primary_color'];
            $secondary_color = $_POST['secondary_color'];
            $background_color = $_POST['background_color'];
            $news_section_color = $_POST['news_section_color'];
            $news_section_font_color = $_POST['news_section_font_color'];

            // Optional fields (set default values if not provided)
            $about = $_POST['about'] ?? '';
            $current_year = $_POST['current_year'] ?? '';
            $current_semester = $_POST['current_semester'] ?? '';
            $school_address = $_POST['school_address'] ?? '';
            $contact_details = $_POST['contact_details'] ?? '';
            $welcome_message = $_POST['welcome_message'] ?? '';
            $font_style = $_POST['font_style'] ?? '';
            $services_description = $_POST['services_description'] ?? '';

            // Fetch existing settings
            $setting = getSetting($conn);

            $school_logo = $setting['school_logo']; // Default to existing logo
            if (isset($_FILES['school_logo']) && $_FILES['school_logo']['error'] == 0) {
                $target_dir = "../../img/";
                $target_file = $target_dir . basename($_FILES["school_logo"]["name"]);
                if (move_uploaded_file($_FILES["school_logo"]["tmp_name"], $target_file)) {
                    $school_logo = basename($_FILES["school_logo"]["name"]);
                }
            }

            // Update the settings in the database
            $sql = "UPDATE setting SET 
                    school_name = :school_name,
                    slogan = :slogan,
                    about = :about,
                    current_year = :current_year,
                    current_semester = :current_semester,
                    school_address = :school_address,
                    contact_details = :contact_details,
                    welcome_message = :welcome_message,
                    primary_color = :primary_color,
                    secondary_color = :secondary_color,
                    background_color = :background_color,
                    font_style = :font_style,
                    services_description = :services_description,
                    school_logo = :school_logo,
                    news_section_color = :news_section_color,
                    news_section_font_color = :news_section_font_color
                    WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':school_name', $school_name);
            $stmt->bindParam(':slogan', $slogan);
            $stmt->bindParam(':about', $about);
            $stmt->bindParam(':current_year', $current_year);
            $stmt->bindParam(':current_semester', $current_semester);
            $stmt->bindParam(':school_address', $school_address);
            $stmt->bindParam(':contact_details', $contact_details);
            $stmt->bindParam(':welcome_message', $welcome_message);
            $stmt->bindParam(':primary_color', $primary_color);
            $stmt->bindParam(':secondary_color', $secondary_color);
            $stmt->bindParam(':background_color', $background_color);
            $stmt->bindParam(':font_style', $font_style);
            $stmt->bindParam(':services_description', $services_description);
            $stmt->bindParam(':school_logo', $school_logo);
            $stmt->bindParam(':news_section_color', $news_section_color);
            $stmt->bindParam(':news_section_font_color', $news_section_font_color);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $sm = "Settings updated successfully";
                header("Location: ../settings.php?success=$sm");
                exit;
            } else {
                $em = "No changes were made";
                header("Location: ../settings.php?error=$em");
                exit;
            }
        } else {
            $em = "Required fields are missing";
            header("Location: ../settings.php?error=$em");
            exit;
        }
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>