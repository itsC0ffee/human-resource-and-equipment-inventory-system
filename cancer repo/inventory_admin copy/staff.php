<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
if (isset($_GET['delete'])) {
	$delete = $_GET['delete'];
	$sql = "DELETE FROM tblemployees where emp_id = ".$delete;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Staff deleted Successfully');</script>";
     	echo "<script type='text/javascript'> document.location = 'staff.php'; </script>";
		
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

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="title pb-20">
				<h2 class="h3 mb-0">Manage Employee Accounts</h2>
			</div>
			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">ALL EMPLOYEES</h2>
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">FULL NAME</th>
								<th>EMPLOYEE ID</th>
								<th>EMAIL</th>
								<th>PHONE</th>
								<th>JOIN DATE</th>
								<th>TIME SCHEDULE</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								 <?php
		                         $teacher_query = mysqli_query($conn,"select FirstName,LastName,emp_id,EmailId,Phonenumber,RegDate,sched_time_in,sched_time_out from tblemployees where role != 'Admin' ORDER BY tblemployees.emp_id") or die(mysqli_error());
		                         while ($row = mysqli_fetch_array($teacher_query)) {
		                         $id = $row['emp_id'];
		                             ?>

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="avatar mr-2 flex-shrink-0">
											<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" class="border-radius-100 shadow" width="40" height="40" alt="">
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['FirstName'] . " " . $row['LastName']; ?></div>
										</div>
									</div>
								</td>
								<td><a class="button-link" href="edit_staff.php?edit=<?php echo $row['emp_id'];?>"><?php echo $row['emp_id']; ?></a></td>
	                            <td><?php echo $row['EmailId']; ?></td>
								<td><?php echo $row['Phonenumber']; ?></td>
								<td><?php echo date('Y-m-d', strtotime($row['RegDate'])); ?></td>

								<?php $time_in = date('h:i A', strtotime($row['sched_time_in']));
								$time_out = date('h:i A', strtotime($row['sched_time_out'])); ?>
								<td><?php echo $time_in . " - " . $time_out; ?></td>

								<td>
								<div class="table-actions">
														<a href="edit_staff.php?edit=<?php echo $row['emp_id'];?>" data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
														<a href="staff.php?delete=<?php echo $row['emp_id'] ?>" data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
													</div>
									<!--<div class="dropdown">
										<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
											<i class="dw dw-more"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
											<a class="dropdown-item" href="edit_staff.php?edit=<?php echo $row['emp_id'];?>"><i class="dw dw-edit2"></i> Edit</a>
											<a class="dropdown-item" href="staff.php?delete=<?php echo $row['emp_id'] ?>"><i class="dw dw-delete-3"></i> Delete</a>
										</div>
									</div> -->
								</td>
							</tr>
							<?php } ?>  
						</tbody>
					</table>
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->

	<?php include('includes/scripts.php')?>
</body>
</html>