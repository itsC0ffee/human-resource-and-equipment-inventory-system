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
			
												<button class="btn btn-primary" name="apply_equip" id="apply_equip" ><a href="apply_equipment_request.php" style="color: white;">+ Equipment&nbsp;Request</a></button>
											</div>
										</div>
		</form>
				<div class="pd-20">
						<h2 class="text-blue h4">REQUEST EQUIPMENT</h2>
						
					</div>
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="table-plus">EQUIPMENT CATEGORY</th>
								<th>QUANTITY</th>
								<th>APROVAL STATUS</th>
								<th class="datatable-nosort">ACTION</th>
							</tr>
						</thead>
						<?php 
    $sql = "SELECT * from tblequipmentrequest where emp_id = '$session_id'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $rowNumber = 1; // Initializing the row number variable
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>
            <tr>
               <!-- Displaying the auto-incremented row number -->
                <td><?php echo htmlentities($rowNumber.". ".$result->equipment_category); ?></td>
                <td><?php echo htmlentities($result->quantity); ?></td>
                <td><?php
                    $stats = $result->status;
                    if ($stats == "Approved") { ?>
                        <span style="color: green">Approved</span>
                    <?php } elseif ($stats == "Rejected") { ?>
                        <span style="color: red">Not Approved</span>
                    <?php } elseif ($stats == "Pending") { ?>
                        <span style="color: blue">Pending</span>
                    <?php } ?>
                </td>
                <td>
                    <div class="table-actions">
                        <a title="VIEW" href="view_request.php?edit=<?php echo htmlentities($result->id); ?>" data-color="#265ed7">
                            <i class="icon-copy dw dw-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php $rowNumber++; // Incrementing the row number variable
        }
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