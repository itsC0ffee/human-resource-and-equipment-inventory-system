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
    $emp_id=$session_id;
    $lid = isset($_POST['lid']) ? $_POST['lid'] : '';
    $recipientEmail = isset($_POST['EmailId']) ? $_POST['EmailId'] : '';
    $newPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $date = date("Y-m-d");
    $activity = $name." "."password changed";   


    $md5password=md5($newPassword); 
  





    // Replace these with your database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "doh";

    try {
        // Create a PDO connection
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start a transaction
    $conn->beginTransaction();

    // Update tblemployees password
    $updatePasswordQuery = "UPDATE hr_employees SET Password = :newPassword WHERE email_id = :recipientEmail";
    $queryPassword = $conn->prepare($updatePasswordQuery);
    $queryPassword->bindParam(':newPassword', $md5password);
    $queryPassword->bindParam(':recipientEmail', $recipientEmail);
    $queryPassword->execute();

    // Update tblpassrequest status
    $isread = 1; // Set your value here 
    $updateTblpassrequest = "UPDATE hr_password_request SET status = :isread WHERE id = :lid";
    $queryStatus = $conn->prepare($updateTblpassrequest);
    $queryStatus->bindParam(':isread', $isread, PDO::PARAM_INT);
    $queryStatus->bindParam(':lid', $lid);
    $queryStatus->execute();

    // Fetch FirstName from Employees table based on id


    $fetchFirstNameQuery = "SELECT first_name FROM hr_employees WHERE emp_id = ?";
    $stmt = $conn->prepare($fetchFirstNameQuery);
    $stmt->bindParam(1, $emp_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $firstName = $result['first_name'];

    // Insert into tbllogs
    $insertTbllogs = "INSERT INTO hr_logs (emp_id, name, date, activity) VALUES (:emp_id, :name, :date, :activity)";
    $queryLogs = $conn->prepare($insertTbllogs);
    // Bind your values here
    $queryLogs->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
    $queryLogs->bindParam(':name', $firstName, PDO::PARAM_STR);
    // Adjust date and activity as needed
    $date = date("Y-m-d H:i:s");
    $queryLogs->bindParam(':date', $date, PDO::PARAM_STR);
    $queryLogs->bindParam(':activity', $activity, PDO::PARAM_STR);
    // Execute the insert query
    $queryLogs->execute();

        // Commit the transaction
        $conn->commit();

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







    } catch (PDOException $e) {
        // Roll back the transaction if anything fails
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
}


































