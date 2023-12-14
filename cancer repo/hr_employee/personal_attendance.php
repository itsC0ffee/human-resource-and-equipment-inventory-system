<?php include('includes/header.php')?>


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
                <div class="form-group">
                    <div class="modal-footer ">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="hide-on-print"
                                data-bs-toggle="dropdown" aria-expanded="false">Export</button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#" onclick="exportTable('pdf')">Export as PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="exportTable('excel')">Export as Excel</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="exportTable('csv')">Export as CSV</a>
                                </li>
                            </ul>
                        </div>
                        <button onclick="printTable()" class="btn btn-primary" name="print"
                            id="hide-on-print">Print</button>
                    </div>
                </div>
                <div class="pd-20">
                    <h2 class="text-blue h4">PERSONAL ATTENDANCE RECORDS</h2>
                </div>
                <div class="pb-20">
                    <table class="data-table table stripe hover nowrap" id="attendanceTable">
                        <thead>
                            <tr>
                                <th class="table-plus">DATE</th>
                                <th>TIME - IN</th>
                                <th>TIME - OUT</th>
                                <th>REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <?php 
                         $sql = "SELECT date, time_in, time_out, status FROM hr_attendance WHERE emp_id = '$session_id'";
						 $query = $dbh->prepare($sql);
						 $query->execute();
						 $results = $query->fetchAll(PDO::FETCH_OBJ);
						 
						 if ($query->rowCount() > 0) {
							 foreach ($results as $result) { ?>
                            <tr>
                                <td><?php echo $result->date; ?></td>
                                <td><?php echo $result->time_in; ?></td>
                                <td><?php echo $result->time_out; ?></td>
                                <td><?php $stats=$result->status; 
	                             if($stats=="Active"){
	                              ?>
                                    <span style="color: green">Active</span>
                                    <?php } if($stats=="Active \ Late")  { ?>
                                    <span style="color: red">Active \ Late</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }
						 } else { ?>
                            <tr>
                                <td colspan="4">No data found</td>
                            </tr>
                            <?php } ?>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>






    <?php include('includes/scripts.php')?>
</body>

</html>