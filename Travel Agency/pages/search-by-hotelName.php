<?php

// For question number 2 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to the database
require '../database/database.php';

//Create array
global $hotels;
$hotels = [];
if (isset($_POST["submit"])) {
    //Connect to the database
// Get the location from the form
$hotel_name = $_POST["name"];

// Construct the query
$query = "SELECT * FROM Hotel WHERE HotelName LIKE '%$hotel_name%'";

// Execute the query
$result = $conn->query($query);

// Display the results
if ($result->num_rows > 0) {
    echo "<h2>Search Results</h2>";
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
        
    }
} 

}


// Close the database connection
$conn->close();
?>



<?php include '../components/head.php'; ?>
<?php include '../components/navbar.php'; ?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Hotel Name</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Search for Hotel Name</li>
            </ol>

            <div class="card mb-4">
                <form class="m-3" action="search-by-hotelName.php" method="post">
                    <div class="mb-3">
                        <label for="table" class="form-label">Hotel Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            aria-describedby="lastnameHelp">
                    </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>

            </div>

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List results
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
                            <?php foreach ($hotels as $hotel) { ?>
                                <tr>
                           
                                    <td>
                                        <?php echo $hotel["HotelID"] ?>
                                    </td>
                                    <td>
                                        <?php echo $hotel["HotelName"] ?>
                                    </td>
                                    <td>
                                        <?php echo $hotel["HotelLocation"] ?>
                                    </td>
                                    <td>
                                        <?php echo $hotel["Rating"] ?>
                                    </td>
                                  

                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>


    <?php include '../components/footer.php'; ?>