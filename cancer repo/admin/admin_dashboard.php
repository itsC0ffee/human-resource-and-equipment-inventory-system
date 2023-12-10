<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
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
				<h2 class="h3 mb-0">Dashboard</h2>
			</div>
			<div class="row pb-10">
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$sql = "SELECT emp_id from hr_employees";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$empcount=$query->rowCount();
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($empcount);?></div>
								<div class="font-14 text-secondary weight-500">Total Employee</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><img src="../vendors/images/total_emp_icon.svg" alt=""></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

					<?php
												
						$currentDate = date("Y-m-d");
						$sql = "SELECT COUNT(id) AS count FROM hr_attendance WHERE date(date) = :currentDate";
						$query = $dbh->prepare($sql);
						$query->bindParam(':currentDate', $currentDate);
						$query->execute();
											
						$result = $query->fetch(PDO::FETCH_ASSOC);
						$present = $result['count'];
						?>

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($present); ?></div>
								<div class="font-14 text-secondary weight-500">Todays Attendance</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><img src="../vendors/images/user_icon.svg" alt=""></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">
					<?php
// First Code
$currentDate = date("Y-m-d");
$sql = "SELECT COUNT(id) AS count FROM hr_attendance WHERE date(date) = :currentDate";
$query = $dbh->prepare($sql);
$query->bindParam(':currentDate', $currentDate);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$present = $result['count'];

// Second Code
$sql = "SELECT emp_id from hr_employees";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$empcount = $query->rowCount();

// Third Code
$currentDate = date("d-m-Y");
$sql = "SELECT COUNT(id) AS count_leaves
        FROM hr_leaves
        WHERE :currentDate BETWEEN date(from_date) AND date(to_date);";
$query = $dbh->prepare($sql);
$query->execute([':currentDate' => $currentDate]);
$result = $query->fetch(PDO::FETCH_ASSOC);
$today_Leaves = isset($result['count_leaves']) ? $result['count_leaves'] : 0;

// Calculate the difference
$absent = $empcount - $present - $today_Leaves;

?>
<div class="d-flex flex-wrap">
    <div class="widget-data">
        <div class="weight-700 font-24 text-dark"><?php echo htmlentities($absent); ?></div>
        <div class="font-14 text-secondary weight-500">Today's Absent</div>
    </div>
    <div class="widget-icon">
        <div class="icon"><img src="../vendors/images/user_icon.svg" alt=""></div>
    </div>
</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$currentDate = date("d-m-Y");
						$sql = "SELECT COUNT(id) AS count_leaves
						FROM hr_leaves
						WHERE :currentDate BETWEEN date(from_date) AND date(to_date);";
						$query = $dbh->prepare($sql);
						$query->execute([':currentDate' => $currentDate]); // Pass the parameter directly in execute()
						
						$result = $query->fetch(PDO::FETCH_ASSOC);
						
						// Check if the result exists before accessing the 'count_leaves' key
						$today_Leaves = isset($result['count_leaves']) ? $result['count_leaves'] : 0;
	?>


						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($today_Leaves); ?></div>
								<div class="font-14 text-secondary weight-500">Todays Leave</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><img src="../vendors/images/user_icon.svg" alt=""></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between pb-10">
							<div class="h5 mb-0">Today Attendance</div>
							<div class="table-actions">
								<a title="VIEW" href="staff.php"><i class="icon-copy dw dw-user-2" data-color="#17a2b8"></i></a>	
							</div>
						</div>
						<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">EMPLOYEE NAME</th>
								<th>TIME - IN</th>
								<th>TIME - OUT</th>
								<th>DATE</th>
								<th>STATUS</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php 
								$status="";
								$count=1;
								$sql = "SELECT *
								FROM hr_attendance
								WHERE DATE(date) = CURDATE()
								ORDER BY id DESC
								";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									while ($row = mysqli_fetch_array($query)) {
									
								 ?>  

								<td class="table-plus">
									<div class="name-avatar d-flex align-items-center">
										<div class="txt mr-2 flex-shrink-0">
											<b><?php echo$count; ?></b>
										</div>
										<div class="txt">
											<div class="weight-600"><?php echo $row['first_name']." ".$row['last_name'];?></div>
										</div>
									</div>
								</td>
							
								<td><?php echo $row['time_in']; ?></td>
	                            <td><?php echo $row['time_out']; ?></td>
								<td><?php echo $row['date']; ?></td>
								<td><?php $stats=$row['status'];
	                             if($stats=="Active"){
	                              ?>
	                                  <span style="color: green">Active</span>
	                                  <?php } if($stats=="Active \ Late")  { ?>
	                                 <span style="color: red">Active \ Late</span>
	                             <?php } ?>
	                            </td>
							</tr>
							<?php  $count++;}?>
						</tbody>
					</table>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="d-flex justify-content-between">
							<div class="h5 mb-0">Calendar</div>
							
						</div>
									<div><iframe src="https://embed.styledcalendar.com/#UEQosPJYBrGmdELUQFvq" title="Styled Calendar" class="styled-calendar-container" style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
						<script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js"></script></div>
						
					</div>
				</div>
			
			</div>

			<div class="card-box mb-30">
				<div class="pd-20">
						<h2 class="text-blue h4">MONTHLY ABSENCE RATE</h2>
					</div>
				<div class="pb-20" >
				<?php $sql = "SELECT * FROM hr_absent_rates;";
									$query = mysqli_query($conn, $sql) or die(mysqli_error());
									$chart_data="";
									while ($row = mysqli_fetch_array($query)) { 
										$months[]  = $row['months']  ;
										$absents[] = $row['absents'];
									}
								 ?>  
				<canvas  id="chartjs_bar" style="max-height: 600px;"></canvas> 
			   </div>
			</div>

			<?php include('includes/footer.php'); ?>
		</div>
	</div>
	<!-- js -->
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($months); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750","#ffc750"
                            ],
                            data:<?php echo json_encode($absents); ?>,
                        }]
                    },
                    options: {
                           legend: {
                        display: false,
                        position: 'bottom',
 
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
                }
                });
    </script>
	<?php include('includes/scripts.php')?>
</body>

</html>