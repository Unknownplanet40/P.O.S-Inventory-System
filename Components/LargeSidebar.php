<?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 0) {
  $Urole = 'Administrator';
} else if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
  $Urole = 'Operator';
} else {
  $Urole = 'Undefined';
} ?>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px">
  <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
    <!-- <svg class="bi pe-none me-2" width="40" height="32">
      <use xlink:href="#bootstrap" />
    </svg> -->
    <img src="../assets/Logo.svg" alt="" srcset="" width="32" class="bi pe-none me-3">
    <span class="fs-5 text-wrap" title="Manlalaba Laundry Station" data-bs-toggle="tooltip" data-bs-placement="right">Manlalaba Laundry Station</span>
  </a>
  <style>
    .nav-link {
      transition: all 0.3s ease-in-out;
    }

    .nav-link:hover {
      background-color: #e9ecef;
      border-radius: 0.25rem;
    }
  </style>
  <p class="fs-6 text-muted mb-0 ms-5"><?php echo $Urole; ?></p>
  <hr />
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a <?php echo (basename($_SERVER['PHP_SELF']) == "Dashboard.php") ? 'class="nav-link custom-active shadow border"' : "href='../Dashboard.php'"; ?> class="nav-link custom-active shadow border" aria-current="page">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#home" />
        </svg>
        Dashboard
      </a>
    </li>
    <li>
      <a <?php echo (basename($_SERVER['PHP_SELF']) == "POS.php") ? 'class="nav-link custom-active shadow border"' : "href='./POS Module/POS.php'"; ?> class="nav-link link-body-emphasis">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#POS" />
        </svg>
        Point Of Sale
      </a>
    </li>
    <li>
      <a <?php echo (basename($_SERVER['PHP_SELF']) == "Products.php") ? 'class="nav-link custom-active shadow border"' : "href='./Inventory Module/Products.php'"; ?> class="nav-link link-body-emphasis" style="cursor: hands;">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#Inventory" />
        </svg>
        Inventory
      </a>
    </li>
    <li>
      <a <?php echo (basename($_SERVER['PHP_SELF']) == "Customers.php") ? 'class="nav-link custom-active shadow border"' : "href='./Customer Module/Customers.php'"; ?> class="nav-link link-body-emphasis" style="cursor: hands;">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#Customer" />
        </svg>
        Customers
      </a>
    </li>
    <li>
      <a href="#" class="nav-link link-body-emphasis">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#Transaction" />
        </svg>
        Transactions
      </a>
    </li>
    <li>
      <a href="#" class="nav-link link-body-emphasis">
        <svg class="bi pe-none me-2" width="16" height="16">
          <use xlink:href="#Report" />
        </svg>
        Reports
      </a>
    </li>
    <li class="border-top my-3 visually-hidden"></li>
    <li class="mb-1 visually-hidden">
      <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
        Dashboard
      </button>
      <div class="collapse" id="dashboard-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li>
            <a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a>
          </li>
          <li>
            <a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Weekly</a>
          </li>
          <li>
            <a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Monthly</a>
          </li>
          <li>
            <a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Annually</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
  <hr />
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2" />
      <strong><?php echo (isset($_SESSION['name'])) ? $_SESSION['name'] : 'User'; ?></strong>
    </a>
    <ul class="dropdown-menu text-small shadow">
      <li><span class="dropdown-item text-center">Signed in as <b><?php echo $Urole; ?></b></span></li>
      <li>
        <hr class="dropdown-divider" />
      </li>
      <li><a class="dropdown-item">Profile</a></li>
      <li><a class="dropdown-item">Settings</a></li>
      <li>
        <hr class="dropdown-divider" />
      </li>
      <li><a class="dropdown-item" href="../Login Module/logoutPage.php">Sign out</a></li>
    </ul>
  </div>
</div>
<div style="height: 100vh;"></div>

<script>
  document.getElementById('Pos').addEventListener('click', function() {
    window.location.href = '../Components/POS%20Module/POS.php';
  });
</script>