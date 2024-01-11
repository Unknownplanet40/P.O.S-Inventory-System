<?php
// No need to modify this file unless you know what you're doing.
// RJC Dec, 13. 2023
// last modified: RJC Jan, 07. 2023

$dbhost = "localhost";
$dbusername = "administrator";
$dbpassword = "4OxUI77d6]2(dedq";
$dbname = "mls_database";

try {
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if ($conn) {
        echo "<script>console.log('The database is connected successfully.');</script>";
        $connectionError = "";
    } else {
        echo "<script>console.log('Failed to connect to database.');</script>";
        $connectionError = "dberror";
    }
} catch (\Throwable $th) {
    $connectionError = $th->getMessage();
    echo "<script>console.log('" . $connectionError . "');</script>";
    if (strpos($connectionError, "Access denied for user") !== false) {
        $connectionError = "Invalid Database Credentials.";
    } else if (strpos($connectionError, "Unknown database") !== false) {
        $connectionError = "Database not found. Verify the name and configuration.";
    } else if (strpos($connectionError, "No such host is known") !== false) {
        $connectionError = " Failed to get address info. No such host is known";
    } else if (strpos($connectionError, "connection attempt failed") !== false){
        $connectionError = "A connection attempt timed out or failed due to unresponsive host.";
    } else if (strpos($connectionError, "No connection could be made") !== false){
        $connectionError = "Connection refused by the target machine.";
    }
}
?>