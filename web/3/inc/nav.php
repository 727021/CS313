<?php
$filename = basename($_SERVER['PHP_SELF']);
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item<?php if ($filename == "index.php") echo " active"; ?>"><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item<?php if ($filename == "cart.php") echo " active"; ?>"><a href="cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart (<span id="itemCount"><?php if (!isset($_SESSION['cart'])) { echo 0; } else { $i = 0; foreach ($_SESSION['cart'] as $sess) { $i += $sess; } echo $i; } ?></span>)</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>