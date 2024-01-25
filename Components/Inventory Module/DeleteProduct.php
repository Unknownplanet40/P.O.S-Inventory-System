<?php
include_once '../Database/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $prodID = $_GET['id'];
    $sql = "UPDATE pos_products SET Achieved = 1 WHERE id = '$prodID'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['message'] = "Archived successfully! 1";
    } else {
        $_SESSION['message'] = "Archived failed! 2";
    }
} else {
    $_SESSION['message'] = "Something went wrong! 2";
}
header("Location: ./Products.php");
