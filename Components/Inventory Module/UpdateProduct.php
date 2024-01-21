<?php
session_start();
include_once '../Database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodID = $_POST['prodID'];
    $prodName = $_POST['prodName'];
    $prodPrice = $_POST['prodPrice'];
    $prodQuantity = $_POST['prodQuantity'];
    $prodCategory = $_POST['prodCategory'];
    $prodML = $_POST['prodML'];
/* 
    $sql = "UPDATE pos_products SET product_name = '$prodName', category = '$prodCategory', price = '$prodPrice', quantity = '$prodQuantity', ml = '$prodML' WHERE id = '$prodID'";
    $result = mysqli_query($link, $sql); */

    $sql = "SELECT * FROM pos_products WHERE id = '$prodID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $OldprodID = $row['id'];
        $OldprodName = $row['product_name'];
        $OldprodPrice = $row['price'];
        $OldprodQuantity = $row['quantity'];
        $OldprodCategory = $row['category'];
        $OldprodML = $row['ml'];

        echo "Old Product ID: " . $OldprodID . "<br>";
        echo "Old Product Name: " . $OldprodName . "<br>";
        echo "Old Product Price: " . $OldprodPrice . "<br>";
        echo "Old Product Quantity: " . $OldprodQuantity . "<br>";
        echo "Old Product Category: " . $OldprodCategory . "<br>";
        echo "Old Product ML: " . $OldprodML . "<br>";
        echo "<br>";
        echo "New Product ID: " . $prodID . "<br>";
        echo "New Product Name: " . $prodName . "<br>";
        echo "New Product Price: " . $prodPrice . "<br>";
        echo "New Product Quantity: " . $prodQuantity . "<br>";
        echo "New Product Category: " . $prodCategory . "<br>";
        echo "New Product ML: " . $prodML . "<br>";

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}



?>