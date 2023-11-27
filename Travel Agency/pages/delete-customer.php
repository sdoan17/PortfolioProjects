<?php

// For question number 7 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../components/head.php';
include '../components/navbar.php';

// Connect to the database
require '../database/database.php';

$updatedCustomerList=[];
$status = "";



if (isset($_POST["ID-to-delete"])) {
    $idToDelete = $_POST["ID-to-delete"];

    //construct the query
    $query = "DELETE FROM Customer WHERE Customer_ID=$idToDelete";

      //Delete from customer table
      if ($conn->query($query) === TRUE) {
        $status = "Customer deleted successfully";

    } else {
        $status = "Error deleting customer" . $conn->error;
    }

}
//Query to display customer list     
$selectQuery="SELECT Customer_ID, FirstName, LastName, Gender  FROM Customer";
    
$result = $conn->query($selectQuery);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 
        $updatedCustomerList[]=$row;

        
    }

}


$conn->close();

?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Customer</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Delete a Customer</li>
            </ol>

            <div class="card mb-4">
            <?php
                if ($status == "Customer deleted successfully") {

                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlertDelete">' . $status;
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
                            $("#successAlertDelete").alert("close");
                        });
                    });
                    $(document).ready(function () {
                        $(".close").click(function () {
                            $("#errorAlertDelete").alert("close");
                        });
                    });
                </script>



                <form class="m-3 d-flex flex-column" method="POST" action="">
            
                    <label for="ID-to-delete" class="form-label">Enter a CustomerID to delete</label>
                        <input type="text" class="form-control" id="ID-to-delete" name="ID-to-delete"
                            aria-describedby="nameHelp">
                    </label>

                    <div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card mb-4">

                

            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Updated Customer List
            </div>

            <div class="card-body">


                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Costumer ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Costumer ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($updatedCustomerList as $updatedTrip) { ?>
                            <tr>

                                <td>
                                    <?php echo $updatedTrip["Customer_ID"] ?>
                                </td>
                                <td>
                                    <?php echo $updatedTrip["FirstName"] ?>
                                </td>
                                <td>
                                    <?php echo $updatedTrip["LastName"] ?>
                                </td>
                                <td>
                                    <?php echo $updatedTrip["Gender"] ?>
                                </td>

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </main>




    <?php include '../components/footer.php'; ?>