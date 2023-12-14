<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php
	if(isset($_POST['apply'])) {
		$emp_id = $session_id;
		$reason = $_POST['reason'];
		$postingDate = date("Y-m-d");
		$adminRemark = "Pending";
		$adminRemarkDate = null;
		$status = "Pending";
		$file_name = "";
		$file_data = null;
	
		$equipment_categories = $_POST['equipment_category'];
		$quantities = $_POST['quantity'];
	
		// Loop through each set of equipment data for insertion
		foreach ($equipment_categories as $key => $equipment_category) {
			$quantity = $quantities[$key];
	
			$sql = "INSERT INTO hr_equipment_request (emp_id, equipment_category, quantity, reason, posting_date, admin_Remark, admin_remark_date, status, file_name, file_data) 
					VALUES (:emp_id, :equipment_category, :quantity, :reason, :postingDate, :adminRemark, :adminRemarkDate, :status, :file_name, :file_data)";
			
			$query = $dbh->prepare($sql);
			$query->bindParam(':emp_id', $emp_id, PDO::PARAM_STR);
			$query->bindParam(':equipment_category', $equipment_category, PDO::PARAM_STR);
			$query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
			$query->bindParam(':reason', $reason, PDO::PARAM_STR);
			$query->bindParam(':postingDate', $postingDate, PDO::PARAM_STR);
			$query->bindParam(':adminRemark', $adminRemark, PDO::PARAM_STR);
			$query->bindParam(':adminRemarkDate', $adminRemarkDate, PDO::PARAM_NULL);
			$query->bindParam(':status', $status, PDO::PARAM_STR);
			$query->bindParam(':file_name', $file_name, PDO::PARAM_STR);
			$query->bindParam(':file_data', $file_data, PDO::PARAM_NULL);
			
			$query->execute();
			// Handle successful/failed inserts here
		}
	
		// Redirect or provide feedback after all inserts are done
	}



?>

<body>


    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pb-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Equipment Request</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Equipment Request</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div style="margin-left: 50px; margin-right: 50px;" class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Requester Information</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>

                                <?php
                                $query = $dbh->prepare("SELECT * FROM hr_employees WHERE emp_id = :session_id");
                                $query->bindParam(':session_id', $session_id);
                                $query->execute();
                                $row = $query->fetch(PDO::FETCH_ASSOC);
								?>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <input name="emp_id" type="text" class="form-control wizard-required"
                                                required="true" readonly autocomplete="off"
                                                value="<?php echo $row['emp_id']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text" class="form-control" readonly required="true"
                                                autocomplete="off"
                                                value="<?php echo $row['first_name']." ".$row['last_name']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input name="department" type="text" class="form-control wizard-required"
                                                required="true" readonly autocomplete="off"
                                                value="<?php echo $row['department']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input name="email" type="text" class="form-control" readonly
                                                required="true" autocomplete="off"
                                                value="<?php echo $row['email_id']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div id="dynamicRows">
                                    <!-- Initial row for equipment request -->
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Equipment Type:</label>
                                                <select name="equipment_category[]" class="custom-select form-control"
                                                    required="true" autocomplete="off">
                                                    <option value="">Select Equipment type...</option>
                                                    <?php $sql = "SELECT  type_name from inv_equipment_types";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>
                                                    <option value="<?php echo htmlentities($result->type_name);?>">
                                                        <?php echo htmlentities($result->type_name);?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Quantity:</label>
                                                <input name="quantity[]" type="text" class="form-control"
                                                    required="true" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="button" id="addRowBtn">Add Row</button>

                                <!-- Submit button -->
                                <!-- ... -->

                                <script>
                                document.getElementById("addRowBtn").addEventListener("click", function() {
                                    var dynamicRows = document.getElementById("dynamicRows");
                                    var newRow = dynamicRows.firstElementChild.cloneNode(true);
                                    dynamicRows.appendChild(newRow);
                                });
                                </script>


                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Reason For Request Equipment :</label>
                                            <textarea id="textarea1" name="reason" class="form-control" required
                                                length="150" maxlength="150" required="true"
                                                autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply"
                                                    data-toggle="modal">Submit&nbsp;Request</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>

            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <?php include('includes/scripts.php')?>
</body>

</html>