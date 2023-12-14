<?php include('includes/header.php')?>
<?php include('../includes/session.php')?>

<?php 
	 if (isset($_GET['delete'])) {
		$department_id = $_GET['delete'];
		$sql = "DELETE FROM tbldepartments where id = ".$department_id;
		$result = mysqli_query($conn, $sql);
		if ($result) {
			echo "<script>alert('Department deleted Successfully');</script>";
     		echo "<script type='text/javascript'> document.location = 'department.php'; </script>";
			
		}
	}
?>

<?php
if (isset($_POST['add'])) {
    $type_name = $_POST['type_name'];
    $description = $_POST['description'];
    $admin_emp_id = $session_id; // Assuming $session_id holds the admin's ID

    $stmt = $dbh->prepare("SELECT * FROM inv_equipment_types WHERE type_name = :type_name");
    $stmt->bindParam(':type_name', $type_name);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
        echo "<script>alert('Category Already exists');</script>";
    } else {
        $stmt2 = $dbh->prepare("SELECT first_name FROM hr_employees WHERE emp_id = :admin_emp_id");
        $stmt2->bindParam(':admin_emp_id', $admin_emp_id);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($result2) {
            $first_name = $result2['first_name'];
        }

        $create_at = date("Y-m-d H:i:s"); // Get the current date and time

        $stmt = $dbh->prepare("INSERT INTO inv_equipment_types (type_name, description, created_at, added_by) VALUES (:type_name, :description, :create_at, :first_name)");
        $stmt->bindParam(':type_name', $type_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_at', $create_at);
        $stmt->bindParam(':first_name', $first_name);

        if ($stmt->execute()) {
            echo "<script>alert('Category Added Successfully');</script>";
            echo "<script type='text/javascript'> document.location = 'equipment_category.php'; </script>";
        } else {
            echo "<script>alert('Error adding category');</script>";
        }
    }
}
?>

<style>
.description-cell {
    max-width: 200px;
    /* Adjust the width as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    word-wrap: break-word;
    /* For older browsers */
}
</style>

<body>

    <?php include('includes/navbar.php')?>

    <?php include('includes/right_sidebar.php')?>

    <?php include('includes/left_sidebar.php')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Equipment Category List</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Category Module</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">New Equipment Category</h2>
                            <section>
                                <form name="save" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input name="type_name" type="text" class="form-control" required="true"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea id="textarea1" name="description" class="form-control"
                                                    required length="150" maxlength="150" required="true"
                                                    autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                        <div class="dropdown">
                                            <input class="btn btn-primary" type="submit" value="Save" name="add"
                                                id="add">
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <h2 class="mb-30 h4">Department List</h2>
                            <div class="pb-20">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID.</th>
                                            <th class="table-plus">CATEGORY NAME</th>
                                            <th>DESCRIPTION</th>
                                            <th>DATE CREATED</th>
                                            <th>ADDED BY</th>
                                            <th class="datatable-nosort">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $sql = "SELECT * from inv_equipment_types";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>

                                        <tr>
                                            <td> <?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($result->type_name);?></td>
                                            <td class="description-cell">
                                                <?php echo htmlentities($result->description);?></td>
                                            <td><?php
                                                $date = new DateTime($result->created_at);
                                                echo htmlentities($date->format('Y-m-d'));
                                                ?></td>
                                            <td><?php echo htmlentities($result->added_by);?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="edit_department.php?edit=<?php echo htmlentities($result->id);?>"
                                                        data-color="#265ed7"><i class="icon-copy dw dw-edit2"></i></a>
                                                    <a href="department.php?delete=<?php echo htmlentities($result->id);?>"
                                                        data-color="#e95959"><i
                                                            class="icon-copy dw dw-delete-3"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php $cnt++;} }?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
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