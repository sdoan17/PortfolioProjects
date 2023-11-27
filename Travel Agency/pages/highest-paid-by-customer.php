<?php

// For question number 6 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to the database
require '../database/database.php';

// Create a variable to store the first name of the customer with the highest amount paid
// $highestPaidCustomerFirstName = '';
$highestPaidCustomer = [];

// Construct the query to find the first name of the customer with the highest amount paid
$query = "SELECT Customer.FirstName, Customer.LastName,Has_Booking.AmountPaid 
        FROM Customer
        JOIN Has_Booking ON Customer.Customer_ID = Has_Booking.CustomerID
        WHERE Has_Booking.AmountPaid >= ALL (
            SELECT MAX(distinct AmountPaid)
            FROM Has_Booking
            GROUP BY CustomerID
        )";

// Execute the query to find the first name of the customer with the highest amount paid
$result = $conn->query($query);

// Fetch the result to get the first name of the customer with the highest amount paid
if ($result->num_rows > 0) {
    // $row = $result->fetch_assoc();
    // $highestPaidCustomerFirstName = $row['FirstName'];
    while($row = $result->fetch_assoc()) {
 
        $highestPaidCustomer[]=$row;

        
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
            <h1 class="mt-4">Customer</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Customer with Highest Amount Paid</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Customer with Highest Amount Paid
                </div>
                <div class="card-body">
                <?php foreach ($highestPaidCustomer as $customer) { ?>
                    <ul>
                    <li>Customer name: <?php echo $customer["FirstName"].' '.$customer["LastName"]; ?></li>
                    <li>Amount paid: $<?php echo $customer["AmountPaid"]; ?></li>
                    </ul>
                    <?php } ?>

                </div>
            </div>
        </div>
    </main>

    <?php include '../components/footer.php'; ?>
