<?php
include_once '../Database/config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['Firstnametxt'];
    $lname = $_POST['Lastnametxt'];
    $contact = $_POST['Contacttxt'];
    $address = $_POST['Addresstxt'];

    $sql = "INSERT INTO `customer_information`(`Cust_ID`, `Cust_first_name`, `Cust_last_name`, `Cust_number`, `Cust_Address`, `Date`) VALUES ('','$fname','$lname','$contact','$address',CURRENT_TIMESTAMP)";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Customer Added Successfully 1";
    } else {
        $_SESSION['message'] = "Something went wrong, Customer not added 3";
    }
} else {
    $_SESSION['message'] = "Something went wrong, No data received 2";
}
header("Location: ./Customers.php");
