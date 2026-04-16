<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default value for active page if not provided
$active_page = $active_page ?? '';
?>
<!-- //TODO: Purple-blue theme navbar - changed from navbar-light bg-light -->
<nav class="navbar navbar-expand-lg navbar-dark store-navbar-purple">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Online Electronics Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse"
         id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= $active_page === 'store' ? 'active' : '' ?>"
             aria-current="page"
             href="index.php">Store</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $active_page === 'cart' ? 'active' : '' ?>"
             href="cart.php">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $active_page === 'contact' ? 'active' : '' ?>"
             href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $active_page === 'about' ? 'active' : '' ?>"
             href="about.php">About</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <?php if (isset($_SESSION['user_id'])) {?>
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php if ($_SESSION['user_role'] == 'admin') { ?>
                <i class="fas fa-user-shield me-1"></i> <!-- Admin icon -->
              <?php } else { ?>
                <i class="fas fa-user me-1"></i> <!-- User icon -->
              <?php } ?>
              <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <?php if ($_SESSION['user_role'] == 'admin') { ?>
                <li><a class="dropdown-item" href="../admin/admin.php">Admin Panel</a></li>
                <li><hr class="dropdown-divider"></li>
              <?php } ?>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          <?php } else { ?>
            <a class="nav-link <?= $active_page === 'login' ? 'active' : '' ?>" href="login.php">Login / Register</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>