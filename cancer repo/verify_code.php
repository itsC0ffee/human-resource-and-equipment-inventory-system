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
        try {
            $host = "host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres user=postgres password=sbit4e-4thyear-capstone-2023";
            $dbh = new PDO("pgsql:$host");

            $sql = "INSERT INTO hr_password_request (email_id, date_req, status) VALUES (:email, :currentDate, '0')";
            $query = $dbh->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $query->execute();

            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Request Submitted",
                    text: "We are processing your request.",
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = "index.php";
                });
            </script>';
        } catch (PDOException $e) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while processing your request.",
                    showConfirmButton: true
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Verification Code Does Not Match!",
                showConfirmButton: true
            });
        </script>';
        include('verify_code_form.php'); // Include the form again
        exit();
    }
}
?>