<?php
include_once '../Database/config.php';
session_start();
include_once './FetchDatas.php';

// fist check if the user is logged in
if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 0) {
    getCustomerinfo();
    getItem();
} else {
    $_SESSION['statusNotif'] = "Not Logged In";
    $_SESSION['ColorCode'] = "Text-dark";
    header("Location: ../Login Module/LoginPage.php");
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Point of Sale Module" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />
    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../../Style/SA2-BS4.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />
    <link rel="stylesheet" href="../../Style/POS_Style.css" />
    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.min.js"></script>
    <script defer src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>
    <script defer src="../../Script/POS_Main.js"></script>
    <title>Point of Sales</title>
    <?php include_once '../../assets/Icons.php'; ?>
    <style>
        .custom-active {
            background-color: #ffcd00 !important;
            color: #000 !important;
            font-weight: 600 !important;
        }

        .swal2-timer-progress-bar {
            background-color: #ffcd00 !important;
        }
    </style>
</head>

<body>
    <main class="d-flex flex-nowrap">
        <?php require_once '../SmallSidebar.php'; ?>
        <div class="container-xxl">
            <div class="row g-2 py-2">
                <div class="col-md-8">
                    <div class="container-xxl shadow border border-warning rounded">
                        <nav>
                            <div class="nav nav-tabs mt-1 " id="nav-tab" role="tablist">
                                <style>
                                    .nav-link.active {
                                        background-color: #ffcd00 !important;
                                        color: #a8342d !important;
                                        font-weight: 600 !important;
                                    }

                                    .nav-link {
                                        color: #a8342d !important;
                                        font-weight: 600 !important;
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
                                <button id="T1" class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Items</button>
                                <button id="T2" class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Services</button>
                                <!-- left side tabs -->
                                <div class="nav-item dropdown ms-auto">
                                    <a class="nav-link dropdown-toggle text-warning" href="#" id="navbardrop" data-bs-toggle="dropdown">
                                        <span title="Notifications" data-bs-toggle="tooltip" data-bs-placement="left" id="notif-icon">
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" id="notif-list">
                                        <div class="dropdown-header text-danger text-center"><strong>Notifications</strong></div>
                                        <div class="dropdown-divider"></div>
                                        <div class="text-center" id="no-notif" hidden style="cursor: pointer;"><small class="text-muted">No Notifications</small></div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        <div class="row g-2 tab-content" id="nav-tabContent">
                            <div class="col-md-12 tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <div class="row g-3 my-2">
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <input class="form-control form-control-sm" type="search" placeholder="Search" aria-label="Search" id="itemSearchbox">
                                            <input type="reset" class="btn btn-sm btn-outline-danger" value="Reset" title="Reset Search" data-bs-toggle="tooltip" data-bs-placement="bottom" id="reset">
                                        </div>
                                        <input type="search" id="Hidden-itemSearchbox" hidden>
                                    </div>
                                    <div class="col">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" id="sortbybutton" aria-expanded="false">
                                                    <span title="Filter by Category" data-bs-toggle="tooltip" data-bs-placement="bottom">Filter</span>
                                                </button>
                                                <ul class="dropdown-menu" id="sortby">
                                                </ul>
                                            </div>
                                            <div class="d-grid gap-2 d-md-flex justify-content-end">
                                                <button class="btn btn-sm btn-warning me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#NewCustomer" id="NC_Modal"><span class="text-dark" id="NC_text">New Customer</span></button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="NewCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Customer Modal" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content shadow border border-warning">
                                                        <div class="modal-header bg-warning">
                                                            <h1 class="modal-title fs-5" id="ModalTitle">
                                                                New Customer</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" hidden></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="CustomerName" class="col-sm-2 col-form-label">Name</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="CustomerName" autocomplete="on" list="customerNamelists" title="First Name and Last Name" data-bs-toggle="tooltip" data-bs-placement="right" placeholder="First Name and Last Name" required>
                                                                    <datalist id="customerNamelists"></datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="CustomerNumber" class="col-sm-2 col-form-label">Number</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="CustomerNumber" autocomplete="on" list="customerNumberlists" pattern="^[0-9]{4}-[0-9]{3}-[0-9]{4}$" required title="Format: 09XX-XXX-XXXX" placeholder="09XX-XXX-XXXX" data-bs-toggle="tooltip" data-bs-placement="right">
                                                                    <input type="checkbox" id="ExistingCustomer" hidden>
                                                                    <datalist id="customerNumberlists"></datalist>
                                                                    <script>
                                                                        //prevent user from typing letters and symbols except for the dash
                                                                    </script>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="CustomerAddress" class="col-sm-2 col-form-label">address</label>
                                                                <div class="col-sm-10">
                                                                    <input type="address" class="form-control" id="CustomerAddress" list="customerAddresslists" autocomplete="on" title="House Number, Street, Barangay, City, Province" data-bs-toggle="tooltip" data-bs-placement="right" placeholder="House Number, Street, Barangay, City, Province" required>
                                                                    <datalist id="customerAddresslists"></datalist>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3" id="JsonErrorMessageDiv" hidden>
                                                                <p class="col-form-label text-center fadeAnimation" id="JsonErrorMessage">This is a placeholder error message</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-warning" id="newcustomer">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Loading -->
                                <div class="container text-center" id="loading">
                                    <div class="d-flex justify-content-center my-5">
                                        <span class="loader"></span>
                                    </div>
                                </div>
                                <div class="container-xxl mb-2" style="max-height: 73vh; overflow-y: scroll;">
                                    <div class="row row-cols-1 row-cols-md-3 g-4 mb-2" id="itemlist">
                                    </div>
                                </div>
                                <p id="noResults" class="text-center text-muted" hidden>No Results</p>
                                <p id="jsonError" class="text-center bg-light text-danger border rounded" hidden></p>
                            </div>
                            <div class="col-md-12 tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <div class="container-xxl" style="max-height: 68vh; overflow-y: scroll;">
                                    <div class="input-group" hidden>
                                        <div class="input-group-text w-100 my-2 bg-transparent border-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="Switch" title="Custom Weight" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">Clothes Weight (kg)</span>
                                                <input type="number" class="form-control" id="Weight" title="Weight of clothes to be washed" data-bs-toggle="tooltip" data-bs-placement="bottom" value="8" max="8" min="1" disabled>
                                            </div>
                                            <!-- button -->
                                            <button type="button" class="btn btn-sm btn-warning mx-1" id="Btn_weight" title="Add to List" data-bs-toggle="tooltip" data-bs-placement="bottom">Add to List</button>
                                        </div>
                                        <small class="text-dark text-center position-absolute bottom-0 end-50" style="font-size: 10px;">
                                            The maximum weight than can handle by the machine is 8kg</small>
                                    </div>
                                    <div class="row g-3 py-2">
                                        <div class="col">
                                            <ul class="list-group">
                                                <li class="list-group-item text-bg-warning text-center" aria-current="true">Services</li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="BothServ">
                                                        <label class="form-check-label fw-bold" for="BothServ">
                                                            Wash and Dry
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="BothServ">
                                                        &#8369; 120.00
                                                    </label>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="WashOnly">
                                                        <label class="form-check-label fw-bold" for="WashOnly">
                                                            Wash Only
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="WashOnly">
                                                        &#8369; 60.00
                                                    </label>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="DryOnly">
                                                        <label class="form-check-label fw-bold" for="DryOnly">
                                                            Dry Only
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="DryOnly">
                                                        &#8369; 60.00
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ol class="list-group">
                                                <li class="list-group-item text-bg-warning text-center" aria-current="true">Optional Services</li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="FoldServ">
                                                        <label class="form-check-label fw-bold" for="FoldServ">
                                                            Folding / 8kg
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="FoldServ">
                                                        &#8369; 20.00
                                                    </label>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="PickupServ">
                                                        <label class="form-check-label fw-bold" for="PickupServ">
                                                            Pick-up
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="PickupServ">
                                                        &#8369; 00.00
                                                    </label>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <input class="form-check-input" type="checkbox" value="" id="DeliveryServ">
                                                        <label class="form-check-label fw-bold" for="DeliveryServ">
                                                            Delivery
                                                        </label>
                                                    </div>
                                                    <label class="form-check-label" for="DeliveryServ">
                                                        &#8369; 20.00
                                                    </label>
                                                </li>
                                            </ol>
                                        </div>
                                        <small class="text-muted text-center">You can unselect the services by clicking the Item in the list</small>
                                        <div class="d-grid gap-2 visually-hidden">
                                            <button class="btn btn-sm btn-primary" type="button">Add to
                                                List</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container-xxl border border-warning shadow rounded">
                        <div class="card my-2 bg-transparent border-0 visually-hidden" style="min-height: 8vh;">
                            <div class="card-body" data-bs-toggle="collapse" data-bs-target="#Info">
                                <span class="text-muted text-center" id="Cname" title="click to expand" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom">No Customer Selected &nbsp;<span class="spinner-border spinner-border-sm text-warning" aria-hidden="true" id="spin"></span></span>
                                <div class="collapse" id="Info">
                                    <div class="card card-body bg-transparent border-0">
                                        <ul class="list-group">
                                            <li class="list-group-item">Name: <span class="fw-bold" id="Cname2"></span></li>
                                            <li class="list-group-item">Contact Number: <span class="fw-bold" id="Cnumber"></span></li>
                                            <li class="list-group-item">Address: <span class="fw-bold text-wrap text-center" id="Caddress"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="d-flex justify-content-between align-items-center my-3">
                            <span class="text-dark">Receipt</span>
                            <span class="badge bg-primary rounded-pill" id="total-items"></span>
                        </h4>
                        <div class="container-xxl" style="max-height: 30vh; overflow-y: scroll;">
                            <ol class="list-group list-group-flush" id="receipt">
                                <div class="text-center" id="noItems" title="waiting for items" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                    <style>
                                        .placeholder {
                                            background-color: #a8342d;
                                        }
                                    </style>
                                    <div class="row">
                                        <div class="col-1 placeholder-glow p-2"><span class="placeholder col-12 rounded"></span></div>
                                        <div class="col-5 placeholder-glow p-2"><span class="placeholder col-12 rounded"></span></div>
                                        <div class="col-2 placeholder-glow p-2"><span class="placeholder col-12 rounded"></span></div>
                                        <div class="col-4 placeholder-glow p-2"><span class="placeholder col-12 rounded"></span></div>
                                    </div>
                                </div>
                            </ol>
                        </div>
                        <br>
                        <ol class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent visually-hidden">
                                <div class="ms-2 me-auto">
                                    <span class="text-primary">Subtotal</span>
                                </div>
                                <span class="fw-bold" id="sub"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent visually-hidden">
                                <div class="ms-2 me-auto">
                                    <span class="text-primary">VAT</span>
                                </div>
                                <span class="fw-bold" id="vat"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent">
                                <div class="ms-2 me-auto">
                                    <span class="text-dark fs-4">Total</span>
                                </div>
                                <span class="fw-bold fs-4" style="color: #a8342d;" id="ammount">&#8369;&nbsp;0.00</span>
                        </ol>
                        <div class="container-xxl p-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <button type="button" class="btn btn-sm w-100" style="background-color: #a8342d; color: #fff;" id="checkout">Checkout</button>
                                    <div class="row" hidden>
                                        <div class="col">
                                            <button type="button" class="btn btn-danger btn-sm w-50" id="reset-list">clear</button>
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-sm w-100" id="checkout">Checkout</button>
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