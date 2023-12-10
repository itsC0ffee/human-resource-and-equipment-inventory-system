<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchQuery = $_GET['query'];

    // Perform search query
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "doh";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT first_name, last_name, department, emp_id FROM hr_employees WHERE first_name LIKE '%$searchQuery%' OR last_name LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    $data = []; // Initialize an empty array

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Concatenate first_name and last_name
            $fullName = $row["first_name"] . ' ' . $row["last_name"];

            $data[] = [
                'FullName' => $fullName,
                'department' => $row["department"],
                'emp_id' => $row["emp_id"]
            ];
        }
    }

    echo json_encode($data); // Convert the array to JSON format and echo it
    $conn->close();
}
?>
