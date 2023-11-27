<?php
//  Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Connect to the database
require_once '../database/database.php';

global $customerList;
$customerList=[];

$query="SELECT Customer_ID, FirstName, LastName, Gender  FROM Customer";

$result = $conn->query($query);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 
        $customerList[]=$row;

        
    }

}



$conn->close();


