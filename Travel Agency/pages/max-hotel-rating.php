<?php

// For question number 5 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to the database
require '../database/database.php';

// Create an array to store hotel details
$highestRatedHotel = [];

// Construct the query to find the hotel with the maximum rating
$query = "SELECT * FROM Hotel WHERE Rating = (SELECT MAX(DISTINCT Rating) FROM Hotel)";

// Execute the query
$result = $conn->query($query);

// Fetch the result
if ($result->num_rows > 0) {
    // Fetch a single row
    $highestRatedHotel = $result->fetch_assoc();
}

// Close the database connection
$conn->close();
?>

<?php include '../components/head.php'; ?>
<?php include '../components/navbar.php'; ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Highest Rated Hotel</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Highest Rated Hotel</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-hotel me-1"></i>
                    Highest Rated Hotel
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Hotel ID</th>
                                <th>Hotel Name</th>
                                <th>Hotel Location</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Hotel ID</th>
                                <th>Hotel Name</th>
                                <th>Hotel Location</th>
                                <th>Rating</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td><?php echo $highestRatedHotel["HotelID"] ?></td>
                                <td><?php echo $highestRatedHotel["HotelName"] ?></td>
                                <td><?php echo $highestRatedHotel["HotelLocation"] ?></td>
                                <td><?php echo $highestRatedHotel["Rating"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include '../components/footer.php'; ?>
