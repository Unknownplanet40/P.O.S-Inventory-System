<?php
include_once '../Database/config.php';
session_start();

print_r($_SESSION);

if (isset($_SESSION['UUID'])){
    $sql = "UPDATE account SET isLogin = 0 WHERE UUID = '" . $_SESSION['UUID'] . "';";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        if (file_exists('../../dump/')) {
            $files = glob('../../dump/*'); // get all file names
            foreach ($files as $file) { // iterate files
                if (is_file($file)) {
                    error_log("Deleting file: " . $file . "\n", 3, "../../Error-Log.log");
                }
            }
        }

        // remove all session variables
        session_unset();
        session_destroy();
        session_regenerate_id(true);

        header("Location: ./LoginPage.php");
    } else {
        echo "<script>console.log('Failed to execute query: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>console.error('Session is not set.');</script>";
}
?>