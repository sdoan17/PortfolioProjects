<?php include '../components/head.php'; ?>
<?php include '../components/navbar.php'; ?>
<?php require './processors/customer-list-processor.php'; ?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Customer</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Customer List</li>
            </ol>
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


        </div>


    </main>




    <?php include '../components/footer.php'; ?>