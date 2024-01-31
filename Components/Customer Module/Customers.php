<?php
include_once '../Database/config.php';
session_start();


?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Customer Information Management System" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />


    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../../DataTables/css/DataTableCombined.css" />
    <link rel="stylesheet" href="../../Style/SA2-BS4.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />

    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>

    <script defer src="../../DataTables/js/DataTableCombined.js"></script>
    <script defer src="../../DataTables/js/pdfmake.js"></script>
    <script defer src="../../DataTables/js/vfs_fonts.js"></script>
    <script defer src="../../Script/Customers.js"></script>

    <title>Customer Information</title>
    <?php include_once '../../assets/Icons.php'; ?>
</head>

<style>
    * {
        box-sizing: border-box;
        scroll-behavior: smooth;
    }

    body {
        min-width: 792px;
    }

    [data-bs-theme=dark] {
        --txtColor: #fff;
    }

    [data-bs-theme=light] {
        --txtColor: #000;
    }

    .custom-active {
        background-color: #ffcd00 !important;
        color: #000 !important;
        font-weight: 600 !important;
    }

    .custom-brown {
        background-color: #a8342d !important;
        color: #f5f5f5 !important;
        font-weight: 600 !important;
    }

    .custom-brown:hover {
        background-color: #f54d42 !important;
        color: #f5f5f5 !important;
        font-weight: 600 !important;
    }

    .swal2-timer-progress-bar {
        background-color: #ffcd00 !important;
    }

    .bgimage {
        background-image: url('../../assets/cardBG.svg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-bottom-left-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    td {
        vertical-align: middle !important;
    }

    .fillup {
        width: 100%;
        height: 100%;
        opacity: 0.9;
        position: fixed;
    }

    .fillup h1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* make font  */

    .parent {
        display: grid;
        grid-template-columns: 4.5rem 1fr;
        grid-template-rows: 1fr;
        grid-column-gap: 0px;
        grid-row-gap: 0px;
    }

    .div1 {
        grid-area: 1 / 1 / 2 / 2;
    }

    .div2 {
        grid-area: 1 / 2 / 2 / 3;
    }

    [type="search"][aria-controls="example"] {
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        box-shadow: none;
        min-width: 350px !important;
        height: 35px !important;
    }

    [type="search"][aria-controls="example"]:focus {
        outline: none;
        box-shadow: none;
        border-color: #ffcd00;
    }

    [type="search"][aria-controls="example"]::placeholder {
        color: #6e3b3b;
        font-size: 0.875rem;
        font-weight: 400;
        padding-left: 1.375rem;
        background-image: url('../../assets/search.svg');
        background-repeat: no-repeat;
        background-position: center left;
    }

    .loader {
        outline: 1px solid #ddd;
        width: 120px;
        height: 150px;
        background-color: #fff;
        background-repeat: no-repeat;
        background-image: linear-gradient(#ddd 50%, #bbb 51%),
            linear-gradient(#ddd, #ddd), linear-gradient(#ddd, #ddd),
            radial-gradient(ellipse at center, #aaa 25%, #eee 26%, #eee 50%, #0000 55%),
            radial-gradient(ellipse at center, #aaa 25%, #eee 26%, #eee 50%, #0000 55%),
            radial-gradient(ellipse at center, #aaa 25%, #eee 26%, #eee 50%, #0000 55%);
        background-position: 0 20px, 45px 0, 8px 6px, 55px 3px, 75px 3px, 95px 3px;
        background-size: 100% 4px, 1px 23px, 30px 8px, 15px 15px, 15px 15px, 15px 15px;
        position: relative;
        border-radius: 6%;
        animation: shake 3s ease-in-out infinite;
        transform-origin: 60px 180px;
    }

    .loader:before {
        content: "";
        position: absolute;
        left: 5px;
        top: 100%;
        width: 7px;
        height: 5px;
        background: #aaa;
        border-radius: 0 0 4px 4px;
        box-shadow: 102px 0 #aaa;
    }

    .loader:after {
        content: "";
        position: absolute;
        width: 95px;
        height: 95px;
        left: 0;
        right: 0;
        margin: auto;
        bottom: 20px;
        background-color: #bbdefb;
        background-image:
            linear-gradient(to right, #0004 0%, #0004 49%, #0000 50%, #0000 100%),
            linear-gradient(135deg, #64b5f6 50%, #607d8b 51%);
        background-size: 30px 100%, 90px 80px;
        border-radius: 50%;
        background-repeat: repeat, no-repeat;
        background-position: 0 0;
        box-sizing: border-box;
        border: 10px solid #DDD;
        box-shadow: 0 0 0 4px #999 inset, 0 0 6px 6px #0004 inset;
        animation: spin 3s ease-in-out infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg)
        }

        50% {
            transform: rotate(360deg)
        }

        75% {
            transform: rotate(750deg)
        }

        100% {
            transform: rotate(1800deg)
        }
    }

    @keyframes shake {

        65%,
        80%,
        88%,
        96% {
            transform: rotate(0.5deg)
        }

        50%,
        75%,
        84%,
        92% {
            transform: rotate(-0.5deg)
        }

        0%,
        50%,
        100% {
            transform: rotate(0)
        }
    }
</style>

<body>
    <div class="parent">
        <div class="div1">
            <?php require_once '../SmallSidebar.php'; ?>
            <?php
            if (isset($_SESSION['message'])) {
            ?>
                <script>
                    Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    }).fire({
                        icon: 'success',
                        title: '<?php echo $_SESSION['message']; ?>'
                    })
                </script>
            <?php
                unset($_SESSION['message']);
            }
            ?>
        </div>
        <div class="div2">
            <div class="position-fixed fillup d-flex justify-content-center align-items-center
            " id="spinner">
                <span class="loader"></span>
            </div>
            <main class="container-xxl d-none" id="main">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="Add Customer" data-bs-toggle="modal" data-bs-target="#NewCustomerModal" style="cursor: pointer;">&#10133; Add Customer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="Recover Deleted Data" data-bs-toggle="modal" data-bs-target="#NewCustomerModal" style="cursor: pointer;">&#128465; Archived</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle active" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" style="color: #a8342d;" id="btn-excel" hidden>
                                                <svg class="bi pe-none" width="16" height="16" role="img" aria-label="Export to Excel">
                                                    <use xlink:href="#excel" />
                                                </svg> Excel
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" style="color: #a8342d;" id="btn-pdf">
                                                <svg class="bi pe-none" width="16" height="16" role="img" aria-label="Export to PDF">
                                                    <use xlink:href="#pdf" />
                                                </svg> PDF
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" style="color: #a8342d;" id="btn-print">
                                                <svg class="bi pe-none" width="16" height="16" role="img" aria-label="Print">
                                                    <use xlink:href="#print" />
                                                </svg> Print
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="modal fade" id="Details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body">
                                <div class="card text-center border-1">
                                    <div class="card-header">
                                        INFORMATION
                                    </div>
                                    <div class="card-body">
                                        <div class="row row-cols-1 row-cols-md-2 g-4">
                                            <div class="col-sm-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form method="POST" id="form">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="name" placeholder="Customer Name" disabled>
                                                                <label for="name">Customer Name</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control" id="Contact" placeholder="Customer Contact" disabled>
                                                                <label for="Contact">Customer Contact<sup class="text-danger">*</sup></label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <textarea class="form-control" placeholder="Customer Comments" id="address" disabled style="height: auto; min-height: 100px;"></textarea>
                                                                <label for="address">Customer Address<sup class="text-danger">*</sup></label>
                                                            </div>
                                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                <div class="form-check form-switch my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Switch to Edit Information">
                                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                                </div>
                                                                <button class="btn btn-sm btn-primary" type="submit" id="sub" disabled>Save Changes</button>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            document.getElementById("flexSwitchCheckDefault").addEventListener("click", function() {
                                                                if (document.getElementById("flexSwitchCheckDefault").checked == true) {
                                                                    document.getElementById("name").disabled = false;
                                                                    document.getElementById("Contact").disabled = false;
                                                                    document.getElementById("address").disabled = false;
                                                                    document.getElementById("sub").disabled = false;
                                                                } else {
                                                                    document.getElementById("name").disabled = true;
                                                                    document.getElementById("Contact").disabled = true;
                                                                    document.getElementById("address").disabled = true;
                                                                    document.getElementById("sub").disabled = true;
                                                                }
                                                            })

                                                            document.getElementById("form").addEventListener("submit", function(e) {
                                                                e.preventDefault();
                                                                var name = document.getElementById("name").value;
                                                                var contact = document.getElementById("Contact").value;
                                                                var address = document.getElementById("address").value;

                                                                if (contact == "" || address == "") {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Oops...',
                                                                        text: 'Please Fill Up Some Fields!',
                                                                    })
                                                                } else if (contact.length < 11 || contact.length > 11) {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Oops...',
                                                                        text: 'Please Enter a Valid Contact Number!',
                                                                    })
                                                                } else {
                                                                    Swal.fire({
                                                                        title: 'Are you sure?',
                                                                        text: "This will update the customer information!",
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#3085d6',
                                                                        cancelButtonColor: '#d33',
                                                                        confirmButtonText: 'Yes, save changes!'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            const form = document.getElementById('form');
                                                                            form.action = "./UpdateCustomer.php";
                                                                            form.submit();
                                                                        }
                                                                    })
                                                                }
                                                            })

                                                            //konami code
                                                            var keys = [];
                                                            // up up down down left right left right b a
                                                            var konami = '38,38,40,40,37,39,37,39,66,65';
                                                            window.addEventListener("keydown", function(e) {
                                                                keys.push(e.keyCode);
                                                                console.log(keys.toString());
                                                                if (keys.toString().indexOf(konami) >= 0) {
                                                                    var audio = new Audio('../../assets/Audio/incoming_message.wav');
                                                                    audio.play();
                                                                    Swal.fire({
                                                                        title: 'Konami Code Activated!',
                                                                        text: 'You have unlocked a secret feature!',
                                                                        imageUrl: '../../assets/Secret.gif',
                                                                        imageWidth: 128,
                                                                        imageAlt: 'Custom image',
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            document.getElementById("btn-excel").hidden = false;
                                                                        } else {
                                                                            document.getElementById("btn-excel").hidden = true;
                                                                        }
                                                                    })
                                                                    keys = [];
                                                                }
                                                            }, true);
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="card border-0">
                                                    <p class="text-muted my-1">Return Frequencies</p>
                                                    <div class="row row-cols-1 row-cols-md-1 g-4">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body bgimage">
                                                                    <h5 class="card-title">This Week</h5>
                                                                    <h5 class="card-title text-center fs-1" id="Week"></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body bgimage">
                                                                    <h5 class="card-title">This Month</h5>
                                                                    <h5 class="card-title text-center fs-1" id="Month"></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <span class="text-muted" id="date"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-xxl py-3">
                    <div class="row">
                        <div class="col-12">
                            <table id="example" class="table table-striped table-hover table-sm table-responsive" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Contact</th>
                                        <th>Customer Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $sql = "SELECT * FROM customer_information WHERE Archived = 0";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr style="cursor: pointer;">
                                                <td><?php echo $row['Cust_ID']; ?></td>
                                                <td><?php echo $row['Cust_first_name']; ?> <?php echo $row['Cust_last_name']; ?></td>
                                                <td><?php echo $row['Cust_number']; ?></td>
                                                <td><?php echo $row['Cust_Address']; ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Details" id="Row<?php echo $row['Cust_ID']; ?>">&#9998; Details</button>
                                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0) { ?>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" id="del<?php echo $row['Cust_ID']; ?>">&#10006; Delete</button>
                                                    <?php } else { ?>
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="You don't have permission to delete this record.">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="del<?php echo $row['Cust_ID']; ?>" disabled>&#10006; Delete</button>
                                                        </span>
                                                    <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script>
                                                document.getElementById("Row<?php echo $row['Cust_ID']; ?>").addEventListener("click", function() {
                                                    var dateStr = "<?php echo $row['Date']; ?>";
                                                    var date = new Date(dateStr);

                                                    // Array of day names
                                                    var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                                                    // Format the date components
                                                    var month = date.toLocaleString('en-US', {
                                                        month: 'long'
                                                    });
                                                    var day = date.getDate();
                                                    var year = date.getFullYear();
                                                    var hour = date.getHours();
                                                    var minute = date.getMinutes();
                                                    var second = date.getSeconds();
                                                    var ampm = hour >= 12 ? 'PM' : 'AM';

                                                    // Format the complete date string
                                                    var formattedDate = month + ' ' + day + ', ' + year + ' ' + daysOfWeek[date.getDay()] + ' at ' +
                                                        hour % 12 + ':' + (minute < 10 ? '0' : '') + minute + ':' + (second < 10 ? '0' : '') + second + ' ' + ampm;

                                                    console.log(formattedDate);

                                                    document.getElementById("date").innerHTML = "Last Updated: " + formattedDate;
                                                    document.getElementById("name").value = "<?php echo $row['Cust_first_name']; ?> <?php echo $row['Cust_last_name']; ?>";
                                                    document.getElementById("Contact").value = "<?php echo $row['Cust_number']; ?>";
                                                    document.getElementById("address").value = "<?php echo $row['Cust_Address']; ?>";
                                                    document.getElementById("Week").innerHTML = "<?php echo $row['Week']; ?>";
                                                    document.getElementById("Month").innerHTML = "<?php echo $row['Month']; ?>";
                                                })

                                                document.getElementById("del<?php echo $row['Cust_ID']; ?>").addEventListener("click", function() {
                                                    var id = "<?php echo $row['Cust_ID']; ?>";

                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You won't be able to revert this!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, delete it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "./DelCustomer.php?id=" + id;
                                                        }
                                                    })
                                                })
                                            </script>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>