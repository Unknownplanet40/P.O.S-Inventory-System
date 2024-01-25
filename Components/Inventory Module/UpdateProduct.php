<?php
session_start();
include_once '../Database/config.php';

function UploadImage()
{
    global $conn, $prodID, $prodName, $prodImage;
    if ($prodImage != '') {
        $target_dir = "../../assets/Custom_Image/";
        $NewName = $prodName . '_' . $prodID;
        $target_file = $target_dir . basename($_FILES["changeImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $prodImage = $NewName . '.' . $imageFileType;
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $extensions_arr)) {
            $sql = "UPDATE pos_products SET image_path = '$prodImage' WHERE id = '$prodID'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                move_uploaded_file($_FILES['changeImage']['tmp_name'], $target_dir . $prodImage);
                return true;
            }
        } else if ($_FILES["changeImage"]["size"] > 5000000) {
            $_SESSION['Imageerror'] = "Image is too large! (Max: 5MB)";
            return false;
        } else {
            $_SESSION['Imageerror'] = "." . $imageFileType . " is not supported!";
            return false;
        }
    } else {
        return true;
    }
}

function compare($Old, $New)
{
    if ($Old == $New) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodID = $_POST['prodID'];
    $prodName = $_POST['prodName'];
    $prodPrice = $_POST['prodPrice'];
    $prodQuantity = $_POST['prodQuantity'];
    $prodCategory = $_POST['prodCategory'];
    $prodML = $_POST['prodML'];
    $prodImage = $_FILES['changeImage']['name'];

    $sql = "SELECT * FROM pos_products WHERE id = '$prodID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $OldprodName = $row['product_name'];
        $OldprodPrice = $row['price'];
        $OldprodQuantity = $row['quantity'];
        $OldprodCurrentStock = $row['CurrentStock'];
        $OldprodCurrentML = $row['Current_ML'];
        $OldprodCategory = $row['category'];
        $OldprodML = $row['ml'];
        $OldprodImage = $row['image_path'];

        // Check if there are any changes
        if (compare($OldprodName, $prodName) && compare($OldprodPrice, $prodPrice) && compare($OldprodCurrentStock, $prodQuantity) && compare($OldprodCategory, $prodCategory) && compare($OldprodML, $prodML)) {
            if ($prodImage != '') {
                if (UploadImage()) {
                    $_SESSION['message'] = "Image updated successfully! 1";
                } else {

                    $_SESSION['message'] = "Image was not updated! - " . $_SESSION['Imageerror'] . " 2";
                }
            } else {
                $_SESSION['message'] = "No changes were made! 1";
            }
        } else {

            if ($prodCategory == "Liquid") {
                if ($prodML <= $OldprodML){
                    $sql = "UPDATE pos_products SET product_name = '$prodName', price = '$prodPrice', quantity = '$prodQuantity', category = '$prodCategory', Current_ML = '$prodML', CurrentStock = '$prodQuantity' WHERE id = '$prodID'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (UploadImage()) {
                            $_SESSION['message'] = "Product updated successfully! 1";
                        } else {
                            $_SESSION['message'] = "Product updated successfully but Image was not updated! - " . $_SESSION['Imageerror'] . " 2";
                        }
                    } else {
                        $_SESSION['message'] = "Product was not updated! 3";
                    }
                } else {
                    $sql = "UPDATE pos_products SET product_name = '$prodName', price = '$prodPrice', quantity = '$prodQuantity', category = '$prodCategory', ml = '$prodML', Current_ML = '$prodML', CurrentStock = '$prodQuantity' WHERE id = '$prodID'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (UploadImage()) {
                            $_SESSION['message'] = "Product updated successfully! 1";
                        } else {
                            $_SESSION['message'] = "Product updated successfully but Image was not updated! - " . $_SESSION['Imageerror'] . " 2";
                        }
                    } else {
                        $_SESSION['message'] = "Product was not updated! 3";
                    }
                }
            } else {
                if ($prodQuantity <= $OldprodQuantity){
                    $sql = "UPDATE pos_products SET product_name = '$prodName', price = '$prodPrice', CurrentStock = '$prodQuantity', category = '$prodCategory', ml = '0', Current_ML = '0' WHERE id = '$prodID'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (UploadImage()) {
                            $_SESSION['message'] = "Product updated successfully! 1";
                        } else {
                            $_SESSION['message'] = "Product updated successfully but Image was not updated! - " . $_SESSION['Imageerror'] . " 2";
                        }
                    } else {
                        $_SESSION['message'] = "Error: Product was not updated! 3";
                    }
                } else {
                    $sql = "UPDATE pos_products SET product_name = '$prodName', price = '$prodPrice', quantity = '$prodQuantity', CurrentStock = '$prodQuantity', category = '$prodCategory', ml = '0', Current_ML = '0' WHERE id = '$prodID'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (UploadImage()) {
                            $_SESSION['message'] = "Product updated successfully! 1";
                        } else {
                            $_SESSION['message'] = "Product updated successfully but Image was not updated! - " . $_SESSION['Imageerror'] . " 2";
                        }
                    } else {
                        $_SESSION['message'] = "Error: Product was not updated! 3";
                    }
                }
            }
        }
    } else {
        $_SESSION['message'] = "Product does not exist! 3";
    }
}
$conn->close();
header("Location: ./Products.php");
