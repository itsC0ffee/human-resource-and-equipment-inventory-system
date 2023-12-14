<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php

if(isset($_POST['apply'])) {
    $empid = $session_id;
    $leave_type = $_POST['leave_type'];
    $fromdate = date('Y-m-d', strtotime($_POST['date_from'])); // Modified date format to match database format
    $todate = date('Y-m-d', strtotime($_POST['date_to'])); // Modified date format to match database format
    $description = $_POST['description'];  
    $status = 0;
    $isread = 0;
    $leave_days = $_POST['leave_days'];
    $datePosting = date("Y-m-d");

    if($fromdate > $todate) {
        echo "<script>alert('End Date should be greater than Start Date');</script>";
    } elseif($leave_days <= 0) {
        echo "<script>alert('YOU HAVE EXCEEDED YOUR LEAVE LIMIT. LEAVE APPLICATION FAILED');</script>";
    } else {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
        $location = $image;	

        $DF = date_create($_POST['date_from']);
        $DT = date_create($_POST['date_to']);
        $diff =  date_diff($DF , $DT );
        $num_days = (1 + $diff->format("%a"));

        try {
			$host = "host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres user=postgres password=sbit4e-4thyear-capstone-2023";
            $dbh = new PDO("pgsql:$host");
    		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO hr_leaves(leave_type, to_date, from_date, description, status, is_read, emp_id, num_days, posting_date, location) VALUES(:leave_type, :todate, :fromdate, :description, :status, :isread, :empid, :num_days, :datePosting, :location)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':leave_type', $leave_type, PDO::PARAM_STR);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':isread', $isread, PDO::PARAM_STR);
            $query->bindParam(':empid', $empid, PDO::PARAM_STR);
            $query->bindParam(':num_days', $num_days, PDO::PARAM_STR);
            $query->bindParam(':datePosting', $datePosting, PDO::PARAM_STR);
            $query->bindParam(':location', $location, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId) {
                echo "<script>alert('Leave Application was successful.');</script>";
                echo "<script type='text/javascript'> document.location = 'leave_history.php'; </script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
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

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pb-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Leave Application</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Apply for Leave</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div style="margin-left: 50px; margin-right: 50px;" class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Leave Request Form</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="" enctype="multipart/form-data">
                            <section>

                                <?php if ($role_id = 'Employee'): ?>
                                <?php
									$query = $dbh->prepare("SELECT * FROM hr_employees WHERE emp_id = :session_id");
									$query->bindParam(':session_id', $session_id);
									$query->execute();
									$row = $query->fetch(PDO::FETCH_ASSOC);
								?>
                                <div class="row">

                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Available Leave Days </label>
                                            <input name="leave_days" type="text" class="form-control" required="true"
                                                autocomplete="off" readonly value="<?php echo $row['av_leave']; ?>">
                                        </div>
                                    </div>
                                    <?php endif ?>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Leave Type :</label>
                                            <select name="leave_type" class="custom-select form-control" required="true"
                                                autocomplete="off">
                                                <option value="">Select leave type...</option>
                                                <?php 
													$sql = "SELECT leave_type FROM hr_leave_type";
													$query = $dbh->prepare($sql);
													$query->execute();
													$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{   ?>
                                                <option value="<?php echo htmlentities($result->leave_type);?>">
                                                    <?php echo htmlentities($result->leave_type);?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Start Leave Date :</label>
                                            <input name="date_from" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>End Leave Date :</label>
                                            <input name="date_to" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Reason For Leave :</label>
                                            <textarea id="textarea1" name="description" class="form-control" required
                                                length="150" maxlength="150" required="true"
                                                autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Attach File:</label>
                                                <input name="image" id="file" type="file" class="form-control"
                                                    required="true" autocomplete="off">
                                            </div>
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="apply" id="apply"
                                                    data-toggle="modal">Apply&nbsp;Leave</button>
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