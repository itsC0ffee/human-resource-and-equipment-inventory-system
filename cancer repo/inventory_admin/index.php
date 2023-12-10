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
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
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
								<div class="font-14 text-secondary weight-500">Total Equipment</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
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
								<div class="font-14 text-secondary weight-500">Total Equipment</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
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
								<div class="font-14 text-secondary weight-500">Total Equipment</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#00eccf"><i class="icon-copy dw dw-user-2"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=1;
						$sql = "SELECT id from hr_leaves where status=:status";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo htmlentities($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Available</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#09cc06"><span class="icon-copy dw dw-user-2"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=0;
						$sql = "SELECT id from hr_leaves where status=:status";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>        

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">Outgoing</div>
							</div>
							<div class="widget-icon">
								<div class="icon"><i class="icon-copy dw dw-user-2" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-3 col-md-6 mb-20">
					<div class="card-box height-100-p widget-style3">

						<?php
						$status=2;
						$sql = "SELECT id from hr_leaves where status=:status";
						$query = $dbh -> prepare($sql);
						$query->bindParam(':status',$status,PDO::PARAM_STR);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$leavecount=$query->rowCount();
						?>  

						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-dark"><?php echo($leavecount); ?></div>
								<div class="font-14 text-secondary weight-500">return</div>
							</div>
							<div class="widget-icon">
								<div class="icon" data-color="#ff5b5b"><i class="icon-copy dw dw-user-2" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			

			<div class="row">
				<div class="col-lg-6 col-md-6 mb-20">
					<div class="card-box height-100-p pd-20 min-height-200px">
						<div class="pd-20">
						<h2 class="text-blue h4">Equipment Record</h2>
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