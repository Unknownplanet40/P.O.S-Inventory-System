<?php
include_once '../Database/config.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM account WHERE username = '$username';";
    $query .= "SELECT * FROM account WHERE password = '$password';";

    $result = mysqli_multi_query($conn, $query);

    if ($result) {
        $UsernameResult = mysqli_store_result($conn);
        mysqli_next_result($conn);
        $PasswordResult = mysqli_store_result($conn);
        if ($UsernameResult->num_rows > 0 && $PasswordResult->num_rows > 0) {
            $sql = "SELECT UUID FROM account WHERE username = '$username' AND password = '$password';";
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            $_SESSION['UUID'] = $row['UUID'];
            header("Location: ../Validation.php");
        } elseif ($UsernameResult->num_rows > 0 && $PasswordResult->num_rows == 0) {
            $error = "Invalid password.";
        } elseif ($UsernameResult->num_rows == 0 && $PasswordResult->num_rows > 0) {
            $error = "Invalid username or password.";
        } else {
            $error = "Invalid username and password.";
        }
    } else {
        echo "<script>console.error('Failed to execute queries: " . mysqli_error($conn) . "');</script>";
    }
    // Close connection
    $conn->close();
}

if (isset($_SESSION['statusNotif']) && $_SESSION['statusNotif'] != "") {
    $notice = $_SESSION['statusNotif'];
    $show = $_SESSION['ColorCode'];
    unset($_SESSION['statusNotif']);
    unset($_SESSION['ColorCode']);
} else {
    $show = "visually-hidden";
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
    <link rel="stylesheet" href="../../Style/SA2-BS4.css">
    <script src="../../Script/sweetalert2.all.min.js"></script>
    <script defer src="../../Script/Bootstrap-js/bootstrap.bundle.js"></script>
    <style>
        .swal2-timer-progress-bar {
            background-color: #ffcd00 !important;
        }
    </style>
    <script>

    </script>
</head>

<body>
    <?php
    if (strpos($connectionError, "dberror") !== false || $connectionError != "") {
        echo '
        <script>
            Swal.mixin({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 10500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }).fire({
            icon: "error",
            title: "' . $connectionError . '"
        });
        </script>';
    }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="Passreset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-md-7 intro-section">
                <div class="brand-wrapper">
                    <h1 class="pt-0"><img src="../../assets/Logo.svg" width="48" alt="" srcset=""></h1>
                </div>
                <div class="intro-content-wrapper">
                    <h1 class="intro-title">Manlalaba Laundry Station</h1>
                    <p class="intro-text">Where Cleanliness Meets Convenience.</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-5 form-section">
                <div class="login-wrapper">
                    <div class="pb-5">
                        <h2 class="text-center mb-1 fs-2 day" id="day">what does the fox say?</h2>
                        <h2 class="text-center mt-1 fs-5 time" id="time">Ring-ding-ding-ding-dingeringeding!</h2>
                    </div>
                    <h2 class="login-title">Login</h2>
                    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" class="form login-form">
                        <div class="form-group">
                            <label for="email" class="sr-only" hidden>Username</label>
                            <input type="text" name="email" id="email" class="form-control uname" placeholder="Username">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="sr-only" hidden>Password</label>
                            <input type="password" name="password" id="password" class="form-control pword" placeholder="Password">
                            <div class="form-check mt-2">
                                <label class="form-check-label" for="SpCb">Show Password</label>
                                <input type="checkbox" class="form-check-input" id="SpCb">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="position-relative">
                                <input name="login" id="login" class="btn login-btn" type="submit" value="Login">
                                <span id="indicator" class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle" title="You are connected to the internet" hidden>
                                    <span class="visually-hidden">Internet Connection Status</span>
                                </span>
                            </div>
                        </div>
                        <a class="forgot-link" style="cursor: pointer;" id="passres" hidden>Forgot password?</a>
                    </form>
                    <?php
                    if (isset($notice)) {
                        if (strpos($notice, "You can't log in due to an active session") !== false) {
                            echo '
                        <script>
                            Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 10500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        }).fire({
                            icon: "warning",
                            title: "Session Conflict",
                            text: "' . $notice . '"
                        });
                        </script>';
                        } elseif (strpos($notice, "Not Logged In") !== false) {
                            echo '
                        <script>
                            Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 10500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        }).fire({
                            icon: "info",
                            title: "Credentials Required",
                            text: "Kindly log in before attempting to access the page. Your login credentials are required to proceed."
                        });
                        </script>';
                        } else {
                            echo '<p class="form-text text-center';
                            if (isset($show)) echo $show;
                            echo '" id="reminder">';
                            if (isset($notice)) echo $notice;
                            echo '</p>';
                        }
                    }

                    if (isset($error)) {
                        echo '
                            <div class="alert alert-danger user-select-none text-center" role="alert" id="erroralert">
                                ' . $error . '
                            </div>
                        ';
                    } else {
                        echo '
                            <div class="alert bg-transparent user-select-none text-center" role="alert" id="erroralert">
                                &nbsp
                            </div>
                        ';
                    }
                    ?>
                    <p class="mute-text text-center text-danger visually-hidden" id="error"> <?php if (isset($error)) echo $error; ?>&nbsp</p>
                    <p class="login-wrapper-footer-text visually-hidden">Need an account? <a href="#!" class="text-reset">Signup here</a></p>
                    <script>
                        //check if connected to the internet
                        /* var connected = navigator.offLine;
                        if (connected) {
                            document.getElementById('indicator').classList.remove('visually-hidden');
                        } else {
                            document.getElementById('indicator').classList.add('visually-hidden');
                        } */

                        window.onload = function() {
                            document.getElementById('login').scrollIntoView();

                        }

                        // remove content of error message after 5 seconds
                        setTimeout(() => {
                            document.getElementById('error').innerHTML = "&nbsp";
                        }, 3500);

                        setTimeout(() => {
                            document.getElementById('erroralert').classList.remove('alert-danger');
                            document.getElementById('erroralert').classList.add('bg-transparent');
                            document.getElementById('erroralert').innerHTML = "&nbsp";
                        }, 3500);


                        // disable login button if username or password is empty
                        document.getElementById('login').disabled = true;


                        // Function to check if email and password are not empty
                        function checkInputFields() {
                            var emailValue = document.getElementById('email').value;
                            var passwordValue = document.getElementById('password').value;

                            if (emailValue !== "" || passwordValue !== "") {
                                document.getElementById('login').disabled = false;
                                setTimeout(() => {
                                    document.getElementById('reminder').innerHTML = "&nbsp";
                                }, 2000);
                            } else {
                                document.getElementById('login').disabled = true;
                            }
                        }

                        // Attach the function to both email and password input events
                        document.getElementById('email').addEventListener('keyup', checkInputFields);
                        document.getElementById('password').addEventListener('keyup', checkInputFields);

                        // Show password
                        document.getElementById('SpCb').addEventListener('click', () => {
                            var passwordInput = document.getElementById('password');
                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                            } else {
                                passwordInput.type = "password";
                            }
                        });

                        // Konami Code for Easter Egg added later
                        var keys = [];
                        var konami = '38,38,40,40,37,39,37,39,66,65';
                        window.addEventListener("keydown", function(e) {
                            keys.push(e.keyCode);
                            console.log(keys.toString());
                            if (keys.toString().indexOf(konami) >= 0) {
                                if (navigator.onLine) {
                                    alert("You are connected to the internet");
                                } else {
                                    alert("You are not connected to the internet");
                                }
                                keys = [];
                            }
                        }, true);

                        function updateTime() {
                            var currentTime = new Date();
                            var hours = currentTime.getHours();
                            var minutes = currentTime.getMinutes();
                            var seconds = currentTime.getSeconds();
                            var ampm = hours >= 12 ? 'PM' : 'AM';
                            var day = currentTime.getDay();
                            var month = currentTime.getMonth();
                            var monthlist = ["January", "February", "March", "April ", "May", "June", "July", "August", "September", "October", "November", "December"];
                            var date = currentTime.getDate();
                            var year = currentTime.getFullYear();

                            // Convert to 12-hour format
                            hours = hours % 12 || 12;

                            // Add leading zeros if needed
                            hours = (hours < 10 ? "0" : "") + hours;
                            minutes = (minutes < 10 ? "0" : "") + minutes;
                            seconds = (seconds < 10 ? "0" : "") + seconds;

                            // Format the time as hh:mm:ss AM/PM
                            var formattedTime = hours + ":" + minutes + " " + ampm;

                            // Update the content of the 'time' element
                            document.getElementById('time').innerText = formattedTime;
                            document.getElementById('day').innerText = monthlist[month] + " " + date + ", " + year;
                        }

                        // Call updateTime function initially to display the current time
                        updateTime();

                        // Update the time every second (1000 milliseconds)
                        setInterval(updateTime, 1000);


                        // under construction
                        document.getElementById('passres').addEventListener('click', () => {
                            Swal.fire({
                                title: 'Password Reset',
                                html: '<p class="text-center">Enter your email address to reset your password.</p>' +
                                    '<input type="email" class="form-control" id="email" placeholder="Email Address">',
                                showCancelButton: true,
                                confirmButtonText: 'Reset',
                                showLoaderOnConfirm: true,
                                preConfirm: (email) => {
                                    return fetch(`./resetpassword.php?email=${email}`)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(response.statusText)
                                            }
                                            return response.json()
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        })
                                },
                                allowOutsideClick: () => !Swal.isLoading()
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Password Reset',
                                        text: 'A password reset link has been sent to your email address.',
                                        showConfirmButton: false,
                                        timer: 3000
                                    })
                                }
                            })
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>