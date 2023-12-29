<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Point of Sale Module" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />
    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../../Style/sweetalert2.min.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />
    <link rel="stylesheet" href="../../Style/POS_Style.css" />
    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script defer src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>
    <script defer src="../../Script/Pos.js"></script>
    <Script>
        // cover whole page it the window is resized to mobile size
        /* window.addEventListener('resize', function () {
            if (window.innerWidth <= 768 && window.innerWidth <= 992) {
                document.getElementById('mainwindow').classList.add('d-none');
                document.getElementById('information').removeAttribute('hidden');
                document.getElementById('information').innerHTML = "You Can't View This Page on this Screen Size";
            } else {
                document.getElementById('mainwindow').classList.remove('d-none');
                document.getElementById('information').setAttribute('hidden', '');
            }
        }); */
    </Script>
    <title>Point of Sales</title>
    <?php include_once '../../assets/Icons.php'; ?>
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
        <?php require_once '../../Components/smallSidebar.php'; ?>
        <div class="container-xxl">
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div class="toast-container top-0 end-0 p-3" id="toastPlacement">
                    <div class="toast shadow text-bg-warning" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                        <div class="toast-header">
                            <img src="../../assets/Logo.svg" class="rounded me-2" alt="..." width="20" height="20">
                            <strong class="me-auto" id="toastTitle"></strong>
                            <small id="toastTime"></small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body" id="toastBody">
                        </div>
                    </div>
                </div>
            </div>
            <div class="parent">
                <div class="div1">
                    <div class="container-xxl" style="background-color: #f5f5f5;">
                        <div>
                            <h1>backup space for later use</h1>
                        </div>
                    </div>
                </div>
                <div class="div2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="container-xxl shadow border border-warning" style="background-color: #f5f5f5; border-radius: 10px;">
                                <nav>
                                    <div class="nav nav-tabs mt-1" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Items</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Services</button>
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
                                                        <button class="btn btn-sm btn-warning me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#NewCustomer"><span class="text-dark" title="Add Customer Address first before adding items" data-bs-toggle="tooltip" data-bs-placement="bottom">New
                                                                Customer</span></button>
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
                                                                            <input type="text" class="form-control" id="CustomerName" autocomplete="on" list="customerNamelists">
                                                                            <datalist id="customerNamelists"></datalist>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="CustomerNumber" class="col-sm-2 col-form-label">Contact
                                                                            Number</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="CustomerNumber">
                                                                            <input type="checkbox" id="ExistingCustomer" hidden>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="CustomerAddress" class="col-sm-2 col-form-label">Address</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="address" class="form-control" id="CustomerAddress">
                                                                        </div>
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
                                        <div class="container-xxl mb-2" style="max-height: 65vh; overflow-y: scroll;">
                                            <div class="row row-cols-1 row-cols-md-3 g-4" id="itemlist">
                                            </div>
                                        </div>
                                        <p id="noResults" class="text-center text-muted" hidden>No Results</p>
                                        <p id="jsonError" class="text-center bg-light text-danger border rounded" hidden></p>
                                    </div>
                                    <div class="col-md-12 tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                        <div class="container-xxl" style="max-height: 68vh; overflow-y: scroll;">
                                            <div class="row g-3 py-2">
                                                <div class="col">
                                                    <div class="form-floating mb-3" hidden>
                                                        <input type="email" class="form-control form-control-sm" id="floatingInput" title="Max Weight of 8kg per load" data-bs-toggle="tooltip" data-bs-placement="bottom" placeholder="">
                                                        <label for="floatingInput">Weight</label>
                                                    </div>
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
                            <div class="container-xxl border border-warning shadow" style="background-color: #f5f5f5; border-radius: 10px;">
                                <div class="card my-2 bg-transparent border-0" style="min-height: 8vh;">
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
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-primary">Receipt</span>
                                    <span class="badge bg-primary rounded-pill" id="total-items"></span>
                                </h4>
                                <div class="container-xxl" style="max-height: 30vh; overflow-y: scroll;">
                                    <ol class="list-group list-group-flush" id="receipt">
                                        <div class="container text-center" id="noItems">
                                            <div class="row">
                                                <div class="col-6 placeholder-glow p-2"><span class="placeholder col-12 rounded"></span></div>
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
                                            <span class="text-primary fs-4">Total</span>
                                        </div>
                                        <span class="fw-bold fs-4" id="ammount">&#8369;&nbsp;0.00</span>
                                </ol>
                                <div class="container-xxl p-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <button type="button" class="btn btn-warning btn-sm w-100" id="checkout">Checkout</button>
                                            <div class="row" hidden>
                                                <div class="col">
                                                    <button type="button" class="btn btn-danger btn-sm w-50" id="reset-list">clear</button>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-warning btn-sm w-100" id="checkout">Checkout</button>
                                                </div>
                                            </div>
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