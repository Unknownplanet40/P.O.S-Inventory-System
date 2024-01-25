<?php
include_once '../Database/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodID = $_POST['prodID'];
    $sql = "UPDATE pos_products SET Achieved = 0 WHERE id = '$prodID'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['message'] = "Unarchived successfully! 1";
    } else {
        $_SESSION['message'] = "Unarchived failed! 2";
    }
} else{
    $_SESSION['message'] = "Something went wrong! 2";
}
header("Location: ./Products.php");
?>