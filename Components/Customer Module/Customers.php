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
    <link rel="stylesheet" href="../../DataTables/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../../Style/SA2-BS4.css" />
    <link rel="stylesheet" href="../../Style/sidebars.css" />

    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <script src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/sidebars.js"></script>

    <script defer src="../../DataTables/js/jquery-3.7.0.js"></script>
    <script defer src="../../DataTables/js/jquery.dataTables.min.js"></script>
    <script defer src="../../DataTables/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="../../Script/Customers.js"></script>


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

<body>
    <div class="parent">
        <div class="div1">
            <?php require_once '../SmallSidebar.php'; ?>
        </div>
        <div class="div2">
            <main>
                <div class="container-xxl py-3">
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

                            $sql = "SELECT * FROM customer_information";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['Cust_ID']; ?></td>
                                        <td><?php echo $row['Cust_first_name']; ?> <?php echo $row['Cust_last_name']; ?></td>
                                        <td><?php echo $row['Cust_number']; ?></td>
                                        <td><?php echo $row['Cust_Address']; ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCustomer">&#9998;</i></button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="">&#10006;</i></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }




                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>