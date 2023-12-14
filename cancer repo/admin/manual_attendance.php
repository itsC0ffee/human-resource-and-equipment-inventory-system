<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php

// Assuming you've established a PDO connection named $dbh

if(isset($_POST['add_attendance'])) {
    $admin_emp_id = $session_id;
    $emp_id = $_POST['emp_id'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $fullName = $_POST['name'];
    $nameParts = explode(' ', $fullName);
    $fname = $nameParts[0];
    $lname = end($nameParts);
    $start_date = date('Y-m-d', strtotime($_POST['start_date']));
    $end_date = date('Y-m-d', strtotime($_POST['end_date']));
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $zipcode = $_POST['zipcode'];
    $reason = $_POST['reason'];
    $department_order = $_POST['department_order'];
    $status = "Active";
    $attendance_status = "Manual";
    $date = date("Y-m-d");
    $activity = "Add manual attendance of " . $fullName;

    try {
        $dbh->beginTransaction();

        $stmt1 = $dbh->prepare("SELECT city_name, barangay_name FROM hr_city, hr_barangay WHERE hr_city.id=:city AND hr_barangay.id=:barangay");
        $stmt1->bindParam(':city', $city);
        $stmt1->bindParam(':barangay', $barangay);
        $stmt1->execute();
        $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($result1) {
            $newCity = $result1['city_name'];
            $newBarangay = $result1['barangay_name'];
        }

        $stmt2 = $dbh->prepare("SELECT first_name FROM hr_employees WHERE emp_id=:admin_emp_id");
        $stmt2->bindParam(':admin_emp_id', $admin_emp_id);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($result2) {
            $first_name = $result2['first_name'];
        }

        $stmt3 = $dbh->prepare("INSERT INTO hr_attendance (emp_id, time_in, time_out, date, status, attendance_status, first_name, last_name, start_date, end_date, city, barangay, zipcode, reason, location) VALUES (:emp_id, :time_in, :time_out, :date, :status, :attendance_status, :fname, :lname, :start_date, :end_date, :newCity, :newBarangay, :zipcode, :reason, :department_order)");
        $stmt3->bindParam(':emp_id', $emp_id);
        $stmt3->bindParam(':time_in', $time_in);
        $stmt3->bindParam(':time_out', $time_out);
        $stmt3->bindParam(':date', $date);
        $stmt3->bindParam(':status', $status);
        $stmt3->bindParam(':attendance_status', $attendance_status);
        $stmt3->bindParam(':fname', $fname);
        $stmt3->bindParam(':lname', $lname);
        $stmt3->bindParam(':start_date', $start_date);
        $stmt3->bindParam(':end_date', $end_date);
        $stmt3->bindParam(':newCity', $newCity);
        $stmt3->bindParam(':newBarangay', $newBarangay);
        $stmt3->bindParam(':zipcode', $zipcode);
        $stmt3->bindParam(':reason', $reason);
        $stmt3->bindParam(':department_order', $department_order);
        $stmt3->execute();

        $stmt4 = $dbh->prepare("INSERT INTO hr_logs (emp_id, name, date, activity) VALUES (:admin_emp_id, :first_name, :date, :activity)");
        $stmt4->bindParam(':admin_emp_id', $admin_emp_id);
        $stmt4->bindParam(':first_name', $first_name);
        $stmt4->bindParam(':date', $date);
        $stmt4->bindParam(':activity', $activity);
        $stmt4->execute();

        $dbh->commit();

    } catch (PDOException $e) {
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>



<script>
function updateBarangay() {
    // Get the selected city
    var city = document.getElementById("city").value;

    // Show only the barangays that belong to the selected city
    var barangays = document.getElementById("barangay").getElementsByTagName("option");
    for (var i = 0; i < barangays.length; i++) {
        if (barangays[i].classList.contains(city)) {
            barangays[i].style.display = "block";
        } else {
            barangays[i].style.display = "none";
        }
    }
}
</script>



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
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Manual Attendance</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Employee Information</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="">
                            <section>
                                <div class="row search">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <input id="searchInput" type="text" class="form-control wizard-required"
                                                required="true" autocomplete="off" placeholder="Search Employee">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee ID:</label>
                                            <input name="emp_id" id="empIdInput" type="text"
                                                class="form-control wizard-required" readonly required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Employee Name:</label>
                                            <input name="name" id="fullNameInput" type="text" class="form-control"
                                                readonly required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department:</label>
                                            <input name="department" id="departmentInput" type="text"
                                                class="form-control" readonly required="true" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-blue h4">Date & Location</h4>
                                        <p class="mb-20"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Start Date :</label>
                                            <input name="start_date" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>End Date :</label>
                                            <input name="end_date" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Time - In :</label>
                                            <input name="time_in" type="time" class="form-control" required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Time - Out :</label>
                                            <input name="time_out" type="time" class="form-control" required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <?php 
											// Create the city dropdown
											$query = $dbh->query("SELECT * FROM hr_city");		
											?>
                                            <label>City :</label>
                                            <select id='city' name='city' onchange='updateBarangay()'
                                                class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="">Select City</option>
                                                <?php
													while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                                                <option value="<?php echo $row['id'];?>">
                                                    <?php echo $row['city_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <?php 
											// Create the barangay dropdown
											$query = $dbh->query("SELECT * FROM hr_barangay");
											?>
                                            <label>City :</label>
                                            <select id="barangay" name="barangay" class="custom-select form-control"
                                                required="true" autocomplete="off">
                                                <option value="">Select Barangay</option>
                                                <?php
														while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                                                <?php echo "<option value='" . $row["id"] . "' class='" . $row["city_id"] . "'>" . $row["barangay_name"] . "</option>"; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Zip code:</label>
                                            <input name="zipcode" type="text" class="form-control" required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Department Order:</label>
                                            <input name="department_order" type="file" class="form-control"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Reason :</label>
                                            <textarea id="textarea1" name="reason" class="form-control" required
                                                length="150" maxlength="150" required="true"
                                                autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_attendance"
                                                    id="add_attendance" data-toggle="modal">Add&nbsp;Attendance</button>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let query = this.value;
            if (query !== "") {
                fetch(`search.php?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            // Update the full name input with first_name + ' ' + LastName
                            const fullName = data[0].FullName || '';
                            document.getElementById("fullNameInput").value = fullName.trim();
                            // Update department and employee ID inputs
                            document.getElementById("departmentInput").value = data[0].department ||
                                '';
                            document.getElementById("empIdInput").value = data[0].emp_id || '';
                        } else {
                            // Clear the fields if no data is found
                            document.getElementById("fullNameInput").value = "";
                            document.getElementById("departmentInput").value = "";
                            document.getElementById("empIdInput").value = "";
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            } else {
                // Clear the fields if search query is empty
                document.getElementById("fullNameInput").value = "";
                document.getElementById("departmentInput").value = "";
                document.getElementById("empIdInput").value = "";
            }
        });


    });






    function updateBarangay() {
        // Get the selected city
        var city = document.getElementById("city").value;

        // Show only the barangays that belong to the selected city
        var barangays = document.getElementById("barangay").getElementsByTagName("option");
        for (var i = 0; i < barangays.length; i++) {
            if (barangays[i].classList.contains(city)) {
                barangays[i].style.display = "block";
            } else {
                barangays[i].style.display = "none";
            }
        }
    }
    </script>


    <?php include('includes/scripts.php')?>
</body>

</html>