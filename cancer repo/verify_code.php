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
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code1 = trim($_POST['code1']);
    $code2 = trim($_POST['code2']);
    $code3 = trim($_POST['code3']);
    $code4 = trim($_POST['code4']);
    $code5 = trim($_POST['code5']);
    $email = $_POST['recipientEmail'];
    
    $currentDate = date("Y-m-d");
    

    $enteredCode = $code1 . $code2 . $code3 . $code4 . $code5;
    $expectedCode = $_SESSION['verification_code'];

    if ((string)$enteredCode === (string)$expectedCode) {
        // Replace with your database logic
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "doh";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO hr_password_request (email_id, date_req, status) VALUES ('$email', '$currentDate', '0')";

        if ($conn->query($sql) === TRUE) {
            // Success message or further actions
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "You\'ve just submitted a password change request.",
            text: "Be patient while we dispatch the recovery email to your provided email address.",
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            window.location.href = "index.php";
        });
    </script>';


    } else {
        echo '<script>Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Verification Code Does Not Match!",
            showConfirmButton: true
          });;</script>';
        include('verify_code_form.php'); // Include the form again
        exit();
    }
}
?>
