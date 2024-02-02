<?php
include_once '../Database/config.php';
session_start();

$Completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(Status) AS stat FROM transaction_history WHERE Status = 3"))['stat'];

$sql = "SELECT SUM(Overall) AS total, COUNT(TID) AS Trans FROM transaction_history WHERE DATE(Date_Issued) = CURDATE()";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $overallSum = $row['total'];
    $transCount = $row['Trans'];

    if ($overallSum == null) {
        $overallSum = 0;
    }
} else {
    $overallSum = 0;
    $transCount = 0;
}




?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Transaction History Module" />
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
    <script defer src="../../Script/Transaction.js"></script>

    <title>Customer Information</title>
    <?php include_once '../../assets/Icons.php'; ?>
</head>

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

    .nav-link {
        color: var(--txtColor) !important;
        border-radius: 0.25rem;
    }

    .nav-link:hover {
        color: #ffcd00 !important;
        background-color: #a8342d !important;
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

    .div2 {
        background-image: url('../../assets/BGCustomer.svg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;

    }

    [type="search"][aria-controls="TransactionTBL"] {
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        box-shadow: none;
        min-width: 350px !important;
        height: 35px !important;
    }

    [type="search"][aria-controls="TransactionTBL"]:focus {
        outline: none;
        box-shadow: none;
        border-color: #ffcd00;
    }

    [type="search"][aria-controls="TransactionTBL"]::placeholder {
        color: --var(txtColor);
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

    <?php
    if (isset($_SESSION['message'])) {
        if (strpos($_SESSION['message'], '1') !== false) {
            // remove the last number from the string
            $_SESSION['message'] = substr($_SESSION['message'], 0, -1);
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
        } else if (strpos($_SESSION['message'], '2') !== false) {
            // remove the last number from the string
            $_SESSION['message'] = substr($_SESSION['message'], 0, -1);
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
                    icon: 'warning',
                    title: '<?php echo $_SESSION['message']; ?>'
                })
            </script>
        <?php
        } else if (strpos($_SESSION['message'], '3') !== false) {
            // remove the last number from the string
            $_SESSION['message'] = substr($_SESSION['message'], 0, -1);
        ?>
            <script>
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).fire({
                    icon: 'error',
                    title: '<?php echo $_SESSION['message']; ?>'
                })
            </script>
    <?php
        }
        unset($_SESSION['message']);
    }
    ?>

    <div class="parent">
        <div class="div1">
            <?php require_once '../SmallSidebar.php'; ?>
        </div>
        <div class="div2 m-2">
            <div class="container-xxl">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <h2 class="text-center m-3 pt-2"><?php echo $Completed; ?></h2>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Completed</h5>
                                        <p class="card-text"><small class="text-body-secondary">Total Completed Transactions</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <h2 class="text-center m-3 pt-2"><?php echo $transCount; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Transactions</h5>
                                        <p class="card-text"><small class="text-body-secondary">Total Transactions for the Day</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <h2 class="text-center m-3 pt-2">&#8369; <?php echo number_format($overallSum, 2); ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h5 class="card-title">Sale for the Day</h5>
                                        <p class="card-text"><small class="text-body-secondary">Total Sale for the Day</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center" id="spinner" style="margin-top: 10rem;">
                <span class="loader"></span>
            </div>
            <div class="container-xxl bg-body p-3">
                <table id="TransactionTBL" class="display d-none" style="width:100%">
                    <thead>
                        <tr>
                            <th>TID</th>
                            <th>Receipt</th>
                            <th>Item Total</th>
                            <th>Issued By</th>
                            <th>Issued To</th>
                            <th>Issued Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM transaction_history";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $receipt = explode("-", $row['Items']);
                                $receipt = $receipt[0];

                                // new date format for Date_Issued Jan 2, 2023
                                $date = date_create($row['Date_Issued']);
                                $date = date_format($date, "M j, Y");

                                // Fetch the name for Issued_By
                                $issuedByNameResult = mysqli_query($conn, "SELECT name FROM account WHERE UUID = '" . mysqli_real_escape_string($conn, $row['Issued_By']) . "'");
                                $issuedByName = ($issuedByNameResult) ? mysqli_fetch_assoc($issuedByNameResult)['name'] : "Unknown";

                                // Fetch the name for Issued_To
                                $issuedToNameResult = mysqli_query($conn, "SELECT CONCAT(Cust_first_name, ' ', Cust_last_name) AS name FROM customer_information WHERE Cust_number = '" . mysqli_real_escape_string($conn, $row['Issued_To']) . "'");
                                $issuedToName = ($issuedToNameResult) ? mysqli_fetch_assoc($issuedToNameResult)['name'] : $row['Issued_To'];
                        ?>
                                <tr>
                                    <td><?php echo $row['TID']; ?></td>
                                    <td><?php echo $receipt; ?></td>
                                    <td><?php echo $row['Overall']; ?></td>
                                    <td><?php echo $issuedByName; ?></td>
                                    <td><?php echo $issuedToName; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td>
                                        <select class="form-select form-select-sm" aria-label="Default select example" id="action<?php echo $row['TID']; ?>">
                                            <option disabled selected hidden></option>
                                            <option value="1" <?php echo ($row['Status'] == 1) ? 'selected' : ''; ?>>Pending</option>
                                            <option value="2" <?php echo ($row['Status'] == 2) ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="3" <?php echo ($row['Status'] == 3) ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                        <script>
                                            document.getElementById('action<?php echo $row['TID']; ?>').addEventListener('change', function() {
                                                var action = document.getElementById('action<?php echo $row['TID']; ?>').value;
                                                console.log(action);
                                                var tid = <?php echo $row['TID']; ?>;

                                                if (action == 1) {
                                                    Swal.fire({
                                                        text: "Change status to Pending?",
                                                        icon: 'warning',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        confirmButtonText: 'Yes, change it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "./ChangeStatus.php?tid=" + tid + "&status=1";
                                                        }
                                                    });
                                                } else if (action == 2) {
                                                    Swal.fire({
                                                        text: "Change status to In Progress?",
                                                        icon: 'warning',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        confirmButtonText: 'Yes, change it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "./ChangeStatus.php?tid=" + tid + "&status=2";
                                                        }
                                                    });
                                                } else if (action == 3) {
                                                    Swal.fire({
                                                        text: "Change status to Completed?",
                                                        icon: 'warning',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        confirmButtonText: 'Yes, change it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "./ChangeStatus.php?tid=" + tid + "&status=3";
                                                        }
                                                    });
                                                } else {
                                                    return;
                                                }

                                            });
                                        </script>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>