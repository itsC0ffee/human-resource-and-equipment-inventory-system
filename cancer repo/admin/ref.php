<!DOCTYPE html>
<html>
<head>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="vendors/styles/stylelogin.css">
</head>
<body>
    <!-- Rest of your HTML content -->
</body>
</html>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'vendor/autoload.php';
session_start();
// Start the session to access the $_SESSION variables


// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientEmail = $_POST['email'];
    $password = $_POST['password'];

    // Replace these with your database connection details
   

    // Create connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $checkEmailQuery = "Update Password FROM tblemployees WHERE EmailId = '$recipientEmail'";
    $result = $conn->query($checkEmailQuery);


    if ($result->num_rows > 0) {
      
  

        // Replace these with your SMTP configuration
        $smtpHost = 'smtp.gmail.com';
        $smtpUsername = 'cancerrepo@gmail.com';
        $smtpPassword = 'tktt olvy wqpt cagv';
        $smtpPort = 587; // Adjust the port if needed
        $smtpEncryption = 'tls'; // Or 'ssl' if applicable

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtpUsername;
            $mail->Password   = $smtpPassword;
            $mail->SMTPSecure = $smtpEncryption;
            $mail->Port       = $smtpPort;

            // Recipient
            $mail->setFrom('cancerrepo@gmail.com', 'Cancer Repo');
            $mail->addAddress($recipientEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is: ' . $verificationCode;

            // Send the email
            $mail->send();
            echo 'Verification code sent successfully.';
            
            // Assuming the email is obtained through a form submission
            $recipientEmail = filter_var($recipientEmail, FILTER_SANITIZE_EMAIL); // Sanitize the email
            header("Location: verify_code_form.php?data=$recipientEmail");
            exit();


        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        // Email doesn't exist in the database, show an error message or redirect back to the form
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Email Not Found",
            text: "The provided email does not exist. Please try again.",
            showConfirmButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "verification_form.php";
            }
        });
    </script>';
    }

    $conn->close();
}
?>
