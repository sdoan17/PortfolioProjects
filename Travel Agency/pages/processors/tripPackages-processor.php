<?php
// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to the database
require '../../database/database.php';

// Get values from the form
$tripDestinationID = $_POST["location"];
$departureDate = $_POST["departure-date"];
$returnDate = $_POST["return-date"];


// It needs to be TripPack ID, there is no destination 
// Construct the query
$query = "INSERT INTO TripPackage (TripPackID, DepartureDate, ReturnDate) VALUES ('$tripDestinationID', '$departureDate', '$returnDate')";
// Execute the query
if ($conn->query($query) === TRUE) {
    echo "Trip package created successfully!";
} else {
    echo "Error creating trip package: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
