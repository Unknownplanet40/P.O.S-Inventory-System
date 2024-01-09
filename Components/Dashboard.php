<?php
session_start();

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
    <link rel="stylesheet" href="../Style/Sidebar.css" />
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
            <div class="container-xxl p-2" style=" overflow-y: scroll; overflow-x: hidden; height: 100vh;">
                <div class="row p-2 m-2">
                    <div class="col-md-8">
                        <div class="card border border-2 border-warning">
                            <div class="card-body">
                                <h5 class="card-title">Weekly Sales</h5>
                                <?php require_once '../Components/DashChart.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-2 border-warning" style="min-width: 300px;">
                            <div class="card-body">
                                <h5 class="card-title">Low Stock</h5>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Subheading</div>
                                            Content for list item
                                        </div>
                                        <span class="badge bg-primary rounded-pill">14</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Subheading</div>
                                            Content for list item
                                        </div>
                                        <span class="badge bg-primary rounded-pill">14</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Subheading</div>
                                            Content for list item
                                        </div>
                                        <span class="badge bg-primary rounded-pill">14</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>