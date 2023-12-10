<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $selectedCity = $_GET['city'];

    // Simulating fetching barangays from the database based on the selected city
    // Perform your SQL query here to get barangays associated with the selected city

    // For demonstration purposes, creating a sample array of barangays
    // Replace this section with actual database query results
    $barangays = [];

    // Sample data for demonstration (replace with your query results)
    if ($selectedCity === 'City A') {
        $barangays = [
            ['id' => 1, 'name' => 'Barangay A1'],
            ['id' => 2, 'name' => 'Barangay A2'],
            // Add more barangays associated with City A...
        ];
    } elseif ($selectedCity === 'City B') {
        $barangays = [
            ['id' => 3, 'name' => 'Barangay B1'],
            ['id' => 4, 'name' => 'Barangay B2'],
            // Add more barangays associated with City B...
        ];
    }
    // Add more conditions for other cities if needed...

    // Returning barangays data as JSON
    echo json_encode($barangays);
}
?>
