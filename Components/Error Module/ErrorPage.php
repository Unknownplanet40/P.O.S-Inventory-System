<?php


if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $ErrorCode = $_GET['Code'];

    if ($ErrorCode == 01){
        echo "Error 01: Error message here.";
    }
}

?>