<main class="d-flex flex-nowrap" style="overflow-x: hidden;">
    <div class="d-flex flex-column flex-shrink-0 bg-body-tertiary" style="height: 100vh; width: 4.5rem;">
        <a href="/" class="d-block pt-4 px-3 link-body-emphasis text-decoration-none" title="Manlalaba Laundry Station"
            data-bs-toggle="tooltip" data-bs-placement="right" style="margin-top: -2px;">
            <img src="../../assets/Logo.svg" alt="" width="32" class="bi pe-none me-3">
            <span class="fs-5 text-wrap"></span>
            <p class="fs-6 text-muted mb-0 ms-5"></p>
        </a>
        <hr />
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
                <a <?php echo (basename($_SERVER['PHP_SELF']) == "Dashboard.php") ? 'class="custom-active nav-link py-3 border-bottom rounded-0"' : "href='../Dashboard.php'"; ?> style="color: #6e3b3b;"
                    class="nav-link py-3 border-bottom rounded-0" aria-current="page" title="Dashboard"
                    data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Dashboard">
                        <use xlink:href="#home" />
                    </svg>
                </a>
            </li>
            <script>
                
            </script>

            <li class="nav-item">
                <a <?php echo (basename($_SERVER['PHP_SELF']) == "POS.php") ? 'class="custom-active nav-link py-3 border-bottom rounded-0"' : "href='../Components/POS Module/POS.php'"; ?> style="color: #6e3b3b;"
                    class="nav-link py-3 border-bottom rounded-0" laria-current="page" title="Point of Sale"
                    data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Point of Sale">
                        <use xlink:href="#speedometer2" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page"
                    title="Inventory" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Inventory">
                        <use xlink:href="#table" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page"
                    title="Customers" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Customers">
                        <use xlink:href="#grid" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link py-3 border-bottom rounded-0" style="color: #6e3b3b;" aria-current="page"
                    title="Reports" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Reports">
                        <use xlink:href="#people-circle" />
                    </svg>
                </a>
            </li>
        </ul>
        <div class="dropdown border-top" hidden title="Settings / Can't Open Dropdown Here" data-bs-toggle="tooltip"
            data-bs-placement="right">
            <a href="#"
                class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle" />
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</main>