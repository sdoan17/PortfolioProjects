<?php

// For question number 8 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../components/head.php';
include '../components/navbar.php';

// Connect to the database
require '../database/database.php';

$updatedTripPackage=[];
$status = "";



if (isset($_POST["submitted"])) {
    $idToUpdate= $_POST["ID-to-update"];
    $newDepartureDate= $_POST["departure-date"];
    $newReturnDate= $_POST["return-date"];

    //construct the query
    $query = "UPDATE TripPackage SET DepartureDate='$newDepartureDate', ReturnDate='$newReturnDate' WHERE TripPackID=$idToUpdate";

      //Update Trip Package
      if ($conn->query($query) === TRUE) {
        $status = "Date updated successfully";

    } else {
        $status = "Error updating date" . $conn->error;
    }

}
//Query to display Trip Package    
$selectQuery="SELECT * FROM TripPackage";
    
$result = $conn->query($selectQuery);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 
        $updatedTripPackage[]=$row;

        
    }

}


$conn->close();

?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Trip Package</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Update a Trip Package</li>
            </ol>

            <div class="card mb-4">
            <?php
                if ($status == "Date updated successfully") {

                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlertDelete">' . $status.'for ID '.$idToUpdate;
                    echo '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" >
                        </button>
                    </div>';
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="errorAlertDelete">' . $status;
                    echo '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" >
                        
                    </button>
                </div>';
                }
                ?>
                <script>
                    $(document).ready(function () {
                        $(".close").click(function () {
                            $("#successAlertUpdate").alert("close");
                        });
                    });
                    $(document).ready(function () {
                        $(".close").click(function () {
                            $("#errorAlertUpdate").alert("close");
                        });
                    });
                </script>

                <form class="m-3 d-flex flex-column" method="POST" action="">
            
                    <label for="ID-to-delete" class="form-label">Enter Trip Package ID to update</label>
                        <input type="text" class="form-control" id="ID-to-update" name="ID-to-update"
                            aria-describedby="nameHelp">
                    </label>
                    <div class="my-3">
                
                        <label>Departure date </label>
                        <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                            <input class="form-control position-relative" type="text" name="departure-date" id="departure-date" readonly />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>

                        <div class="my-3">
                
                        <label>Return date </label>
                        <div id="datepicker2" class="input-group date" data-date-format="yyyy-mm-dd">
                            <input class="form-control position-relative" type="text" name="return-date" id="return-date" readonly />
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>

                        <script>
                            $(function () {
                                $("#datepicker").datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    todayHighlight: true,
                                }).datepicker('update', new Date());
                            }); 
                            $(function () {
                                $("#datepicker2").datepicker({
                                    autoclose: true,
                                    format: 'yyyy-mm-dd',
                                    todayHighlight: true,
                                }).datepicker('update', new Date());
                            }); 
                        </script>
                        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                            crossorigin="anonymous">
                            </script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
                            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                            crossorigin="anonymous">
                            </script>
                        <script
                            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
                            </script>
                    </div>

                    

                    <div>
                        <button type="submit" name="submitted" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card mb-4">

                

            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Trip Package
            </div>

            <div class="card-body">


                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>TripPackID</th>
                            <th>Departure Date</th>
                            <th>Return Date</th>
                            

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <th>TripPackID</th>
                            <th>Departure Date</th>
                            <th>Return Date</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($updatedTripPackage as $updatedTrip) { ?>
                            <tr>

                                <td>
                                    <?php echo $updatedTrip["TripPackID"] ?>
                                </td>
                                <td>
                                    <?php echo $updatedTrip["DepartureDate"] ?>
                                </td>
                                <td>
                                    <?php echo $updatedTrip["ReturnDate"] ?>
                                </td>
                

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </main>




    <?php include '../components/footer.php'; ?>