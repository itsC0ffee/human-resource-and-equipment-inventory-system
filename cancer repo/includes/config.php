<?php



$host = "host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres user=postgres password=sbit4e-4thyear-capstone-2023";

try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}




?>