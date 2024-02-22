<?php
include_once '../Database/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $TID = $_GET['tid'];
    $stat = $_GET['status'];

    if ($stat == 1) {
        $sql = "UPDATE transaction_history SET status = '$stat' WHERE TID = $TID";
    } else if ($stat == 2) {
        $sql = "UPDATE transaction_history SET status = '$stat' WHERE TID = $TID";
    } else if ($stat == 3) {
        $sql = "UPDATE transaction_history SET status = '$stat' WHERE TID = $TID";
    } else if ($stat == 4) {
        $sql = "UPDATE transaction_history SET status = '$stat' WHERE TID = $TID";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['message'] = "Status Changed Successfully 1";
    } else {
        $_SESSION['message'] = "Something went wrong, Couldn't change status 2 ";
    }
} else {
    $_SESSION['message'] = "Something went wrong, No data received 2";
}
header("Location: ./Transaction.php");
