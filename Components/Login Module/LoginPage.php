<?php
include_once '../Database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM accounts WHERE username = '$username';";
    $query .= "SELECT * FROM accounts WHERE password = '$password';";

    $result = mysqli_multi_query($conn, $query);

    if ($result) {
        $firstResult = mysqli_store_result($conn);
        mysqli_next_result($conn);
        $secondResult = mysqli_store_result($conn);
        if ($firstResult->num_rows > 0 && $secondResult->num_rows > 0) {
            session_start();

            $sql = "SELECT * FROM accounts WHERE username = '$username' AND password = '$password';";
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $_SESSION['user_name'] = $row['Username'];
            $_SESSION['user_pass'] = $row['Password'];
            $_SESSION['Role'] = $row['Role'];

            header("Location: ../Dashboard.php");
            
        } else if ($firstResult->num_rows > 0 && $secondResult->num_rows == 0) {
            $error = "Invalid password.";
        } else {
            $error = "Invalid username or password.";
        }
        echo "<script>console.log('Queries executed successfully.');</script>";
    } else {
        echo "<script>console.log('Failed to execute queries: " . mysqli_error($conn) . "');</script>";
    }

    // Close connection
    $conn->close();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="This is a Sidebar for Dashboard" />
    <meta name="author" content="Ryan James Capadocia, Jeric Dayandante, James Matthew Veloria" />
    <title>Manlalaba Laundry Station</title>
    <link rel="stylesheet" href="../../Style/Bootstrap-css/bootstrap.css">
    <link rel="stylesheet" href="../../Style/Login.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-7 intro-section">
                <div class="brand-wrapper">
                    <h1><a><img src="../../assets/Logo.svg" width="48" alt="" srcset=""></a></h1>
                </div>
                <div class="intro-content-wrapper">
                    <h1 class="intro-title">Manlalaba Laundry Station</h1>
                    <p class="intro-text">Where Cleanliness Meets Convenience.</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-5 form-section">
                <div class="login-wrapper">
                    <h2 class="login-title">Log in</h2>
                    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" class="form login-form">
                        <p class="form-text text-center" id="reminder">Please Input Username and Password</p>
                        <div class="form-group">
                            <label for="email" class="sr-only" hidden>Username</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="sr-only" hidden>Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Password">
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input"> <span class="form-checkbox-text">Show
                                    password</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <input name="login" id="login" class="btn login-btn" type="submit" value="Login">
                            <a href="#!" class="forgot-password-link">Password?</a>
                        </div>
                    </form>
                    <p class="mute-text text-center text-danger" id="error">
                        <?php if (isset($error))
                            echo $error; ?>&nbsp
                    </p>
                    <p class="login-wrapper-footer-text visually-hidden">Need an account? <a href="#!"
                            class="text-reset">Signup
                            here</a></p>
                    <script>
                        // remove content of error message after 5 seconds
                        setTimeout(() => {
                            document.getElementById('error').innerHTML = "&nbsp";
                        }, 5000);


                        // disable login button if username or password is empty
                        document.getElementById('login').disabled = true;


                        // Function to check if email and password are not empty
                        function checkInputFields() {
                            var emailValue = document.getElementById('email').value;
                            var passwordValue = document.getElementById('password').value;

                            if (emailValue !== "" || passwordValue !== "") {
                                document.getElementById('login').disabled = false;
                                document.getElementById('reminder').innerHTML = "&nbsp;";
                            } else {
                                document.getElementById('login').disabled = true;
                                document.getElementById('reminder').innerHTML = "Please Input Username and Password";
                            }
                        }

                        // Attach the function to both email and password input events
                        document.getElementById('email').addEventListener('keyup', checkInputFields);
                        document.getElementById('password').addEventListener('keyup', checkInputFields);

                    </script>
                    <p class="text-center text-muted mt-5 mb-0">Username: admin | Password: admin123</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>