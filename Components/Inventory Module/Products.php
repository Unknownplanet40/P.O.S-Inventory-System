<?php
include_once '../Database/config.php';
session_start();

// Total Items Count
$OVERALL = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) AS totalItem FROM pos_products WHERE Achieved = 0"))['totalItem'];

// Low Stock Items Count
$LOW = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(isLowStock) AS lowItem FROM pos_products WHERE isLowStock = 1 AND Achieved = 0"))['lowItem'];

// Achieved Items Count
$ACHIEVED = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) AS delItem FROM pos_products WHERE Achieved = 1"))['delItem'];





?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Inventory Management System" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />


    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css" />
    <link rel="stylesheet" href="../../DataTables/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../Style/SA2-BS4.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />

    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>

    <script defer src="../../DataTables/js/jquery-3.7.0.js"></script>
    <script defer src="../../DataTables/js/jquery.dataTables.min.js"></script>
    <script defer src="../../DataTables/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="../../Script/Products.js"></script>


    <title>Products Inventory</title>
    <?php include_once '../../assets/Icons.php'; ?>
    <style>
        * {
            box-sizing: border-box;
            scroll-behavior: smooth;
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

        body {
            min-width: 1300px;
        }

        .bgimage {
            background-image: url('../../assets/cardBG.svg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        td {
            vertical-align: middle !important;
        }

        .fillup {
            width: 100%;
            height: 100%;
            background-color: #000;
            opacity: 0.9;
            position: fixed;
            z-index: 9999;
        }

        .fillup h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 768px) {
            body {
                overflow: hidden;
            }
        }

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

        [type="search"][aria-controls="productTable"] {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            box-shadow: none;
            min-width: 350px !important;
            height: 35px !important;
        }

        [type="search"][aria-controls="productTable"]:focus {
            outline: none;
            box-shadow: none;
            border-color: #ffcd00;
        }

        [type="search"][aria-controls="productTable"]::placeholder {
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
</head>

<body>
    <div class="d-block d-md-none">
        <div class="fillup">
            <h1 class="text-center text-white">This page is not available in small screen</h1>
        </div>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        if (strpos($_SESSION['message'], 'successfully') !== false) {
            echo '<script>
            Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                  },
                }).fire({
                  icon: "success",
                  title: "Message",
                  text: "' . $_SESSION['message'] . '",
                });
            </script>';
        } else if (strpos($_SESSION['message'], 'No changes made') !== false) {
            echo '<script>
            Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                  },
                }).fire({
                  icon: "info",
                  title: "Message",
                  text: "' . $_SESSION['message'] . '",
                });
            </script>';
        } elseif (strpos($_SESSION['message'], 'Error: ') !== false) {
            echo '<script>
            Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                  },
                }).fire({
                  icon: "error",
                  title: "Message",
                  text: "' . $_SESSION['message'] . '",
                });
            </script>';
        } elseif (strpos($_SESSION['message'], 'Restore') !== false) {
            echo '<script>
            Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                  },
                }).fire({
                  icon: "success",
                  title: "Message",
                  text: "' . $_SESSION['message'] . '",
                });
            </script>';
        } else {
            echo '<script>
            Swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                  },
                }).fire({
                  icon: "warning",
                  title: "Message",
                  text: "' . $_SESSION['message'] . '",
                });
            </script>';
        }
        unset($_SESSION['message']);
    }

    ?>
    <div class="parent">
        <div class="div1">
            <?php require_once '../SmallSidebar.php'; ?>
        </div>
        <div class="div2">
            <main>
                <div class="container-xxl mb-2">
                    <div class="row row-cols-1 row-cols-md-3 g-4 p-4">
                        <div class="col-md-5">
                            <div class="card border border-warning">
                                <div class="card-body bgimage">
                                    <h5 class="card-title">Total Items</h5>
                                    <h5 class="card-title text-center fs-1"><?php echo $OVERALL; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border border-warning">
                                <div class="card-body bgimage">
                                    <h5 class="card-title">Low Items Stock</h5>
                                    <h5 class="card-title text-center fs-1"><?php echo $LOW; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border border-0">
                                <div class="card-body">
                                    <div class="d-grid gap-2 col-12 mx-auto">
                                        <button class="btn btn-warning btn-sm fw-bold" type="button">Add Item</button>
                                        <button type="button" class="btn custom-brown btn-sm position-relative" data-bs-toggle="modal" data-bs-target="#Archive">
                                            Achieved Items
                                            <?php if ($ACHIEVED > 0) { ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <?php echo $ACHIEVED; ?>
                                                    <span class="visually-hidden">Achieved Items</span>
                                                </span>
                                            <?php } ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once './Archived_Table.php'; ?>
                    <div class="modal fade" id="Editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form id="editForm" name="editForm" method="POST" enctype="multipart/form-data">
                                <div class="modal-content rounded-1">
                                    <div class=" modal-header text-bg-warning visually-hidden">
                                        <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Product Details</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card mb-3 border border-0">
                                            <div class="row g-0">
                                                <div class="col-md-4 p-3">
                                                    <img src="" class="img-thumbnail mx-auto d-block" alt="Product Image" id="prodImage" name="prodImage" style="max-width: 132px; max-height: 132px;">
                                                    <div class="input-group mb-3 input-group-sm mx-auto mt-3" style="max-width: 100px;">
                                                        <input type="file" class="form-control shadow-sm" id="changeImage" name="changeImage" accept="image/png, image/jpeg, image/jpg" style="margin-left: 8px; margin-right: -3px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <input type="hidden" name="prodID" id="prodID" value="">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" placeholder="Name" value="" name="prodName" id="prodName">
                                                            <label for="prodName">Product Name</label>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" style="min-width: 135px;">Category</span>
                                                            <select class="form-select" id="prodCategory" name="prodCategory">
                                                                <option selected hidden disabled>Choose...</option>
                                                                <?php
                                                                $sql = "SELECT category FROM pos_products WHERE Achieved = 0";
                                                                $result = mysqli_query($conn, $sql);
                                                                $cat[] = array();
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $category = $row['category'];

                                                                        //check if its already in the array
                                                                        if (!in_array($category, $cat)) {
                                                                            array_push($cat, $category);
                                                                            echo "<option value='$category'>$category</option>";
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" style="min-width: 135px;">Price</span>
                                                            <input type="number" class="form-control" placeholder="Product Price" value="" min="0" name="prodPrice" id="prodPrice" step=".01">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" style="min-width: 135px;">Current Stock</span>
                                                            <input type="number" class="form-control text-end rounded-end" placeholder="Current Stock" value="" min="0" name="prodQuantity" id="prodCurrentStock">
                                                            <span class="input-group-text user-select-none bg-transparent border border-0" title="Product Quantity" data-bs-toggle="tooltip" data-bs-placement="right"><b id="prodQuantity">1000</b></span>
                                                        </div>
                                                        <div class="input-group mb-3" id="ml">
                                                            <span class="input-group-text" style="min-width: 135px;">Current ML</span>
                                                            <input type="number" class="form-control text-end rounded-end" placeholder="Product ML" value="0" min="0" name="prodML" id="prodML">
                                                            <span class="input-group-text user-select-none bg-transparent border border-0" title="Product ML" data-bs-toggle="tooltip" data-bs-placement="right"><b id="prodML">1000</b></span>
                                                        </div>
                                                        <script>
                                                            document.getElementById('prodCategory').addEventListener('change', function() {
                                                                var category = this.value;
                                                                if (category == "Liquid") {
                                                                    document.getElementById('ml').classList.remove('visually-hidden');
                                                                } else {
                                                                    document.getElementById('ml').classList.add('visually-hidden');
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="closeModal">Close</button>
                                        <input type="submit" class="btn btn-warning btn-sm" value="Save Changes" name="saveChanges" id="saveChanges">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="p-4 rounded" style="max-height: 70vh; overflow-y: auto; overflow-x: hidden;">
                        <div class="d-flex justify-content-center" id="spinner">
                            <span class="loader"></span>
                        </div>
                        <table id="productTable" class="table table-striped table-hover d-none table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>ML</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class=" table-group-divider">
                                <?php
                                $sql = "SELECT * FROM pos_products WHERE Achieved = 0";
                                $result = mysqli_query($conn, $sql);

                                $i = 0;
                                $cat[] = array();
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $product_name = $row['product_name'];
                                        $category = $row['category'];
                                        $price = $row['price'];
                                        $quantity = $row['quantity'];
                                        $CurrentStock = $row['CurrentStock'];
                                        $LowStock = $row['isLowStock'];
                                        $formatedname = str_replace(' ', '_', $product_name);
                                        $edit = $formatedname . "_" . $id;

                                        if ($row['image_path'] == NULL) {
                                            if ($category == "Liquid") {
                                                $image = "../../assets/Default_Image/Def_Liquid.png";
                                            } elseif (
                                                $category == "Powder"
                                            ) {
                                                $image = "../../assets/Default_Image/Def_Powder.png";
                                            } elseif (
                                                $category == "Basket"
                                            ) {
                                                $image = "../../assets/Default_Image/Def_basket.png";
                                            } else {
                                                $image = "../../assets/Default_Image/Def_Others.png";
                                            }
                                        } else {
                                            $image = "../../assets/Custom_Image/" . $row['image_path'];
                                        }

                                        if ($LowStock == 1) {
                                            $LowStock = "Low Stock";
                                            $indicator = "<span class='text-danger'>&#9864;</span>";
                                        } else {
                                            $LowStock = "In Stock";
                                            $indicator = "<span class='text-success'>&#9864;</span>";
                                        }

                                        if ($category == "Liquid") {
                                            $ml = $row['ml'];
                                            $Current_ML = $row['Current_ML'];
                                        } else {
                                            $ml = "N/A";
                                            $Current_ML = "N/A";
                                        }

                                        if ($LowStock == "Low Stock") {
                                            echo "<tr class='table-danger'>";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo "<td><img src='$image' width='25px' height='25px' class='rounded-circle' alt='Product Image'>&nbsp;&nbsp;$product_name</td>";
                                        echo "<td>$category</td>";
                                        echo "<td><b>₱ </b>$price</td>";
                                        echo "<td>$indicator&nbsp;$LowStock</td>";
                                        echo "<td><b title='Current Stock' data-bs-toggle='tooltip' data-bs-placement='left'>$CurrentStock</b> / <span title='Product Quantity' data-bs-toggle='tooltip' data-bs-placement='right'>$quantity</span></td>";
                                        echo "<td>";
                                        if ($category == "Liquid") {
                                            echo "<b title='Current ML' data-bs-toggle='tooltip' data-bs-placement='left'>$Current_ML</b> / <span title='Product ML' data-bs-toggle='tooltip' data-bs-placement='right'>$ml</span>";
                                        } else {
                                            echo "<small class='text-muted'>&horbar;<span class='visually-hidden'>N/A</span></small>";
                                        }
                                        echo "</td>";
                                        echo "<td>
                                    <button class='btn btn-sm custom-active' data-bs-toggle='modal' data-bs-target='#Editmodal' title='Edit Item' id='$edit'>&#9998;</button>
                                    <button class='btn btn-sm custom-brown' title='Delete Item'>&#10006;</button>
                                    </td>";
                                        echo "</tr>";

                                        echo "<script>
                                            document.getElementById('$edit').addEventListener('click', function() {
                                                var id = '$id';
                                                var prodName = '$product_name';
                                                var prodCategory = '$category';
                                                var prodPrice = '$price';
                                                var prodQuantity = '$quantity';
                                                var prodCurrentStock = '$CurrentStock';
                                                var prodImage = '$image';
                                                var prodML = '$ml';
                                                var prodCurrentML = '$Current_ML';

                                                document.getElementById('prodID').value = id;
                                                document.getElementById('prodName').value = prodName;
                                                document.getElementById('prodImage').src = prodImage;
                                                document.getElementById('changeImage').value = '';
                                                document.getElementById('prodCategory').value = prodCategory;


                                                document.getElementById('prodPrice').value = prodPrice;
                                                document.getElementById('prodCurrentStock').value = prodCurrentStock;

                                                if (prodCategory == 'Liquid') {
                                                    document.getElementById('ml').classList.remove('visually-hidden');
                                                    document.getElementById('prodML').value = prodML;
                                                } else {
                                                    document.getElementById('ml').classList.add('visually-hidden');
                                                }
                                            });
                                        </script>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <script>
                            document.getElementById('changeImage').addEventListener('change', function() {
                                var file = this.files[0];
                                if (file) {
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        document.getElementById('prodImage').src = this.result;
                                        console.log(document.getElementById('changeImage').value);
                                    }
                                    reader.readAsDataURL(file);
                                }
                            });

                            // before form submit
                            document.getElementById('editForm').addEventListener('submit', function(e) {
                                e.preventDefault();

                                function validateAndSetError(fieldId) {
                                    const field = document.getElementById(fieldId);
                                    const value = field.value.trim();

                                    if (value === "") {
                                        field.classList.add('is-invalid');
                                        field.focus();
                                        return false;
                                    }

                                    field.classList.remove('is-invalid');
                                    console.log(fieldId + " is valid");
                                    return true;
                                }

                                const prodNameValid = validateAndSetError('prodName');
                                const prodCategoryValid = validateAndSetError('prodCategory');
                                const prodPriceValid = validateAndSetError('prodPrice');
                                const prodQuantityValid = validateAndSetError('prodCurrentStock');
                                const prodMLValid = validateAndSetError('prodML');

                                if (prodNameValid && prodCategoryValid && prodPriceValid && prodQuantityValid && prodMLValid) {
                                    const editForm = document.getElementById('editForm');
                                    editForm.action = './UpdateProduct.php';
                                    editForm.submit();
                                }
                            });
                            document.getElementById('Editmodal').addEventListener('hidden.bs.modal', function() {
                                document.getElementById('prodImage').src = "";
                                document.getElementById('prodName').value = "";
                                document.getElementById('prodCategory').value = "";
                                document.getElementById('prodPrice').value = "";
                                document.getElementById('prodQuantity').value = "";
                                document.getElementById('prodML').value = "";

                                document.getElementById('prodName').classList.remove('is-invalid');
                                document.getElementById('prodCategory').classList.remove('is-invalid');
                                document.getElementById('prodPrice').classList.remove('is-invalid');
                                document.getElementById('prodQuantity').classList.remove('is-invalid');
                                document.getElementById('prodML').classList.remove('is-invalid');
                            });
                        </script>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>