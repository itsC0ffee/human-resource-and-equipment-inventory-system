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
                <h2 class="h3 mb-0">HR Employee Dashboard</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-20">
                    <div class="card-box height-100-p pd-20 min-height-200px">
                        <div class="d-flex justify-content-between pb-10">
                            <div class="h5 mb-0">Today Attendance</div>
                            <div class="table-actions">
                                <a title="VIEW" href="staff.php"><i class="icon-copy dw dw-user-2"
                                        data-color="#17a2b8"></i></a>
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
										$currentDate = date("Y-m-d");
										$sql = "SELECT *
											FROM hr_attendance
											WHERE date = :currentDate
											ORDER BY id DESC";
										$query = $dbh->prepare($sql);
										$query->bindParam(':currentDate', $currentDate);
										$query->execute();

										while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
										// Your code logic inside the loop here...
									?>
                                    <td class="table-plus">
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="txt mr-2 flex-shrink-0">
                                                <b><?php echo$count; ?></b>
                                            </div>
                                            <div class="txt">
                                                <div class="weight-600">
                                                    <?php echo $row['first_name']." ".$row['last_name'];?></div>
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
                        <div><iframe src="https://embed.styledcalendar.com/#UEQosPJYBrGmdELUQFvq"
                                title="Styled Calendar" class="styled-calendar-container"
                                style="width: 100%; border: none;" data-cy="calendar-embed-iframe"></iframe>
                            <script async type="module" src="https://embed.styledcalendar.com/assets/parent-window.js">
                            </script>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">MONTHLY ABSENCE RATE</h2>
                </div>
                <div class="pb-20">
                    <?php $sql = "SELECT * FROM hr_absent_rates";
						$query = $dbh->query($sql);
						$chart_data = "";
						$months = [];
						$absents = [];

						while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
							$months[] = $row['months'];
							$absents[] = $row['absents'];
					}

					?>
                    <canvas id="chartjs_bar" style="max-height: 600px;"></canvas>
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
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                backgroundColor: [
                    "#ffc750", "#ffc750", "#ffc750", "#ffc750", "#ffc750", "#ffc750", "#ffc750",
                    "#ffc750", "#ffc750", "#ffc750", "#ffc750"
                ],
                data: <?php echo json_encode($absents); ?>,
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