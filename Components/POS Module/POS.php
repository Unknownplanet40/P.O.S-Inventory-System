<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="This is a Sidebar for Dashboard" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />
    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../../Style/sweetalert2.min.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />
    <link rel="stylesheet" href="../../Style/POS_Style.css" />
    <?php include_once '../../Style/Custom.php'; ?>

    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script defer src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>
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
                                                    <input class="form-control form-control-sm" type="search" placeholder="Search" aria-label="Search" id="itemSearchbox" title="Quick Item Search" data-bs-toggle="tooltip" data-bs-placement="bottom">
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
                                                        <li class="list-group-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" checked>
                                                                <label class="form-check-label" for="defaultCheck1">
                                                                    Wash and Dry - &#8369; 120.00
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" disabled>
                                                                <label class="form-check-label" for="defaultCheck1">
                                                                    Dry Only - &#8369; 60.00
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" disabled>
                                                                <label class="form-check-label" for="defaultCheck1">
                                                                    Wash Only - &#8369; 60.00
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <ol class="list-group">
                                                        <li class="list-group-item text-bg-warning text-center" aria-current="true">Optional Services</li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <div class="ms-2 me-auto">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                                <label class="form-check-label fw-bold" for="defaultCheck1">
                                                                    Ironing
                                                                </label>
                                                            </div>
                                                            <span class="badge text-bg-warning">&#8369;
                                                                25.00</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <div class="ms-2 me-auto">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                                <label class="form-check-label fw-bold" for="defaultCheck1">
                                                                    Fold
                                                                </label>
                                                            </div>
                                                            <span class="badge text-bg-warning">&#8369;
                                                                25.00</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <div class="ms-2 me-auto">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" checked>
                                                                <label class="form-check-label fw-bold" for="defaultCheck1">
                                                                    Pick Up
                                                                </label>
                                                            </div>
                                                            <span class="badge text-bg-warning">&#8369;
                                                                25.00</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <div class="ms-2 me-auto">
                                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" disabled>
                                                                <label class="form-check-label fw-bold" for="defaultCheck1">
                                                                    Delivery
                                                                </label>
                                                            </div>
                                                            <span class="badge text-bg-warning">&#8369;
                                                                25.00</span>
                                                        </li>
                                                    </ol>
                                                </div>
                                                <div class="d-grid gap-2">
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
                                            <span class="text-primary">Total</span>
                                        </div>
                                        <span class="fw-bold" id="ammount">&#8369;&nbsp;0.00</span>
                                </ol>
                                <div class="container-xxl p-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="row">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Itempath = './MOCK_DATA.json';
        const url = './Customers.json';

        var items = [];
        var SelectedReceipt = [];
        var SelectedItemID = [];
        var SelectedItemName = [];
        var SelectedItemPrice = [];
        var SelectedItemQuantity = [];
        var SelectedItems = [SelectedReceipt, SelectedItemID, SelectedItemName, SelectedItemPrice, SelectedItemQuantity];
        fetch(Itempath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to retrieve data from the server. Please try again later.');
                } else if (response.headers.get('content-length') == 0) {
                    throw new Error('No Items Found');
                }

                return response.json();
            })
            .then(jsonData => {
                jsonData.forEach(function(item) {

                    // if id is not in the list, add a temporary id
                    if (!item['id']) {
                        item['id'] = Math.floor(Math.random() * 1000000);
                    }

                    // if category is not in the list, add a temporary category
                    if (!item['category']) {
                        item['category'] = 'Others';
                    }

                    // if price is not in the list, add a temporary price
                    if (!item['price']) {
                        item['price'] = 0;
                    }

                    // if quantity is not in the list, add a temporary quantity
                    if (!item['quantity']) {
                        item['quantity'] = 0;
                    }

                    // if ml is not in the list, add a temporary ml
                    if (!item['ml']) {
                        item['ml'] = 0;
                    }

                    // if product_name is not in the list, add a temporary product_name
                    if (!item['product_name']) {
                        item['product_name'] = 'No Name';
                    }

                    var itemname = item['product_name'].replace(' ', '-');

                    // create col div
                    var col = document.createElement('div');
                    col.classList.add('col', 'col-item');
                    col.id = 'cardbox_' + itemname;
                    document.getElementById('itemlist').appendChild(col);

                    // create card div
                    var card = document.createElement('div');
                    card.classList.add('card', 'card-item', 'h-100', 'shadow', 'border', 'border-warning');
                    card.id = 'itemcard';
                    col.appendChild(card);

                    // create image
                    var image = document.createElement('img');
                    image.classList.add('card-img-top', 'p-2');
                    image.src = '../../assets/TestDeter.jpg';
                    image.alt = '...';
                    image.style.height = '128px';
                    image.style.objectFit = 'contain';
                    card.appendChild(image);

                    // create card body
                    var cardbody = document.createElement('div');
                    cardbody.classList.add('card-body');
                    card.appendChild(cardbody);

                    // create card title
                    var cardtitle = document.createElement('h5');
                    cardtitle.classList.add('card-title');
                    cardtitle.id = 'itemname';
                    cardtitle.innerText = item['product_name'];
                    cardbody.appendChild(cardtitle);

                    // create category
                    var category = document.createElement('p');
                    category.classList.add('Category', 'card-text', 'text-muted');
                    category.id = 'Category';
                    category.hidden = true;
                    category.innerText = item['category'];
                    cardbody.appendChild(category);

                    // create price
                    var price = document.createElement('small');
                    price.classList.add('card-text', 'text-muted');
                    if (item['category'] == 'Liquid') {
                        price.innerHTML = '&#8369; ' + item['price'] + ' | ' + item['ml'] + ' ml';
                    } else {
                        price.innerHTML = '&#8369; ' + item['price'];
                    }
                    cardbody.appendChild(price);

                    // create text center
                    var textcenter = document.createElement('div');
                    textcenter.classList.add('text-center', 'mx-4');
                    cardbody.appendChild(textcenter);

                    // create input group
                    var inputgroup = document.createElement('div');
                    inputgroup.classList.add('input-group', 'mb-1');
                    inputgroup.id = 'inputgroup_' + item['id'];
                    textcenter.appendChild(inputgroup);

                    // create minus button
                    var minusbutton = document.createElement('button');
                    minusbutton.classList.add('btn', 'btn-sm', 'btn-outline-warning');
                    minusbutton.type = 'button';
                    minusbutton.id = 'bminus_' + item['id'];
                    minusbutton.innerHTML = '&minus;';
                    inputgroup.appendChild(minusbutton);

                    // create count
                    var count = document.createElement('input');
                    count.type = 'text';
                    count.id = 'count_' + item['id'];
                    count.classList.add('form-control', 'form-control-sm');
                    count.placeholder = '0';
                    count.style.textAlign = 'center';
                    count.disabled = true;
                    inputgroup.appendChild(count);


                    // create plus button
                    var plusbutton = document.createElement('button');
                    plusbutton.classList.add('btn', 'btn-sm', 'btn-outline-warning');
                    plusbutton.type = 'button';
                    plusbutton.id = 'bplus_' + item['id'];
                    plusbutton.innerHTML = '&plus;';
                    inputgroup.appendChild(plusbutton);

                    // create item button
                    var itembutton = document.createElement('button');
                    itembutton.classList.add('btn', 'btn-sm', 'btn-outline-warning');
                    itembutton.type = 'button';
                    itembutton.id = 'Item_' + item['id'];
                    itembutton.title = 'Add to List';
                    itembutton.setAttribute('data-bs-toggle', 'tooltip');
                    itembutton.setAttribute('data-bs-placement', 'right');
                    inputgroup.appendChild(itembutton);

                    // create svg
                    var svg = document.createElement('svg');
                    svg.innerHTML = '<svg class="bi pe-none" width="18" height="18" role="img" aria-label="Add to List"> <use xlink:href="#cart" /> </svg>';
                    itembutton.appendChild(svg);

                    // create card footer
                    var cardfooter = document.createElement('div');
                    cardfooter.classList.add('card-footer');
                    card.appendChild(cardfooter);

                    // create stock
                    var stock = document.createElement('small');
                    stock.classList.add('text-mute');
                    stock.id = 'stock_' + item['id'];
                    stock.innerText = 'Stocks: ' + item['quantity'] + ' out of ' + item['quantity'];
                    cardfooter.appendChild(stock);

                    var current_stock = item['quantity'];
                    var percent = current_stock * 0.5;
                    var count = 0;

                    function updateStockDisplay() {
                        document.getElementById('count_' + item['id']).value = count;
                        document.getElementById('stock_' + item['id']).innerText = 'Stocks: ' + current_stock + ' out of ' + item['quantity'];

                        if (current_stock <= percent) {
                            document.getElementById('stock_' + item['id']).classList.remove('text-muted');
                            document.getElementById('stock_' + item['id']).classList.add('text-danger');
                        } else {
                            document.getElementById('stock_' + item['id']).classList.remove('text-danger');
                            document.getElementById('stock_' + item['id']).classList.add('text-muted');
                        }
                    }

                    // add event listener to minus button
                    document.getElementById('bminus_' + item['id']).addEventListener('click', function() {
                        if (count > 0) {
                            count--;
                            current_stock++;
                            updateStockDisplay();
                        }
                    });

                    // add event listener to plus button
                    document.getElementById('bplus_' + item['id']).addEventListener('click', function() {
                        // if the current stock is 0, disable the plus button
                        if (current_stock != 0) {
                            count++;
                            current_stock--;
                            updateStockDisplay();
                        }
                    });

                    if (document.getElementById('CustomerName').value == '') {
                        document.getElementById('Item_' + item['id']).disabled = true;
                    } else {

                        document.getElementById('Item_' + item['id']).disabled = false;
                    }

                    // add event listener to item button that when clicked add the item to the receipt
                    document.getElementById('Item_' + item['id']).addEventListener('click', function() {

                        if (document.getElementById('count_' + item['id']).value == 0) {
                            //make the input box red and back to normal
                            document.getElementById('count_' + item['id']).classList.add('is-invalid');
                            setTimeout(function() {
                                document.getElementById('count_' + item['id']).classList.remove('is-invalid');
                            }, 1000);
                        } else {
                            var Receipt = document.getElementById('receipt');
                            document.getElementById('noItems').setAttribute('hidden', 'true');
                            var random = Math.floor(Math.random() * 1000000);

                            //add to receipt
                            var li = document.createElement('li');
                            var receiptID = 'receipt_' + item['id'] + '_' + random;
                            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-start', 'bg-transparent');
                            li.setAttribute('title', 'Click to remove item');
                            li.id = receiptID;
                            li.style.cursor = 'pointer';
                            Receipt.appendChild(li);

                            // add item name
                            var div = document.createElement('div');
                            div.classList.add('ms-2', 'me-auto', 'text-truncate');
                            div.id = 'itemname_' + item['id'];
                            div.style.textTransform = 'capitalize';
                            div.style.maxWidth = '215px';
                            div.innerHTML = document.getElementById('count_' + item['id']).value + ' &times ' + item['product_name'];
                            li.appendChild(div);

                            // add item price
                            var span = document.createElement('span');
                            span.id = 'itemprice';
                            var quan = document.getElementById('count_' + item['id']).value;
                            span.innerHTML = '<span class="text-muted">&#8369; <span id="priceItem">' + (item['price'] * quan).toFixed(2) + '<small hidden id="quanti">' + quan + '</small></span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
                            li.appendChild(span);

                            // get all itemprice and add it to the total
                            var itemprice = document.querySelectorAll('#priceItem');
                            var total = 0;
                            itemprice.forEach(function(price) {
                                total += parseFloat(price.innerText);
                            });

                            document.getElementById('ammount').innerHTML = '<span class="fw-bold" id="overall">&#8369;&nbsp;' + total.toFixed(2) + '</span>';
                            SelectedReceipt.push(receiptID);
                            SelectedItemID.push('item_' + item['id']); // add random number to the id to make it unique
                            SelectedItemName.push(item['product_name']);
                            SelectedItemPrice.push(item['price']);
                            SelectedItemQuantity.push(document.getElementById('count_' + item['id']).value);

                            console.log(SelectedItems); // remove this later

                            //reset the count
                            document.getElementById('count_' + item['id']).value = 0;
                            count = 0;

                            // add event listener to receipt item that when clicked remove the item from the receipt
                            document.getElementById(receiptID).addEventListener('click', function() {
                                var index = SelectedReceipt.indexOf(receiptID);
                                var dump = SelectedItemPrice[index] * SelectedItemQuantity[index];
                                console.log(SelectedItemName[index] + ' ' + dump); // for debugging purposes

                                // add removed count to the current stock to the item
                                current_stock += parseInt(SelectedItemQuantity[index]);
                                updateStockDisplay();


                                var itemprice = document.querySelectorAll('#priceItem');
                                var total = 0;
                                itemprice.forEach(function(price) {
                                    total += parseFloat(price.innerText);
                                });

                                var overall = document.getElementById('overall');
                                overall.innerHTML = '&#8369;&nbsp;' + (total - dump).toFixed(2);

                                if (index > -1) {
                                    SelectedReceipt.splice(index, 1);
                                    SelectedItemID.splice(index, 1);
                                    SelectedItemName.splice(index, 1);
                                    SelectedItemPrice.splice(index, 1);
                                    SelectedItemQuantity.splice(index, 1);
                                }
                                document.getElementById(receiptID).remove();

                                if (SelectedReceipt.length == 0) {
                                    document.getElementById('noItems').removeAttribute('hidden');
                                }

                                console.log(SelectedItems);
                            });
                        }
                    });
                });

            }).catch(error => {
                var JsonError = document.getElementById('jsonError');
                JsonError.removeAttribute('hidden');
                //if the error message contains the word "Error:" then remove it
                if (error.toString().includes('Error:')) {
                    error = error.toString().replace('Error: ', '');
                }
                if (error.toString().includes('No Items Found')) {
                    JsonError.classList.remove('text-danger');
                    JsonError.classList.add('text-warning');

                    //disable the search box, reset button and sort by button
                    document.getElementById('itemSearchbox').disabled = true;
                    document.getElementById('reset').disabled = true;
                    document.getElementById('sortbybutton').disabled = true;
                }

                JsonError.innerHTML = error;

                //use this later in checkout
                /* document.getElementById('toastTitle').innerHTML = 'Error';
                document.getElementById('toastBody').innerHTML = error;
                document.getElementById('toastTime').innerHTML = new Date().toLocaleTimeString();
    
                // activate the toast
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                toastList.forEach(toast => toast.show()); */
            });

        // Fetch the JSON file
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(jsonData => {
                var customerName = document.getElementById('customerNamelists');
                var customerNameList = [];
                jsonData.forEach(function(customer) {
                    if (!customerNameList.includes(customer.name)) {
                        var option = document.createElement('option');
                        var name = customer.first_name + ' ' + customer.last_name;
                        option.value = name;
                        customerName.appendChild(option);
                    }
                });

                document.getElementById('CustomerName').addEventListener('input', function() {
                    var customName = this.value.toLowerCase();
                    var customerNumber = document.getElementById('CustomerNumber');
                    var customerAddress = document.getElementById('CustomerAddress');
                    var ExistingCustomer = document.getElementById('ExistingCustomer');

                    jsonData.forEach(function(customer) {
                        var name = customer.first_name + ' ' + customer.last_name;
                        if (name.toLowerCase() == customName) {
                            customerNumber.value = customer.phone_number;
                            customerAddress.value = customer.address;
                            ExistingCustomer.checked = true;
                        }
                    });
                });

            })
            .catch(error => {
                console.error('Error fetching the file:', error);
            });


        document.getElementById('newcustomer').addEventListener('click', function() {
            var customerName = document.getElementById('CustomerName').value;
            var customerNumber = document.getElementById('CustomerNumber').value;
            var customerAddress = document.getElementById('CustomerAddress').value;
            var ExistingCustomer = document.getElementById('ExistingCustomer');

            if (customerName != '' && customerNumber != '' && customerAddress != '') {
                localStorage.setItem('name', customerName);
                localStorage.setItem('number', customerNumber);
                localStorage.setItem('address', customerAddress);
                localStorage.setItem('ExistingCustomer', ExistingCustomer.checked);
                location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill up all fields',
                });
            }
        });

        if (localStorage.getItem('name') != null) {
            document.getElementById('CustomerName').value = localStorage.getItem('name');
            document.getElementById('CustomerNumber').value = localStorage.getItem('number');
            document.getElementById('CustomerAddress').value = localStorage.getItem('address');
            document.getElementById('ExistingCustomer').checked = localStorage.getItem('ExistingCustomer');

            document.getElementById('Cname').innerHTML = "Customer Details";
            document.getElementById('Cname2').innerHTML = localStorage.getItem('name');
            document.getElementById('Cnumber').innerHTML = localStorage.getItem('number');
            document.getElementById('Caddress').innerHTML = localStorage.getItem('address');
            localStorage.clear();
        }
        /* 
            document.getElementById('reset-list').addEventListener('click', function () {
        
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will clear the list and cannot be undone!",
                    icon: 'warning',
                    allowOutsideClick: false,
        
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
        
                    }
                });
            }); */

        //if reset button is clicked clear the search box
        document.getElementById('reset').addEventListener('click', function() {
            document.getElementById('itemSearchbox').value = '';
            document.getElementById('itemSearchbox').dispatchEvent(new Event('input'));

            document.getElementById('Hidden-itemSearchbox').value = '';
            document.getElementById('Hidden-itemSearchbox').dispatchEvent(new Event('input'));

            document.getElementById('sortbybutton').innerText = 'Filter ';
            doc
        });

        // Search box
        document.getElementById('itemSearchbox').addEventListener('input', function() {
            var searchTerm = this.value.toLowerCase();

            // clear the hidden search box
            document.getElementById('Hidden-itemSearchbox').value = '';
            document.getElementById('sortbybutton').innerText = 'Filter ';


            // Get all cards
            var cards = document.querySelectorAll('.card-item');
            var noResults = document.getElementById('noResults');

            // Iterate through each card and toggle its visibility based on the search term
            cards.forEach(function(card) {

                var titleElement = card.querySelector('#itemname');
                if (titleElement) {
                    var title = titleElement.innerText.toLowerCase();
                    var isMatch = title.includes(searchTerm);

                    // Toggle hidden attribute based on the search term
                    if (isMatch) {
                        card.closest('.col').removeAttribute('hidden');
                    } else {
                        card.closest('.col').setAttribute('hidden', 'true');
                    }
                }
            });

            // if all cards are hidden, show no results message
            if (document.querySelectorAll('.col-item[hidden]').length == cards.length) {
                noResults.removeAttribute('hidden');
            } else {
                noResults.setAttribute('hidden', 'true');
            }
        });

        document.getElementById('sortbybutton').addEventListener('click', function() {
            var categoryList = [];
            var sortby = document.getElementById('sortby');
            var sortbybutton = document.getElementById('sortbybutton');

            // Clear existing dropdown items
            sortby.innerHTML = '';

            // Get all category from cards and add it to the list
            var cards = document.querySelectorAll('.card-item');
            cards.forEach(function(card) {
                var categoryElement = card.querySelector('#Category');
                if (categoryElement) {
                    var category = categoryElement.innerText.toLowerCase();
                    if (!categoryList.includes(category)) {
                        categoryList.push(category);
                    }
                }
            });

            // add all category to the dropdown
            categoryList.forEach(function(category) {
                var li = document.createElement('li');
                li.classList.add('dropdown-item');
                li.style.cursor = 'pointer';
                li.innerText = category;
                sortby.appendChild(li);
            });

            // add event listener to each dropdown item
            var dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    sortbybutton.innerText = item.innerText;
                    document.getElementById('Hidden-itemSearchbox').value = item.innerText;
                    document.getElementById('Hidden-itemSearchbox').dispatchEvent(new Event('input'));
                });
            });
        });
        // Search box

        document.getElementById('Hidden-itemSearchbox').addEventListener('input', function() {
            var HiddenSearchTerm = this.value.toLowerCase();

            // clear the search box
            document.getElementById('itemSearchbox').value = '';
            var noResults = document.getElementById('noResults');

            // Get all cards
            var cards = document.querySelectorAll('.card-item');

            // Iterate through each card and toggle its visibility based on the search term
            cards.forEach(function(card) {
                var categoryElement = card.querySelector('#Category');
                if (categoryElement) {
                    var category = categoryElement.innerText.toLowerCase();
                    var isMatch = category.includes(HiddenSearchTerm);

                    // Toggle hidden attribute based on the search term
                    if (isMatch) {
                        card.closest('.col').removeAttribute('hidden');
                    } else {
                        card.closest('.col').setAttribute('hidden', 'true');
                    }
                }
            });
            // if all cards are hidden, show no results message
            if (document.querySelectorAll('.col-item[hidden]').length == cards.length) {
                noResults.removeAttribute('hidden');
            } else {
                noResults.setAttribute('hidden', 'true');
            }
        });

        document.getElementById("checkout").addEventListener('click', function() {
            var ExistingCustomer = document.getElementById('ExistingCustomer');

            console.log(ExistingCustomer.checked);

            if (ExistingCustomer.checked == true) {
                alert('Existing Customer', 'success', 'top-end', 3000, false);
            } else {
                alert('New Customer', 'success', 'top-end', 3000, false);
            }
        });
    });
</script>

</html>