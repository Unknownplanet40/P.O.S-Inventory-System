<?php
include_once '../Database/config.php';
session_start();

//recieve data from form using ajax post method
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $sql = "UPDATE customer_information SET Archived = 1 WHERE Cust_ID = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Record has been Removed! 1";
    } else {
        $_SESSION['message'] = "Something went wrong!" + mysqli_error($conn) + " 3";
    }
} else {
    $_SESSION['message'] = "Record has not been deleted! 2";
}
header("location: ./Customers.php");



?>