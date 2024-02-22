<?php
include_once './Database/config.php';
session_start();

// every monday to sunday
$sql = "SELECT * FROM Transaction_History WHERE Date_Issued BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
$result = mysqli_query($conn, $sql);

$dates = array();
$amount = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['Date_Issued'];
    $amount[] = $row['Overall'];
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../Style/sidebars.css" />
    <script defer src="../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script defer src="../Script/sidebars.js"></script>
    <script defer src="../Script/chart.umd.js"></script>
    <script defer src="../Script/DashChart.js"></script>
    <Script>
        // cover whole page it the window is resized to mobile size
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768 && window.innerWidth <= 992) {
                document.getElementById('mainwindow').classList.add('d-none');
                document.getElementById('information').removeAttribute('hidden');
                document.getElementById('information').innerHTML = "You Can't View This Page on this Screen Size";
            } else {
                document.getElementById('mainwindow').classList.remove('d-none');
                document.getElementById('information').setAttribute('hidden', '');
            }
        });
    </Script>
    <style>
        .custom-active {
            background-color: #ffcd00 !important;
            color: #000 !important;
            font-weight: 600 !important;
        }
    </style>
</head>

<body>
    <div id="information" class="contailner-xxl text-center p-5" hidden>
        <h1 class="object-fit-contain"></h1>
    </div>
    <main class="d-flex flex-nowrap" id="mainwindow">
        <?php include_once '../assets/Icons.php'; ?>
        <?php require_once '../Components/LargeSidebar.php'; ?>
        <div class="container-xxl">
            <div class="container-xxl p-2" style=" overflow-y: auto; overflow-x: hidden; height: 100vh;">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col-md-8">
                        <div class="card border border-2 border-warning h-100">
                            <div class="card-body">
                                <h5 class="card-title">Weekly Sales Chart</h5>
                                <?php
                                $sql = "SELECT * FROM Transaction_History WHERE Date_Issued BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
                                $result = mysqli_query($conn, $sql);

                                $dates = array();
                                $amount = array();
                                $week = array();
                                $chartData = array_fill(0, 7, 0); // Initialize $chartData with zeros for each day

                                while ($row = mysqli_fetch_assoc($result)) {
                                    // remove the time and only get the date
                                    $currentDate = date('Y-m-d', strtotime($row['Date_Issued']));

                                    // if the date is already in the $dates array, add the amount
                                    if (in_array($currentDate, $dates)) {
                                        $index = array_search($currentDate, $dates);
                                        $amount[$index] += $row['Overall'];
                                    } else {
                                        // if the date is not in the $dates array, add it and the amount
                                        $dates[] = $currentDate;
                                        $amount[] = $row['Overall'];
                                    }
                                }

                                // get the day of the week for the date
                                foreach ($dates as $date) {
                                    $week[] = date('l', strtotime($date));
                                }

                                // aggregate the amounts based on the day of the week
                                for ($i = 0; $i < count($week); $i++) {
                                    switch ($week[$i]) {
                                        case 'Monday':
                                            $chartData[0] += $amount[$i];
                                            break;
                                        case 'Tuesday':
                                            $chartData[1] += $amount[$i];
                                            break;
                                        case 'Wednesday':
                                            $chartData[2] += $amount[$i];
                                            break;
                                        case 'Thursday':
                                            $chartData[3] += $amount[$i];
                                            break;
                                        case 'Friday':
                                            $chartData[4] += $amount[$i];
                                            break;
                                        case 'Saturday':
                                            $chartData[5] += $amount[$i];
                                            break;
                                        case 'Sunday':
                                            $chartData[6] += $amount[$i];
                                            break;
                                    }
                                }

                                // save the chart data to local storage
                                echo "<script>
                                // check if the chartData is already in the local storage
                                if (localStorage.getItem('chartData') === null) {
                                    localStorage.setItem('chartData', JSON.stringify(" . json_encode($chartData) . "))
                                } else {
                                    localStorage.removeItem('chartData');
                                    localStorage.setItem('chartData', JSON.stringify(" . json_encode($chartData) . "))
                                }</script>";
                                ?>
                                <?php include_once '../Components/DashChart.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-2 border-warning h-100" style="min-width: 300px;">
                            <div class="card-body">
                                <h5 class="card-title">Low Stock</h5>
                                <div class="container" style="overflow-y: auto; height: 305px;">
                                    <ol class="list-group list-group-numbered">
                                        <?php
                                        $sql = "SELECT * FROM pos_products WHERE isLowStock = 1";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                                        <div class='ms-2 me-auto'>
                                            <div class='fw-bold'>" . $row['product_name'] . "</div>";
                                            if ($row['CurrentStock'] <= 0) {
                                                echo "<span class='text-danger'>Out of Stock</span>";
                                            } else {
                                                echo "<span class='text-muted'>" . $row['CurrentStock'] . " left in stock</span>";
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" hidden>
                        <div class="card border border-2 border-warning h-100 p-0">
                            <div class="card-body">
                                <h5 class="card-title
                                ">Weekly Total Sales</h5>
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-center">
                                            <h6 class="text-muted">Sunday</h6>
                                            <h5 class="text-warning ">
                                                <?php
                                                echo "₱" . number_format($chartData[6], 2);
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted">Monday</h6>
                                            <h5 class="text-warning">
                                                <?php
                                                echo "₱" . number_format($chartData[0], 2);
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted">Tuesday</h6>
                                            <h5 class="text-warning">
                                                <?php
                                                echo "₱" . number_format($chartData[1], 2);
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted">Wednesday</h6>
                                            <h5 class="text-warning">
                                                <?php
                                                echo "₱" . number_format($chartData[2], 2);
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted">Thursday</h6>
                                            <h5 class="text-warning">
                                                <?php
                                                echo "₱" . number_format($chartData[3], 2);
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted">Friday</h6>
                                            <h5 class="text-warning">
                                                <?php
                                                echo "₱" . number_format($chartData[4], 2);
                                                ?>
                                            </h5>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card border border-2 border-warning h-100">
                            <div class="card-body">
                                <h5 class="card-title">Weekly Sales Summary</h5>
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-center">
                                            <h6 class="text-muted
                                            ">Total Sales</h6>
                                            <h3 class="text-bg-warning p-2 rounded">
                                                <?php
                                                $sql = "SELECT SUM(Overall) as TotalSales FROM Transaction_History WHERE Date_Issued BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);
                                                echo "₱" . number_format($row['TotalSales'], 2);
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted
                                            ">Average Sales</h6>
                                            <h3 class="text-bg-warning p-2 rounded">
                                                <?php
                                                $sql = "SELECT AVG(Overall) as AverageSales FROM Transaction_History WHERE Date_Issued BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);
                                                echo "₱" . number_format($row['AverageSales'], 2);
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-muted
                                            ">Total Transactions</h6>
                                            <h3 class="text-bg-warning p-2 rounded">
                                                <?php
                                                $sql = "SELECT COUNT(*) as TotalTransactions FROM Transaction_History WHERE Date_Issued BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);
                                                echo $row['TotalTransactions'];
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>