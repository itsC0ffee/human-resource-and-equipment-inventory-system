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
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Leave Portal</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Leave</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">ALL LEAVE APPLICATIONS</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">NAME</th>
                                <th>DEPARTMENT</th>
                                <th>APPLIED DATE</th>
                                <th>START DATE</th>
                                <th>END DATE</th>
                                <th>TOTAL DAYS</th>
                                <th>LEAVE TYPE</th>
                                <th>STATUS</th>
                                <th class="datatable-nosort"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <?php 
                                    $query = $dbh->query("SELECT hr_leaves.id as lid, hr_employees.first_name, hr_employees.last_name, hr_employees.location, hr_employees.emp_id, hr_employees.department, hr_leaves.leave_type, hr_leaves.posting_date, hr_leaves.to_date, hr_leaves.from_date, hr_leaves.num_days, hr_leaves.location, hr_leaves.status, hr_leaves.admin_status 
                                    FROM hr_leaves 
                                    JOIN hr_employees ON hr_leaves.emp_id=hr_employees.emp_id 
                                    WHERE hr_leaves.admin_status IN (1, 2)  -- Fetch all statuses: Approved (1), Rejected (2), and Pending (0)
                                    ORDER BY lid DESC 
                                    LIMIT 10");

                                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								 ?>

                                <td class="table-plus">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="avatar mr-2 flex-shrink-0">
                                            <img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>"
                                                class="border-radius-100 shadow" width="40" height="40" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="weight-600">
                                                <?php echo $row['first_name']." ".$row['last_name'];?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php echo $row['posting_date']; ?></td>
                                <td><?php echo $row['to_date']; ?></td>
                                <td><?php echo $row['from_date']; ?></td>
                                <td><?php echo $row['num_days']; ?></td>
                                <td><?php echo $row['leave_type']; ?></td>
                                <td><?php $stats=$row['admin_status'];
	                             if($stats==1){
	                              ?>
                                    <span style="color: green">Approved</span>
                                    <?php } if($stats==2)  { ?>
                                    <span style="color: red">Rejected</span>
                                    <?php } if($stats==0)  { ?>
                                    <span style="color: blue">Pending</span>
                                    <?php } ?>
                                </td>
                                <td>

                                    <div class="table-actions">

                                    </div>

                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if download was triggered
        var downloadFlag = localStorage.getItem('downloadTriggered');

        // If download hasn't been triggered yet, simulate click event
        if (!downloadFlag) {
            var downloadLink = document.getElementById('downloadLink');
            downloadLink.click(); // Simulate click event

            // Set the flag to indicate the download has been triggered
            localStorage.setItem('downloadTriggered', 'true');
        }
    });
    </script>
    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

    <!-- buttons for Export datatable -->
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

    <script src="../vendors/scripts/datatable-setting.js"></script>
</body>
</body>

</html>