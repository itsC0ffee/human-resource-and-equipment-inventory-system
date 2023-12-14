<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php $get_id = $_GET['edit']; ?>
<?php
	if(isset($_POST['add_staff']))
	{
	
	$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$department = $_POST['department'];
$address = $_POST['address'];
$leave_days = $_POST['leave_days'];
$user_role = $_POST['user_role'];
$phonenumber = $_POST['phonenumber'];

$sql = "UPDATE hr_employees 
        SET first_name = :fname, 
            last_name = :lname, 
            email_id = :email, 
            gender = :gender, 
            dob = :dob, 
            department = :department, 
            address = :address, 
            av_leave = :leave_days, 
            role = :user_role, 
            phone_number = :phonenumber 
        WHERE emp_id = :get_id";

$query = $dbh->prepare($sql);
$query->bindParam(':fname', $fname);
$query->bindParam(':lname', $lname);
$query->bindParam(':email', $email);
$query->bindParam(':gender', $gender);
$query->bindParam(':dob', $dob);
$query->bindParam(':department', $department);
$query->bindParam(':address', $address);
$query->bindParam(':leave_days', $leave_days);
$query->bindParam(':user_role', $user_role);
$query->bindParam(':phonenumber', $phonenumber);
$query->bindParam(':get_id', $get_id); // Assuming $get_id is defined somewhere

if ($query->execute()) {
    echo "<script>alert('Record Successfully Updated');</script>";
    echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
} else {
    die(print_r($dbh->errorInfo(), true)); // Check for errors in execution
}

		
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
                                    <li class="breadcrumb-item active" aria-current="page">Staff Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Edit Staff</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <?php
								$query = $dbh->query("SELECT * FROM hr_employees WHERE emp_id = '$get_id'");
								$row = $query->fetch(PDO::FETCH_ASSOC);
								
									?>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name :</label>
                                            <input name="firstname" type="text" class="form-control wizard-required"
                                                required="true" autocomplete="off"
                                                value="<?php echo $row['first_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name :</label>
                                            <input name="lastname" type="text" class="form-control" required="true"
                                                autocomplete="off" value="<?php echo $row['last_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email Address :</label>
                                            <input name="email" type="email" class="form-control" required="true"
                                                autocomplete="off" value="<?php echo $row['email_id']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Password :</label>
                                            <input name="password" type="password" placeholder="**********"
                                                class="form-control" readonly required="true" autocomplete="off"
                                                value="<?php echo $row['password']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Gender :</label>
                                            <select name="gender" class="custom-select form-control" required="true"
                                                autocomplete="off">
                                                <option value="<?php echo $row['gender']; ?>">
                                                    <?php echo $row['gender']; ?></option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone Number :</label>
                                            <input name="phonenumber" type="text" class="form-control" required="true"
                                                autocomplete="off" value="<?php echo $row['phone_number']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date Of Birth :</label>
                                            <input name="dob" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off" value="<?php echo $row['dob']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address :</label>
                                            <input name="address" type="text" class="form-control" required="true"
                                                autocomplete="off" value="<?php echo $row['address']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department :</label>
                                            <select name="department" class="custom-select form-control" required="true"
                                                autocomplete="off">
                                                <?php
									
													$queryStaff = $dbh->query("SELECT * FROM hr_employees, hr_departments WHERE emp_id = '$get_id'") or die(mysqli_error());
													$rowStaff = $queryStaff->fetch(PDO::FETCH_ASSOC);
													?>

                                                <option value="<?php echo $rowStaff['department_short_name']; ?>">
                                                    <?php echo $rowStaff['department_name']; ?></option>

                                                <?php
													$query = $dbh->query("SELECT * FROM hr_departments");
													while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
												?>
                                                <option value="<?php echo $row['department_short_name']; ?>">
                                                    <?php echo $row['department_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <?php
									$query = $dbh->query("SELECT * FROM hr_employees WHERE emp_id = '$get_id'");
									$new_row = $query->fetch(PDO::FETCH_ASSOC);
									
									?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Staff Leave Days :</label>
                                            <input name="leave_days" type="text" class="form-control" required="true"
                                                autocomplete="off" value="<?php echo $new_row['av_leave']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>User Role :</label>
                                            <select name="user_role" class="custom-select form-control" required="true"
                                                autocomplete="off">
                                                <option value="<?php echo $new_row['role']; ?>">
                                                    <?php echo $new_row['role']; ?></option>
                                                <option value="Admin">Admin</option>
                                                <option value="HOD">HOD</option>
                                                <option value="Employee">Staff</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_staff" id="add_staff"
                                                    data-toggle="modal">Update&nbsp;Staff</button>
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
    <?php include('includes/scripts.php')?>
</body>

</html>