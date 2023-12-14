<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>
<?php include('libs/phpqrcode/qrlib.php'); ?>
<?php
	if(isset($_POST['add_equipment'])) {
        $emp_id = $session_id; 
        $equip_model = $_POST['equip_model'];
        $serial_no = $_POST['serial_no'];
        $reg_create = $_POST['reg_create'];
        $type_name = $_POST['type_name'];
        $filename = $serial_no;



        $qrContent = $serial_no;
        $tempDir = 'temp/';
        $qrFilePath = $tempDir . $filename . '.png'; 
        $qr_code = $filename.'.png';
        // Generate QR code and save it to the specified file path
        QRcode::png($qrContent, $qrFilePath, QR_ECLEVEL_L, 5);
        
        
    
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$image);
        $location = $image;	

        $stmt = $dbh->prepare("SELECT first_name, last_name FROM hr_employees WHERE emp_id = :emp_id");
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        $first_name = $employee['first_name'];
        $last_name = $employee['last_name'];

        $added_by = $first_name. " " .$last_name; 
        
        $stmt = $dbh->prepare("SELECT * FROM inv_equipments WHERE serial_no = :serial_no");
        $stmt->bindParam(':serial_no', $serial_no);
        $stmt->execute();
        $count = $stmt->rowCount();
    
        if ($count > 0) {
            echo '<script>alert("Serial Already Exists");</script>';
        } else {
            $insertQuery = "INSERT INTO inv_equipments (equip_model, serial_no, category, added_by, reg_create, qr_code, location) 
                            VALUES (:equip_model, :serial_no, :type_name, :added_by, :reg_create, :qr_code, :location)";
    
            $insertStmt = $dbh->prepare($insertQuery);
            $insertStmt->bindParam(':equip_model', $equip_model);  
            $insertStmt->bindParam(':serial_no', $serial_no);
            $insertStmt->bindParam(':type_name', $type_name);
            $insertStmt->bindParam(':added_by', $added_by);
            $insertStmt->bindParam(':reg_create', $reg_create);
            $insertStmt->bindParam(':qr_code', $qr_code); 
            $insertStmt->bindParam(':location', $location);
         
            $insertStmt->execute();
    
            echo '<script>alert("Equipment Records Successfully Added");</script>';
            echo '<script>window.location = "add_equipment.php";</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .drop-zone {
        border: 2px dashed #ccc;
        padding: 5px;
        text-align: center;
        font-family: Arial, sans-serif;
        cursor: pointer;
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        overflow: hidden;
        position: relative;
        /* added */
    }

    .drop-zone p {
        color: gray;
    }

    .drop-zone input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .drop-zone:hover {
        background-color: #f5f5f5;
    }

    .drop-zone img {
        max-width: 100%;
        max-height: 100%;
    }

    .browse-label {
        color: blue;
        text-decoration: underline;
        cursor: pointer;
        font-size: 15px;
    }

    .qr-field {
        text-align: center;
    }

    .qr-image {
        width: 180px;
        height: 180px;

    }

    .qr_border {
        width: 200px;
        height: 200px;
        display: flex;
        justify-content: center;
        /* Horizontal centering */
        align-items: center;
        background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='black' stroke-width='5' stroke-dasharray='100' stroke-dashoffset='26' stroke-linecap='square'/%3e%3c/svg%3e");

    }
    </style>
</head>

<body>

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
                                <h4>Equipment Portal</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Equipment Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Add new Equipment</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" action="" enctype="multipart/form-data">
                            <section>
                                <div class="row justify-content-center">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <div class="drop-zone" id="drop-zone">
                                                <p>Drag image or</p>
                                                <label for="fileInput" class="browse-label">Browse</label>
                                                <input name="image" type="file" id="fileInput" accept="image/*"
                                                    onchange="handleFiles(this.files)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Serial No :</label>
                                            <input name="serial_no" type="text" id="item_serial"
                                                class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Equipment Model :</label>
                                            <input name="equip_model" type="text" class="form-control" required="true"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Category :</label>
                                            <select name="type_name" class="custom-select form-control" required="true"
                                                autocomplete="off">
                                                <option value="">Select Category</option>
                                                <?php
                                                $query = $dbh->query("SELECT * FROM inv_equipment_types");
													while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>

                                                <option value="<?php echo $row['type_name']; ?>">
                                                    <?php echo $row['type_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Date Created :</label>
                                            <input name="reg_create" type="text" class="form-control date-picker"
                                                required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>QR Code :</label>
                                            <div class="qr-field">
                                                <!-- Your QR code display -->
                                                <div class="qr_border">
                                                    <div id="qr_code" class="qr-image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>QR Code Value :</label>
                                            <p id="qr_text" class="form-control"></p>
                                            <button onclick="printQR()" class="btn btn-primary">Print QR Code</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label>Description :</label>
                                            <textarea id="textarea1" name="description" class="form-control" required
                                                length="150" maxlength="150" required="true"
                                                autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label style="font-size:16px;"><b></b></label>
                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-primary" name="add_equipment" id="add_equipment"
                                                    data-toggle="modal">Add Equipment</button>
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
    <!-- QRCode Library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        // Detect changes in the item_serial input field
        $('#item_serial').on('input', function() {
            var serialValue = $(this).val().trim(); // Get the trimmed value from the input
            if (serialValue !== '') { // Check if the value is not empty
                $('#qr_code').empty(); // Clear the QR code container
                var qr = new QRCode(document.getElementById("qr_code"), {
                    width: 180,
                    height: 180
                });
                qr.makeCode(serialValue); // Generate QR code based on the value
                $('#qr_text').text(serialValue); // Set the text below the QR code
            } else {
                $('#qr_code').empty(); // Clear the QR code container if the input is empty
                $('#qr_text').text(''); // Clear the text below the QR code
            }
        });
    });

    function printQR() {
        var printWindow = window.open('', '_blank');
        var qrImage = document.getElementById("qr_code").getElementsByTagName('img')[0].src;
        var qrCodeContent =
            '<html><head><title>QR Code</title></head><body><img src="' +
            qrImage + '"></body></html>';
        printWindow.document.write(qrCodeContent);
        printWindow.document.close();
        printWindow.print();
    }


    function generatePassword() {
        // Function to generate random password
        function generateRandomPassword(length = 8) {
            const characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let password = '';
            const max = characters.length - 1;

            for (let i = 0; i < length; i++) {
                password += characters.charAt(Math.floor(Math.random() * max));
            }

            return password;
        }

        const passwordInput = document.getElementById('password');
        const generatedPassword = generateRandomPassword(10); // Change the length if needed

        passwordInput.value = generatedPassword;
    }
    </script>
    <?php include('includes/scripts.php')?>
</body>

</html>