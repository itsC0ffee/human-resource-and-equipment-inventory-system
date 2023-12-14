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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientEmail = $_POST['email'];
    $smtpHost = 'smtp.gmail.com';
    $smtpUsername = 'cancerrepo@gmail.com';
    $smtpPassword = 'tktt olvy wqpt cagv';
    $smtpPort = 587; // Adjust the port if needed
    $smtpEncryption = 'tls'; // Or 'ssl' if applicable

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    $host = "pgsql:host=db.tcfwwoixwmnbwfnzchbn.supabase.co;port=5432;dbname=postgres;user=postgres;password=sbit4e-4thyear-capstone-2023";

    try {
       
        $dbh = new PDO($host);

        $checkEmailQuery = "SELECT * FROM hr_employees WHERE email_id = :recipientEmail";
        $stmt = $dbh->prepare($checkEmailQuery);
        $stmt->bindParam(':recipientEmail', $recipientEmail);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $verificationCode = mt_rand(10000, 99999);
            $_SESSION['verification_code'] = $verificationCode;
           
           // Server settings
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUsername;
            $mail->Password = $smtpPassword;
            $mail->SMTPSecure = $smtpEncryption;
            $mail->Port = $smtpPort;

            // Recipient
            $mail->setFrom('cancerrepo@gmail.com', 'Cancer Repo');
            $mail->addAddress($recipientEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body = 'Your verification code is: ' . $verificationCode;

            // Send the email
            $mail->send();
            echo 'Verification code sent successfully.';

            // Redirect to the verification code form
            $recipientEmail = filter_var($recipientEmail, FILTER_SANITIZE_EMAIL); // Sanitize the email
            header("Location: verify_code_form.php?data=$recipientEmail");
            exit();
        } else {
            // Email doesn't exist in the database
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
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>