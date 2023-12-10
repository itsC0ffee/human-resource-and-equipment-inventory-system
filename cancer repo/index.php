

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Cancer Repo</title>

	<!-- Site favicon
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png"> -->

	<!-- Mobile Specific Metas -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/stylelogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">
                       
                <!-------------      image     ------------->

                <div class="logo">
                    <img src="vendors/images/login_logo_img.png" alt="">
                </div>
                
            </div>

            <div class="col-md-6 right">
                
                <div class="input-box">
                   
                   <header>Welcome Back!</header>
                   <p>Please enter your details</p>
				   <form name="signin" method="post">
                   <div class="input-field">
                        <input type="text" class="input" name="username" id="username" required="" autocomplete="off">
                        <label for="email"><i class="fa fa-envelope" aria-hidden="true"></i> Email</label> 
                    </div> 
                   <div class="input-field">
                        <input type="password" class="input" name="password" id="password" required="">
                        <label for="pass"><i class="fa fa-lock" aria-hidden="true"></i> Password</label>
                    </div> 
                    <div class="signin">
                        <span><a href="verification_form.php">Forgot Password?</a></span>
                       </div>
                   <div class="input-field">
                        
                        <input type="submit" name="signin" id="signin" class="submit" value="Log In">
                   </div> 
				</form>
                </div>  
            </div>
        </div>
    </div>
</div>




<?php
session_start();
include('includes/config.php');
if(isset($_POST['signin']))
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);

	$sql ="SELECT * FROM hr_employees where email_id ='$username' AND Password ='$password'";
	$query= mysqli_query($conn, $sql);
	$count = mysqli_num_rows($query);
	if($count > 0)
	{
		while ($row = mysqli_fetch_assoc($query)) {
		    if ($row['role'] == 'Admin') {
		    	$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
			 	echo "<script type='text/javascript'> document.location = 'admin/admin_dashboard.php'; </script>";
		    }
		    elseif ($row['role'] == 'Employee') {
		    	$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
			 	echo "<script type='text/javascript'> document.location = 'hr_employee/index.php'; </script>";
		    }
		    elseif ($row['role'] == 'HOD'){
		    	$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
			 	echo "<script type='text/javascript'> document.location = 'heads/index.php'; </script>";
		    }
			else {
				$_SESSION['alogin']=$row['emp_id'];
		    	$_SESSION['arole']=$row['Department'];
			 	echo "<script type='text/javascript'> document.location = 'inventory_admin/index.php'; </script>";
			}
		}

	} 
	else{
		echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
		echo "<script>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Email or Password Incorrect!',
			showConfirmButton: true
		});
	</script>";

	}

}
// $_SESSION['alogin']=$_POST['username'];
// 	echo "<script type='text/javascript'> document.location = 'changepassword.php'; </script>";
?>











	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>