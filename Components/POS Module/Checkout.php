<?php
session_start();
// Retrieve JSON data from the request
$jsonData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($jsonData, true);

// Check if decoding was successful
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    die('Invalid JSON data');
}
/* 
$requiredFields = ['SelectedItemID', 'SelectedItemName', 'SelectedItemPrice', 'SelectedItemQuantity'];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400); // Bad Request
        die("Missing required field: $field");
    }
}
 */

// Get the values of the required fields
$SelectedItemID = $data['SelectedItemID'];
$SelectedItemName = $data['SelectedItemName'];
$SelectedItemPrice = $data['SelectedItemPrice'];
$SelectedItemQuantity = $data['SelectedItemQuantity'];
$totalofitemsprice = [];
$overalltotal = 0;
$Items = [];
$isSuccessTransaction = false;
$Message = "";
$randomTransactionID = rand(100000, 999999);
$washed = "";

foreach ($SelectedItemPrice as $key => $value) {
    $totalofitemsprice[$key] = $SelectedItemPrice[$key] * $SelectedItemQuantity[$key];
    $overalltotal += $totalofitemsprice[$key];

    $name = $SelectedItemName[$key];
    $price = $SelectedItemPrice[$key];
    $quantity = $SelectedItemQuantity[$key];

    $Items[] = $quantity . "x " . $name . " - " . $price . " = " . $totalofitemsprice[$key];

    //check SelectedItemName if Contains "Wash Only",Dry Only, or "Wash and Dry"
    if (strpos($SelectedItemName[$key], 'Wash Only') !== false) {
        $washed = "1";
    } else if (strpos($SelectedItemName[$key], 'Dry Only') !== false) {
        $washed = "2";
    } else if (strpos($SelectedItemName[$key], 'Wash and Dry') !== false) {
        $washed = "2";
    }
}

$CustName = $data['CustomerName'];
$contact = $data['CustomerNumber'];
$address = $data['CustomerAddress'];
$Existing = $data['ExistingCustomer'];

if ($CustName == null) {
    $CustName = "Unknown Customer";
}


$sconn = mysqli_connect("localhost", "administrator", "4OxUI77d6]2(dedq", "mls_database");

foreach ($SelectedItemID as $key => $value) {
    $id = $SelectedItemID[$key];
    $quantity = $SelectedItemQuantity[$key];

    $sql = "SELECT * FROM pos_products WHERE id = '$id'";
    $result = mysqli_query($sconn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['category'] == "Liquid") {
            $ml = $quantity * $row['perML_order'];
            $dbml = $row['Current_ML'];
            if (($dbml - $ml) <= 0) {
                $oldml = $row['ml'];
                $sql = "UPDATE pos_products SET Current_ML = '$oldml', CurrentStock = CurrentStock - 1 WHERE id = '$id'";
            } else {
                $sql = "UPDATE pos_products SET Current_ML = Current_ML - '$ml' WHERE id = '$id'";
            }
        } else {
            $sql = "UPDATE pos_products SET CurrentStock = CurrentStock - '$quantity' WHERE id = '$id'";
        }
        $result = mysqli_query($sconn, $sql);
    } else {
        $isSuccessTransaction = false;
        $Message = "Error: " . mysqli_error($sconn);
    }
}

if ($Existing) {
    $Items = implode(", ", $Items);
    $sql = "INSERT INTO `transaction_history`(`TID`, `RTID`, `Items`, `Overall`, `Date_Issued`, `Issued_By`, `Issued_To`, `WashType`) VALUES ('','$randomTransactionID', '$Items','$overalltotal',CURRENT_TIMESTAMP,'" . $_SESSION['UUID'] . "','$contact','$washed')";
    $result = mysqli_query($sconn, $sql);

    if ($result) {
        $isSuccessTransaction = true;
        $Message = "Transaction Successful!";
    } else {
        $isSuccessTransaction = false;
        $Message = "Error: " . mysqli_error($sconn);
    }
} else {
    $Fname = explode(" ", $CustName)[0];
    $Lname = explode(" ", $CustName)[1];

    $sql = "INSERT INTO `customer_information`(`Cust_ID`, `Cust_first_name`, `Cust_last_name`, `Cust_number`, `Cust_Address`) VALUES ('','$Fname','$Lname','$contact','$address')";
    $result = mysqli_query($sconn, $sql);

    if ($result) {
        $Items = implode(", ", $Items);
        $sql = "INSERT INTO `transaction_history`(`TID`, `RTID`, `Items`, `Overall`, `Date_Issued`, `Issued_By`, `Issued_To`, `WashType`) VALUES ('', '$randomTransactionID' ,'$Items','$overalltotal',CURRENT_TIMESTAMP,'" . $_SESSION['UUID'] . "','$contact','$washed')";
        $result = mysqli_query($sconn, $sql);
        if ($result) {
            $isSuccessTransaction = true;
            $Message = "New Customer and Transaction Successful!";
        } else {
            $isSuccessTransaction = false;
            $Message = "Error: " . mysqli_error($sconn);
        }
    } else {
        $isSuccessTransaction = false;
        $Message = "Error: " . mysqli_error($sconn);
    }
}

$sql = "SELECT * FROM transaction_history WHERE RTID = '$randomTransactionID'";
$result = mysqli_query($sconn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $WT = $row['WashType'];
}

header('Content-Type: application/json');
if ($isSuccessTransaction) {
    // Return a response

    echo json_encode([
        'title' => 'Success',
        'text' => $Message,
        'icon' => 'success',
        'total' => $overalltotal,
        'TID' => $randomTransactionID,
        'items' => $Items
    ]);
} else {
    echo json_encode([
        'title' => 'Error',
        'text' => $Message,
        'icon' => 'error'
    ]);
}
