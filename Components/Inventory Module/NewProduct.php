<?php
include_once '../Database/config.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodName = $_POST['ItemName'];
    $prodPrice = $_POST['ItemPrice'];
    $prodQuantity = $_POST['ItemQuantity'];
    $prodCategory = $_POST['ItemCategory'];
    $prodImage = $_FILES['ItemImage']['name'];

    // get the last id
    $sql = "SELECT id FROM pos_products ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $prodID = $row['id'] + 1;


    if ($prodCategory == 'Liquid') {
        $prodML = $_POST['ItemML'];
        $prodperML = $_POST['perOrder'];

        if ($prodImage != '') {
            $target_dir = "../../assets/Custom_Image/";
            $NewName = $prodName . '_' . $prodCategory;
            $target_file = $target_dir . basename($_FILES["ItemImage"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $prodImage = $NewName . '.' . $imageFileType;
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $extensions_arr)) {
                $sql = "INSERT INTO pos_products (id, product_name, category, price, quantity, ml, perML_order, image_path, Current_ML, CurrentStock) VALUES ('$prodID', '$prodName', '$prodCategory', '$prodPrice', '$prodQuantity', '$prodML', '$prodperML', '$prodImage', '$prodML', '$prodQuantity')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    move_uploaded_file($_FILES['ItemImage']['tmp_name'], $target_dir . $prodImage);
                    $_SESSION['message'] = "Product added successfully! 1";
                } else {
                    $_SESSION['message'] = "Product added failed! 3";
                }
            } else if ($_FILES["ItemImage"]["size"] > 5000000) {
                $_SESSION['message'] = "Product added failed! - Image is too large! (Max: 5MB) 3";
            } else {
                $_SESSION['message'] = "Product added failed! - ." . $imageFileType . " is not supported! 3";
            }
        } else {
            $sql = "INSERT INTO pos_products (id, product_name, category, price, quantity, ml, perML_order, Current_ML, CurrentStock) VALUES ('$prodID', '$prodName', '$prodCategory', '$prodPrice', '$prodQuantity', '$prodML', '$prodperML', '$prodML', '$prodQuantity')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['message'] = "Product added successfully! 1";
            } else {
                $_SESSION['message'] = "Product added failed! 3";
            }
        }
    } else {
        if ($prodImage != '') {
            $target_dir = "../../assets/Custom_Image/";
            $NewName = $prodName . '_' . $prodCategory;
            $target_file = $target_dir . basename($_FILES["ItemImage"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $prodImage = $NewName . '.' . $imageFileType;
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            if (in_array($imageFileType, $extensions_arr)) {
                $sql = "INSERT INTO pos_products (id product_name, category, price, quantity, image_path, CurrentStock, Current_ML, perML_order, ml) VALUES ('$prodID', '$prodName', '$prodCategory', '$prodPrice', '$prodQuantity', '$prodImage', '$prodQuantity', '0', '0', '0')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    move_uploaded_file($_FILES['ItemImage']['tmp_name'], $target_dir . $prodImage);
                    $_SESSION['message'] = "Product added successfully! 1";
                } else {
                    $_SESSION['message'] = "Product added failed! 3";
                }
            } else if ($_FILES["ItemImage"]["size"] > 5000000) {
                $_SESSION['message'] = "Product added failed! - Image is too large! (Max: 5MB) 3";
            } else {
                $_SESSION['message'] = "Product added failed! - ." . $imageFileType . " is not supported! 3";
            }
        } else {
            $sql = "INSERT INTO pos_products (id, product_name, category, price, quantity, CurrentStock, Current_ML, perML_order, ml) VALUES ('$prodID', '$prodName', '$prodCategory', '$prodPrice', '$prodQuantity', '$prodQuantity', '0', '0', '0')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['message'] = "Product added successfully! 1";
            } else {
                $_SESSION['message'] = "Product added failed! 3";
            }
        }
    }
} else {
    $_SESSION['message'] = "Product does not exist! 3";
}

header("Location: ./Products.php");
?>