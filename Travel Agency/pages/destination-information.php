<?php

// For question number 1 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../components/head.php';
include '../components/navbar.php';

// Connect to the database
require '../database/database.php';


$destinationInfo = [];
$selectedColumn = '';

if (isset($_POST["selectColumn"])) {
    $selectedColumn = $_POST["selectColumn"];

    $query = "SELECT $selectedColumn FROM Destination";

    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $destinationInfo[] = $row;

        }

    } else {
        echo "error";
    }

}


$conn->close();


?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Destination</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Destination Information</li>
            </ol>


            <div class="card mb-4">
                <form class="m-3 d-flex flex-column" method="POST" action="">
                    <label>Select a column from the Destination table
                        <select class="form-select form-select-md mb-3" aria-label="Select column to display"
                            name="selectColumn">
                            <option value="DestinationID">Destination ID</option>
                            <option value="Reviews">Reviews</option>
                            <option value="Country">Country</option>
                            <option value="City">City</option>
                            <option value="LocationName">Location Name</option>
                        </select>
                    </label>

                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Destination Information
                </div>

                <div class="card-body">


                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>
                                    <?php if (isset($_POST["selectColumn"])) {
                                        echo $selectedColumn;

                                    } else {
                                        echo 'Selected column';

                                    } ?>
                                </th>


                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>
                                    <?php if (isset($_POST["selectColumn"])) {
                                        echo $selectedColumn;
                                    } else {
                                        echo 'Selected column';
                                    } ?>
                                </th>

                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($destinationInfo as $destination) { ?>
                                <tr>

                                    <td>
                                        <?php echo $destination["$selectedColumn"] ?>
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