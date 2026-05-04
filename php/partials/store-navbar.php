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
      <!-- Navbar Search Bar -->
      <form action="search.php" method="get" class="d-flex navbar-search-form me-3" role="search" id="navbar-search-form">
        <div class="input-group input-group-sm">
          <input type="text"
                 class="form-control navbar-search-input"
                 name="key"
                 id="navbar-search-key"
                 placeholder="Search products..."
                 aria-label="Search products"
                 autocomplete="off">
          <button class="btn navbar-search-btn" type="submit" aria-label="Search">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <!-- AJAX live search results dropdown -->
        <div class="navbar-search-results" id="navbar-search-results"></div>
      </form>
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
<!-- Navbar Search AJAX Script -->
<script>
(function () {
  const form = document.getElementById('navbar-search-form');
  const input = document.getElementById('navbar-search-key');
  const resultsBox = document.getElementById('navbar-search-results');
  if (!form || !input || !resultsBox) return;

  let debounceTimer;

  input.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const query = input.value.trim();
    if (query.length < 2) {
      resultsBox.innerHTML = '';
      resultsBox.style.display = 'none';
      return;
    }
    debounceTimer = setTimeout(function () {
      fetch('../php/ajax-search.php?key=' + encodeURIComponent(query) + '&page=1', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(r => r.json())
      .then(data => {
        if (data.total === 0) {
          resultsBox.innerHTML = '<div class="navbar-search-no-result">No results found</div>';
          resultsBox.style.display = 'block';
          return;
        }
        // Parse the HTML cards to extract device links and names
        const temp = document.createElement('div');
        temp.innerHTML = data.html;
        const cards = temp.querySelectorAll('.card');
        let html = '';
        let count = 0;
        cards.forEach(function (card) {
          if (count >= 5) return;
          const link = card.querySelector('.device-card-name-link');
          const priceEl = card.querySelector('.device-price');
          if (link) {
            const name = link.textContent.trim();
            const href = link.getAttribute('href');
            const price = priceEl ? priceEl.textContent.trim() : '';
            html += '<a href="' + href + '" class="navbar-search-result-item">'
                  + '<span class="navbar-search-result-name">' + name + '</span>'
                  + '<span class="navbar-search-result-price">' + price + '</span>'
                  + '</a>';
            count++;
          }
        });
        if (data.total > 5) {
          html += '<a href="search.php?key=' + encodeURIComponent(query) + '" class="navbar-search-result-item navbar-search-view-all">'
                + 'View all ' + data.total + ' results →'
                + '</a>';
        }
        resultsBox.innerHTML = html;
        resultsBox.style.display = 'block';
      })
      .catch(() => {
        resultsBox.style.display = 'none';
      });
    }, 300);
  });

  // Hide results on click outside
  document.addEventListener('click', function (e) {
    if (!form.contains(e.target)) {
      resultsBox.style.display = 'none';
    }
  });

  // Show results on focus if there's content
  input.addEventListener('focus', function () {
    if (resultsBox.innerHTML.trim() !== '') {
      resultsBox.style.display = 'block';
    }
  });
})();
</script>