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
                <h2 class="h3 mb-0">HR EMPLOYEE ACTIVITY LOGS</h2>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">ALL HR EMPLOYEES</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus">EMPLOYEE ID</th>
                                <th>NAME</th>
                                <th>DATE</th>
                                <th class="datatable-nosort">ACTIVITY DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
								 $query = $dbh->query("SELECT * FROM hr_logs");		
		                         while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		                         $id = $row['emp_id'];
		                             ?>

                                <td class="table-plus">
                                    <?php echo $row['emp_id']; ?>
                                </td>


                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($row['date'])); ?></td>
                                <td><?php echo $row['activity']; ?></td>
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