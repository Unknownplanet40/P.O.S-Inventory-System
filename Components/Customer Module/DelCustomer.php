<?php
include_once '../Database/config.php';
session_start();

//recieve data from form using ajax post method
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $sql = "UPDATE customer_information SET Archived = 1 WHERE Cust_ID = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Record has been Removed!";
    } else {
        $_SESSION['message'] = "Something went wrong!" + mysqli_error($conn);
    }
} else {
    $_SESSION['message'] = "Record has not been deleted!";
}
header("location: ./Customers.php");



?>