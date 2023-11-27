<?php

// For question number 4 in milestone 5

// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to the database
require '../database/database.php';

// Create array
global $travelAgents;
$travelAgents = [];

// Construct the query to find travel agents who assist all customers
$query = " SELECT TA.AgentID, TA.FirstName, TA.LastName
    FROM TravelAgents_Assist TA
    WHERE NOT EXISTS (
        SELECT C.Customer_ID
        FROM Customer C
        WHERE NOT EXISTS (
            SELECT *
            FROM TravelAgent_That_Assists_Customer_Offers TACO
            WHERE TACO.AgentID = TA.AgentID
            AND TACO.CustomerID = C.Customer_ID
        )
    )
";

// Execute the query
$result = $conn->query($query);

// Display the results
if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $travelAgents[] = $row;
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
                <li class="breadcrumb-item active">Agents that assist all customers</li>
            </ol>

            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Agents that assist all customers
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Agent ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Agent ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($travelAgents as $agent) { ?>
                                <tr>
                                    <td><?php echo $agent["AgentID"]; ?></td>
                                    <td><?php echo $agent["FirstName"]; ?></td>
                                    <td><?php echo $agent["LastName"]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include '../components/footer.php'; ?>
