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
            <div class="card-box mb-30">
                <form method="post" action="">
                    <div class="form-group">
                        <div class="modal-footer">
                            <button class="btn btn-primary"><a href="add_equipment.php" style="color: white;">+
                                    Add New Equipment</a></button>
                        </div>
                    </div>
                </form>
                <div class="pd-20">
                    <h2 class="text-blue h4">EQUIPMENT LIST</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus">ID</th>
                                <th>IMAGE</th>
                                <th>EQUIPMENT MODEL</th>
                                <th>SERIAL</th>
                                <th>CATEGORY</th>
                                <th>ADDED BY</th>
                                <th>REG CREATED</th>
                                <th class="datatable-nosort">ACTION</th>
                            </tr>
                        </thead>
                        <?php 
								$query = $dbh->query("SELECT * FROM inv_equipments");		
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								
									
								 ?>
                        <td><?php echo $row['id']; ?></td>
                        <td><img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>"
                                class="img_equip"></td>
                        <td><?php echo $row['equip_model']; ?></td>
                        <td><?php echo $row['serial_no']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['added_by']; ?></td>
                        <td><?php echo $row['reg_create']; ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="edit_department.php?edit=<?php echo htmlentities($row['id']);?>"
                                    data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                <a href="department.php?delete=<?php echo htmlentities($row['id']);?>"
                                    data-color="#e95959"><i class="icon-copy dw dw-delete-3"></i></a>
                            </div>
                        </td>
                        </tr>
                        <?php   
        
		
    }
    ?>
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