<?php
//  Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL); 

include '../components/head.php';
include '../components/navbar.php';
require '../database/database.php';


$status = "";
$customerList=[];




if (isset($_POST["submit"])) {


    //Get values
    $firstName = $_POST["first-name"];
    $lastName = $_POST["last-name"];
    $gender = $_POST["gender"];



    //construct the query
    $query = "INSERT INTO Customer (FirstName, LastName, Gender) VALUES('$firstName','$lastName','$gender')";

    //Insert into customer table
    if ($conn->query($query) === TRUE) {
        $status = "Customer added successfully";

    } else {
        $status = "Error creating customer" . $conn->error;
    }
    
}

//Query to display customer list     
$selectQuery="SELECT Customer_ID, FirstName, LastName, Gender  FROM Customer";
    
$result = $conn->query($selectQuery);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 
        $customerList[]=$row;

        
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
                <li class="breadcrumb-item active">Create customer</li>
            </ol>

            <div class="card mb-4">

                <?php
                if ($status == "Customer added successfully") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successCreate">' . $status;
                    echo '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" >
                        </button>
                    </div>';
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="errorAlertCreate">' . $status;
                    echo '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" >
                        
                    </button>
                </div>';
                }
                ?>
                <script>
                    $(document).ready(function () {
                        $(".close").click(function () {
                            $("#successAlertCreate").alert("close");
                        });
                    });
                    $(document).ready(function () {
                        $(".close").click(function () {
                            $("#errorAlertCreate").alert("close");
                        });
                    });
                </script>


                <form class="m-3" action="" method="post">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="first-name"
                            aria-describedby="nameHelp">
                    </div>

                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last-name" name="last-name"
                            aria-describedby="nameHelp">
                    </div>



                    <div class="mb-3">
                        <div class="p-2 mb-3">Gender
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-f" value="F">
                                <label class="form-check-label" for="gender-f">
                                    F
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-m" value="M">
                                <label class="form-check-label" for="gender-m">
                                    M
                                </label>
                            </div>

                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>


        </div>

        <div class="card mb-4">

            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Customer List
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
                        <?php foreach ($customerList as $customer) { ?>
                            <tr>

                                <td>
                                    <?php echo $customer["Customer_ID"] ?>
                                </td>
                                <td>
                                    <?php echo $customer["FirstName"] ?>
                                </td>
                                <td>
                                    <?php echo $customer["LastName"] ?>
                                </td>
                                <td>
                                    <?php echo $customer["Gender"] ?>
                                </td>

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </main>

    <?php include '../components/footer.php'; ?>