<?php
session_start();
include_once '../Database/config.php';

function UploadImage(){
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
            return false;
        } else {
            return false;
        }
    } else {
        return true;
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
        $OldprodCategory = $row['category'];
        $OldprodML = $row['ml'];
        $OldprodImage = $row['image_path'];

        if ($OldprodCategory != $prodCategory) {
            $sql = "UPDATE pos_products SET category = '$prodCategory' WHERE id = '$prodID'";
            $result = mysqli_query($conn, $sql);
        }

    }
}
$conn->close();
header("Location: ./Products.php");
?>
