<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
	if(isset($_POST['add_staff']))
	{
	
	$fname=$_POST['firstname'];
	$mname=$_POST['middlename'];  
	$lname=$_POST['lastname'];   
	$email=$_POST['email']; 
	$password=md5($_POST['password']); 
	$gender=$_POST['gender']; 
	$dob=$_POST['dob']; 
	$department=$_POST['department']; 
	$address=$_POST['address']; 
	$leave_days=$_POST['leave_days']; 
	$user_role=$_POST['user_role']; 
	$phonenumber=$_POST['phonenumber']; 
	$sched_time_in=$_POST['sched_time_in']; 
	$sched_time_out=$_POST['sched_time_out']; 
	$status=0;


	


	 $query = mysqli_query($conn,"select * from hr_employees where email_id = '$email'")or die(mysqli_error());
	 $count = mysqli_num_rows($query);
     
     if ($count > 0){ ?>
	 <script>
	 alert('Data Already Exist');
	</script>
	<?php
      }else{
        mysqli_query($conn,"INSERT INTO hr_employees(first_name,middle_name,last_name,email_id,password,gender,dob,department,address,av_leave,role,phone_number,sched_time_in,sched_time_out,Status, location) VALUES('$fname','$mname','$lname','$email','$password','$gender','$dob','$department','$address','$leave_days','$user_role','$phonenumber','$sched_time_in','$sched_time_out','$status', 'NO-IMAGE-AVAILABLE.jpg')         
		") or die(mysqli_error()); ?>
		<script>alert('Staff Records Successfully  Added');</script>;
		<script>
		window.location = "staff.php"; 
		</script>
		<?php   }
}

?>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="../vendors/images/logo.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Staff Portal</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active" aria-current="page">Staff Module</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Staff Form</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<div class="wizard-content">
						<form method="post" action="">
							<section>
								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >First Name :</label>
											<input name="firstname" type="text" class="form-control wizard-required" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label >Middle Name :</label>
											<input name="middlename" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label>Last Name :</label>
											<input name="lastname" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
								<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Address :</label>
											<input name="address" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Password :</label>
											<input name="password" type="text" class="form-control" id="password" required="true" autocomplete="off" onclick="generatePassword()">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Email Address :</label>
											<input name="email" type="email" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Department :</label>
											<select name="department" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Department</option>
													<?php
													$query = mysqli_query($conn,"select * from hr_departments");
													while($row = mysqli_fetch_array($query)){
													
													?>
													<option value="<?php echo $row['department_short_name']; ?>"><?php echo $row['department_name']; ?></option>
													<?php } ?>
											</select>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Date Of Birth :</label>
											<input name="dob" type="text" class="form-control date-picker" required="true" autocomplete="off">
										</div>
									</div>
									
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Gender :</label>
											<select name="gender" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Gender</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Phone Number :</label>
											<input name="phonenumber" type="text" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Staff Leave Days :</label>
											<input name="leave_days" type="number" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Time - In :</label>
											<input name="sched_time_in" type="time" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>Time - Out :</label>
											<input name="sched_time_out" type="time" class="form-control" required="true" autocomplete="off">
										</div>
									</div>
								

									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label>User Role :</label>
											<select name="user_role" class="custom-select form-control" required="true" autocomplete="off">
												<option value="">Select Role</option>
												<option value="Admin">Admin</option>
												<option value="Employee">Employee</option>
											</select>
										</div>
									</div>

									<div class="col-md-3 col-sm-12">
										<div class="form-group">
											<label style="font-size:16px;"><b></b></label>
											<div class="modal-footer justify-content-center">
												<button class="btn btn-primary" name="add_staff" id="add_staff" data-toggle="modal">Add&nbsp;Staff</button>
											</div>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>

			</div>
			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<script>
function generatePassword() {
  // Function to generate random password
  function generateRandomPassword(length = 8) {
    const characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let password = '';
    const max = characters.length - 1;

    for (let i = 0; i < length; i++) {
      password += characters.charAt(Math.floor(Math.random() * max));
    }

    return password;
  }

  const passwordInput = document.getElementById('password');
  const generatedPassword = generateRandomPassword(10); // Change the length if needed

  passwordInput.value = generatedPassword;
}
</script>
	<?php include('includes/scripts.php')?>
</body>
</html>