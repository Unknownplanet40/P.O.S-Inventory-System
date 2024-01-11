<?php
require_once '../Components/Database/config.php';
session_start();
date_default_timezone_set('Asia/Manila');

$sql = "SELECT * FROM account WHERE UUID = '" . $_SESSION['UUID'] . "';";
$result = mysqli_query($conn, $sql);



if ($result) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['profile'] = $row['profile'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['dateCreated'] = $row['date_created'];
    $_SESSION['lastUpdated'] = $row['last_accessed'];
    $_SESSION['isLogin'] = $row['isLogin'];

    // role
    // 0 - admin
    // 1 - staff

    // status
    // 0 - archived
    // 1 - active
    // 2 - inactive
    // 3 - suspended
    // 4 - locked

    if (isset($_SESSION['currentlyLoggedIn']) && $_SESSION['currentlyLoggedIn'] == true) {
        if ($_SESSION['currentlyLoggedInAs'] == $_SESSION['UUID']) {
            if ($_SESSION['status'] == 0) {
                $_SESSION['statusNotif'] = "Your account has been <b>Removed</b>. Please contact the administrator <a style=' text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
                $_SESSION['ColorCode'] = "Text-danger";
                header("Location: ./Login Module/LoginPage.php");
            } else if ($_SESSION['status'] == 1) {
                if ($_SESSION['role'] == 0) {

                    $sql = "UPDATE account SET last_accessed = NOW(), isLogin = 1 WHERE UUID = '" . $_SESSION['UUID'] . "';";
                    $result = mysqli_query($conn, $sql);

                    $_SESSION['isLogin'] = 1;
                    $_SESSION['lastUpdated'] = date("Y-m-d H:i:s");
                    $_SESSION['currentlyLoggedIn'] = true;
                    $_SESSION['currentlyLoggedInAs'] = $_SESSION['UUID'];

                    if ($result) {
                        header("Location: ./Dashboard.php");
                    } else {
                        echo "<script>console.log('Failed to execute query: " . mysqli_error($conn) . "');</script>";
                    }
                } else if ($_SESSION['role'] == 1) {
                    echo "Staff";
                } else {
                    $_SESSION['statusNotif'] = "Your account have a invalid privilege.";
                    $_SESSION['ColorCode'] = "Text-danger";
                    header("Location: ./Login Module/LoginPage.php");
                }
            } else if ($_SESSION['status'] == 2) {
                $_SESSION['statusNotif'] = "Your account has been <b>Deactivated</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
                $_SESSION['ColorCode'] = "Text-dark";
                header("Location: ./Login Module/LoginPage.php");
            } else if ($_SESSION['status'] == 3) {
                $_SESSION['statusNotif'] = "Your account has been <b>Suspended</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
                $_SESSION['ColorCode'] = "Text-primary";
                header("Location: ./Login Module/LoginPage.php");
            } else if ($_SESSION['status'] == 4) {
                $_SESSION['statusNotif'] = "Your account has been <b>Locked</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
                $_SESSION['ColorCode'] = "Text-secondary";
                header("Location: ./Login Module/LoginPage.php");
            } else {
                $_SESSION['statusNotif'] = "It seems that your account has been <b>Corrupted</b>.";
                $_SESSION['ColorCode'] = "Text-muted";
                header("Location: ./Login Module/LoginPage.php");
            }
        } else {
            $_SESSION['statusNotif'] = "You can't log in due to an active session. Try another browser (e.g., Incognito or Private mode) or wait until the user logs out.";
            $_SESSION['ColorCode'] = "Text-muted";
            header("Location: ./Login Module/LoginPage.php");
        }
    } else {
        if ($_SESSION['status'] == 0) {
            $_SESSION['statusNotif'] = "Your account has been <b>Removed</b>. Please contact the administrator <a style=' text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
            $_SESSION['ColorCode'] = "Text-danger";
            header("Location: ./Login Module/LoginPage.php");
        } else if ($_SESSION['status'] == 1) {
            if ($_SESSION['role'] == 0) {

                $sql = "UPDATE account SET last_accessed = NOW(), isLogin = 1 WHERE UUID = '" . $_SESSION['UUID'] . "';";
                $result = mysqli_query($conn, $sql);

                $_SESSION['isLogin'] = 1;
                $_SESSION['lastUpdated'] = date("Y-m-d H:i:s");
                $_SESSION['currentlyLoggedIn'] = true;
                $_SESSION['currentlyLoggedInAs'] = $_SESSION['UUID'];

                if ($result) {
                    header("Location: ./Dashboard.php");
                } else {
                    echo "<script>console.log('Failed to execute query: " . mysqli_error($conn) . "');</script>";
                }
            } else if ($_SESSION['role'] == 1) {
                echo "Staff";
            } else {
                $_SESSION['statusNotif'] = "Your account have a invalid privilege.";
                $_SESSION['ColorCode'] = "Text-danger";
                header("Location: ./Login Module/LoginPage.php");
            }
        } else if ($_SESSION['status'] == 2) {
            $_SESSION['statusNotif'] = "Your account has been <b>Deactivated</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
            $_SESSION['ColorCode'] = "Text-dark";
            header("Location: ./Login Module/LoginPage.php");
        } else if ($_SESSION['status'] == 3) {
            $_SESSION['statusNotif'] = "Your account has been <b>Suspended</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
            $_SESSION['ColorCode'] = "Text-primary";
            header("Location: ./Login Module/LoginPage.php");
        } else if ($_SESSION['status'] == 4) {
            $_SESSION['statusNotif'] = "Your account has been <b>Locked</b>. Please contact the administrator <a style='text-decoration: none;' href='<?php echo $base_url; ?>'>here</a> to restore your account.";
            $_SESSION['ColorCode'] = "Text-secondary";
            header("Location: ./Login Module/LoginPage.php");
        } else {
            $_SESSION['statusNotif'] = "It seems that your account has been <b>Corrupted</b>.";
            $_SESSION['ColorCode'] = "Text-muted";
            header("Location: ./Login Module/LoginPage.php");
        }
    }

} else {
    echo "<script>console.log('Failed to execute query: " . mysqli_error($conn) . "');</script>";
    error_log("Validation.php: " + mysqli_error($conn), 3, '../Error-Log.log');
}
mysqli_close($conn);