<?php
include_once '../Database/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // seperate first name and last name
    $name = explode(" ", $name);
    $fname = $name[0];
    $lname = $name[1];

    $sql = "UPDATE `customer_information` SET `Cust_first_name`='$fname',`Cust_last_name`='$lname',`Cust_number`='$contact',`Cust_Address`='$address' WHERE `Cust_ID`='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Customer Updated Successfully 1";
    } else {
        $_SESSION['message'] = "Something went wrong, Customer not updated 3";
    }

} else {
    $_SESSION['message'] = "Something went wrong, No data received 2";
}
header("Location: ./Customers.php");



?>