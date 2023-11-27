<?php

 $servername = "localhost";
 $username = "root"; // your username
 $password = "root"; //your password
 $database = "travel_agency"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database); // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "<script>console.log('Connection Succesful!');</script>"; ;
}