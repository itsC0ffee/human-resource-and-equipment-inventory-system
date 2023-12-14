<?php include('../includes/session.php')?>

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
require '../vendor/autoload.php';

// Start the session to access the $_SESSION variables


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $session_id;
    $lid = isset($_POST['lid']) ? $_POST['lid'] : '';
    $recipientEmail = isset($_POST['EmailId']) ? $_POST['EmailId'] : '';
    $newPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $date = date("Y-m-d");
    $activity = $name . " " . "password changed";

    $md5password = md5($newPassword);

    // Replace these with your database connection details
    $host = "pgsql:host=db.tcfwwoixwmnbwfnzchbn.supabase.co;port=5432;dbname=postgres;user=postgres;password=sbit4e-4thyear-capstone-2023";

    try {
        // Create a PDO connection
        $dbh = new PDO($host);

        $dbh->beginTransaction();

        // Update hr_employees table with the new password
        $updatePasswordQuery = "UPDATE hr_employees SET password = :newPassword WHERE email_id = :recipientEmail";
        $queryPassword = $dbh->prepare($updatePasswordQuery);
        $queryPassword->bindParam(':newPassword', $md5password);
        $queryPassword->bindParam(':recipientEmail', $recipientEmail);
        $queryPassword->execute();

        // Update hr_password_request status
        $isread = 1; // Set your value here 
        $updateTblpassrequest = "UPDATE hr_password_request SET status = :isread WHERE id = :lid";
        $queryStatus = $dbh->prepare($updateTblpassrequest);
        $queryStatus->bindParam(':isread', $isread, PDO::PARAM_INT);
        $queryStatus->bindParam(':lid', $lid);
        $queryStatus->execute();

        // Fetch FirstName from hr_employees table based on emp_id
        $fetchFirstNameQuery = "SELECT first_name FROM hr_employees WHERE emp_id = :emp_id";
        $stmt = $dbh->prepare($fetchFirstNameQuery);
        $stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $firstName = $result['first_name'];

        // Insert into hr_logs table
        $insertTbllogs = "INSERT INTO hr_logs (emp_id, name, date, activity) VALUES (:emp_id, :name, :date, :activity)";
        $queryLogs = $dbh->prepare($insertTbllogs);
        $queryLogs->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
        $queryLogs->bindParam(':name', $firstName, PDO::PARAM_STR);
        $queryLogs->bindParam(':date', $date, PDO::PARAM_STR);
        $queryLogs->bindParam(':activity', $activity, PDO::PARAM_STR);
        $queryLogs->execute();

        // Commit the transaction
        $dbh->commit();

        // Rest of your email sending logic here
       
        $smtpHost = 'smtp.gmail.com';
        $smtpUsername = 'cancerrepo@gmail.com';
        $smtpPassword = 'tktt olvy wqpt cagv';
        $smtpPort = 587; // Adjust the port if needed
        $smtpEncryption = 'tls'; // Or 'ssl' if applicable
    
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
    
        try {
            // Your email sending logic here
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
            
            // Set up SMTP configuration and other necessary attributes
    
            // Content for the email
            $mail->isHTML(true);
            $mail->Subject = 'Password Update Notification';
            $mail->Body = 'Your password has been successfully updated.<br>Your new password is: ' . $newPassword;

            // Send the email
            $mail->send();
    
            // Echo success message and redirect
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Password updated successfully.",
                    text: "A New Password has been sent to the employee\'s email.",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "password_request.php";
                });
            </script>';
    
            // Redirect or perform any other actions as needed
    
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }


        // Create a new PHPMailer instance and continue with the email sending logic
        
    } catch (PDOException $e) {
        // Roll back the transaction if an error occurs
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }

    // Close the connection (Note: For PDO, connections are closed automatically)
}