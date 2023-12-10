
<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>



<style>
	input[type="text"]
	{
	    font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	.btn-outline:hover {
	  color: #fff;
	  background-color: #524d7d;
	  border-color: #524d7d; 
	}

	textarea { 
		font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
	}

	textarea.text_area{
        height: 8em;
        font-size:16px;
	    color: #0f0d1b;
	    font-family: Verdana, Helvetica;
      }

	</style>

<body>
	

	<?php include('includes/navbar.php')?>

	<?php include('includes/right_sidebar.php')?>

	<?php include('includes/left_sidebar.php')?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>PASSWORD REQUEST DETAILS</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Request Password</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Request Details</h4>
							<p class="mb-20"></p>
						</div>
					</div>
					<form method="post" action="send_password_email.php">

						<?php 
						if(!isset($_GET['passwordid']) && empty($_GET['passwordid'])){
							header('Location: admin_dashboard.php');
						}
						else {
						
						$lid=intval($_GET['passwordid']);
						$sql = "SELECT hr_password_request.id AS lid, hr_employees.first_name, hr_employees.last_name, hr_employees.emp_id,hr_employees.phone_number,hr_employees.department, hr_employees.email_id, hr_password_request.date_req, hr_password_request.status FROM hr_password_request JOIN hr_employees ON hr_password_request.email_id = hr_employees.email_id WHERE hr_password_request.id = :lid";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':lid',$lid,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $result)
						{         
						?>  

						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Full Name</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->first_name." ".$result->last_name);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Email Address</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-info" readonly value="<?php echo htmlentities($result->email_id);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Employee ID</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->emp_id);?>">
								</div>
							</div>
						</div>
						<div class="row">
						<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Department</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->department);?>">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Phone Number</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo htmlentities($result->phone_number);?>">
								</div>
							</div>
							
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label style="font-size:16px;"><b>Applied Date</b></label>
									<input type="text" class="selectpicker form-control" data-style="btn-outline-success" readonly value="<?php echo htmlentities($result->date_req);?>">
								</div>
							</div>
						</div>
						
						
						<div class="row">
		
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size:16px;"><b>Request Status</b></label>
									<?php $stats=$result->status;?>
									<?php
									if ($stats==1): ?>
									  <input type="text" style="color: green;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Approved"; ?>">
									<?php
									 elseif ($stats==2): ?>
									  <input type="text" style="color: red; font-size: 16px;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Rejected"; ?>">
									  <?php
									else: ?>
									  <input type="text" style="color: blue;" class="selectpicker form-control" data-style="btn-outline-primary" readonly value="<?php echo "Pending"; ?>">
									<?php endif ?>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size:16px;"><b></b></label>
									<div class="modal-footer justify-content-center">
										<button class="btn btn-primary" id="action_take" data-toggle="modal" data-target="#success-modal">Take&nbsp;Action</button>
									</div>
								</div>
							</div>
							
							<form  method="post">
  								<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body text-center font-18">
												<h4 class="mb-20">Password Request take action</h4>
												<div class="form-group">
													<label><?php echo htmlentities($result->first_name." ".$result->last_name);?></label><label>,&nbsp;new Password :</label>
													<input name="password" type="text" class="form-control" id="password" required="true" autocomplete="off" onclick="generatePassword()">
													<input name="EmailId" type="hidden" class="form-control" id="EmailId" required="true" autocomplete="off" value="<?php echo htmlentities($result->email_id);?>">
													<input name="name" type="hidden" class="form-control" id="EmailId" required="true" autocomplete="off" value="<?php echo htmlentities($result->first_name." ".$result->last_name);?>">
													<input name="lid" type="hidden" class="form-control" id="lid" required="true" autocomplete="off" value="<?php echo $lid; ?>">
												</div>
											</div>
											<div class="modal-footer justify-content-center">
											<input type="submit" class="btn btn-primary" value="Submit">
											</div>
										</div>
									</div>
								</div>
  							</form>

							<?php }?>
						</div>

						<?php $cnt++;} }?>
					</form>
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