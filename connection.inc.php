<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
$con=mysqli_connect("localhost","root","","ecommerce")or die("Could not connect to database");
define('SITE_PATH','http://127.0.0.1/project/ecommerce/');



// Create a FULLTEXT index on the `description` column
// $query = "ALTER TABLE product ADD FULLTEXT(description)";
// $result = $con->query($query);

// if ($result) {
//     echo "FULLTEXT index created successfully.";
// } else {
//     echo "Error creating FULLTEXT index: " . $conn->error;
// }



?>
