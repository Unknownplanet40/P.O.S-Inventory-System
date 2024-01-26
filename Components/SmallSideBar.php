<main class="d-flex flex-nowrap border-end bg-body-tertiary overflow-hidden shadow-lg" style="width: 4.5rem;">
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 0) {
        $Urole = 'Administrator';
    } else if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        $Urole = 'Operator';
    } else {
        $Urole = 'Undefined';
    } ?>
    <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary" style="width: 4.5rem; min-height: 100vh;">
        <a class="d-block pt-4 px-3 link-body-emphasis text-decoration-none" title="Manlalaba Laundry Station - <?php echo $Urole; ?>
        " data-bs-toggle="tooltip" data-bs-placement="right" style="margin-top: -2px;">
            <img src="../../assets/Logo.svg" alt="" width="32" class="bi pe-none me-3">
            <span class="fs-5 text-wrap"></span>
            <p class="fs-6 text-muted mb-0 ms-5"></p>
        </a>
        <hr />
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
                <a <?php echo (basename($_SERVER['PHP_SELF']) == "Dashboard.php") ? 'class="custom-active nav-link py-3 border-bottom rounded-0"' : "href='../Dashboard.php'"; ?> style="color: #6e3b3b;" class="nav-link py-3 border-bottom rounded-0" aria-current="page" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Dashboard">
                        <use xlink:href="#home" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a <?php echo (basename($_SERVER['PHP_SELF']) == "POS.php") ? 'class="custom-active nav-link py-3 border-bottom rounded-0"' : "href='../../Components/POS Module/POS.php'"; ?> style="color: #6e3b3b;" class="nav-link py-3 border-bottom rounded-0" laria-current="page" title="Point of Sale" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Point of Sale">
                        <use xlink:href="#POS" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a <?php echo (basename($_SERVER['PHP_SELF']) == "Products.php") ? 'class="custom-active nav-link py-3 border-bottom rounded-0"' : "href='../../Components/Inventory Module/Products.php'"; ?> style="color: #6e3b3b;" class="nav-link py-3 border-bottom rounded-0" laria-current="page" title="Inventory" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Point of Sale">
                        <use xlink:href="#Inventory" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page" title="Customers" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Customers">
                        <use xlink:href="#Customer" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page" title="Transaction" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Transaction">
                        <use xlink:href="#Transaction" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page" title="Report" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Report">
                        <use xlink:href="#Report" />
                    </svg>
                </a>
            </li>
        </ul>
        <div class="dropdown border-top position-absolute bottom-0 start-0" title="More Option " data-bs-toggle="tooltip" data-bs-placement="right">
            <a class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                if (isset($_SESSION['profile']) && $_SESSION['profile'] != null) {
                    echo '<img src="../../assets/Profile_Pictures/' . $_SESSION['profile_pic'] . '" alt="Profile Picture" width="32" height="32" class="rounded-circle me-2">';
                } else {
                    echo '
                    <script src="../../assets/Animated/Profile/profile.js"></script>
                    <lord-icon class="rounded-circle border" src="../../assets/Animated/Profile/profile.json" trigger="hover" style="width:28px;height:28px">
                    </lord-icon>';
                }
                ?>
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><span class="dropdown-item text-center user-select-none fw-bold pb-0"><?php echo $_SESSION['name']; ?></span></li>
                <li><small class="dropdown-item user-select-none pt-0" style="font-size: 12px;">Signed in as <b><?php echo $Urole; ?></b></small></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" style="cursor: pointer;">Profile</a></li>
                <li><a class="dropdown-item" style="cursor: pointer;">Settings</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="../Login Module/logoutPage.php">Sign out</a></li>
            </ul>
        </div>
    </div>
</main>