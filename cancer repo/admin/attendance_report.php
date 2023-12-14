<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php
$host = "host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres user=postgres password=sbit4e-4thyear-capstone-2023";

try {
    $dbh = new PDO("pgsql:" . $host);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['delete'])) {
        $delete_request_id = $_GET['delete'];

        $deleteQuery = $dbh->prepare("DELETE FROM hr_equipment_request WHERE id = :id");
        $deleteQuery->bindParam(':id', $delete_request_id);
        $deleteQuery->execute();

        echo "<script>alert('Equipment request deleted Successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'pending_equipment_request.php'; </script>";
    }

    if (isset($_GET['approve'])) {
        $approved_request_id = $_GET['approve'];

        $updateStatusQuery = $dbh->prepare("UPDATE hr_equipment_request SET status = 'Approved' WHERE id = :id");

        $updateStatusQuery->bindParam(':id', $approved_request_id);
        $updateStatusQuery->execute();

        echo "<script>alert('Status updated to Approved');</script>";
        echo "<script type='text/javascript'> document.location = 'pending_equipment_request.php'; </script>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
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
                    <h2 class="text-blue h4">PENDING EQUIPMENT REQUEST</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" text-align: center;>
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">NAME</th>
                                <th>DEPARTMENT</th>
                                <th>DATE</th>
                                <th>TIME - IN</th>
                                <th>TIME - OUT</th>

                                <th class="datatable-nosort">REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <?php 
								$currentDate = date("Y-m-d");
                                $sql = "SELECT * FROM hr_attendance 
                                INNER JOIN hr_employees ON hr_attendance.emp_id = hr_employees.emp_id
                                WHERE date = :currentDate
                                ORDER BY hr_attendance.id DESC";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':currentDate', $currentDate);
                                $query->execute();

                                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                    // Your code logic inside the loop here...
                                ?>

                                <td class="table-plus">

                                    <?php echo $row['first_name'] ." ".  $row['last_name']; ?></td>
                                <td><?php echo $row['department']; ?></td>
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