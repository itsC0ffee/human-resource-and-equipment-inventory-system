<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php

?>






<style>
.action-btn {
    border-radius: 8px;
    padding: 5px 10px;
    font-size: 12px;
    margin-right: 5px;
}

.btn-approve {
    background-color: #198754;
    color: #fff;
    border: none;
}

.btn-reject {
    background-color: #DC3545;
    color: #fff;
    border: none;
}
</style>

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
                                <li class="breadcrumb-item active" aria-current="page">Pending Leave</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30">
                <div class="pd-20">
                    <h2 class="text-blue h4">MANAGE EQUIPMENT REQUEST</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" text-align: center;>
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">EQUIPMENT CATEGORY</th>
                                <th>QUANTITY</th>
                                <th>DATE OF REQUEST</th>
                                <th>ATTACHMENT STATUS</th>
                                <th>APROVAL STATUS</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <?php 
								$status = "Pending";
								$query = $dbh->prepare("
								SELECT hr_equipment_request.id AS lid, hr_equipment_request.equipment_category,hr_equipment_request.quantity, hr_equipment_request.posting_date,hr_equipment_request.status,hr_employees.first_name,hr_employees.last_name,hr_employees.department
								FROM hr_equipment_request
								JOIN hr_employees ON hr_equipment_request.emp_id = hr_employees.emp_id
								WHERE hr_equipment_request.status = :status
								ORDER BY lid DESC
								LIMIT 10;
								");
								$query->bindParam(':status', $status);
								$query->execute();

								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

								?>

                                <td class="table-plus">

                                    <?php echo $row['equipment_category']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['posting_date']; ?></td>
                                <td><?php $stats=$row['status'];
	                             if($stats=="Pending"){
	                              ?>
                                    <span style="color: green">Approved</span>
                                    <?php } ?>
                                </td>
                                <td>


                                <td>
                                    <div class="table-actions">
                                        <button class="action-btn btn-approve"
                                            onclick="ApprovedItem(<?php echo htmlentities($row['lid']); ?>)">Approve</button>

                                        <button class="action-btn btn-reject"
                                            onclick="deleteItem(<?php echo htmlentities($row['lid']); ?>)">Reject</button>

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
    function deleteItem(itemId) {
        if (confirm('Are you sure you want to Delete this Request?')) {
            window.location.href = 'pending_equipment_request.php?delete=' + itemId;
        }
    }

    function ApprovedItem(itemId) {
        if (confirm('Are you sure you want to Approve this Request?')) {
            window.location.href = 'pending_equipment_request.php?approve=' + itemId;
        }
    }
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