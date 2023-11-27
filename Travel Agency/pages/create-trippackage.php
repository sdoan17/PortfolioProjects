<?php include '../components/head.php'; ?>
<?php include '../components/navbar.php'; ?>





<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Trip Packages</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Trip Package</li>
            </ol>

            <div class="card mb-4">
                <form class="m-3" action="processors/tripPackages-processor.php" method="post">
                    <div class="mb-3">
                        
                        <label for="first-name" class="form-label">Trip Destination ID</label>
                        <input type="text" class="form-control" id="location" name="location"
                            aria-describedby="nameHelp">
                    </div>

                    <div class="mb-3">
                        <label for="departure-date" class="form-label">Departure Date</label>
                        <select class="form-select" id="departure-date" name="departure-date" aria-describedby="nameHelp">
                            <?php
                            for ($i = 1; $i <= 100; $i++) {
                                $date = date('Y-m-d', strtotime("+" . $i . " days"));
                                $formattedDate = date('F d, Y', strtotime("+" . $i . " days"));
                                echo "<option value='$date'>$formattedDate</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="return-date" class="form-label">Return Date</label>
                        <select class="form-select" id="return-date" name="return-date" aria-describedby="lastnameHelp">
                            <?php
                            for ($i = 8; $i <= 200; $i++) {
                                $date = date('Y-m-d', strtotime("+" . $i . " days"));
                                $formattedDate = date('F d, Y', strtotime("+" . $i . " days"));
                                echo "<option value='$date'>$formattedDate</option>";
                            }
                            ?>
                        </select>
                    </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>


        </div>
    </main>


    <?php include '../components/footer.php'; ?>