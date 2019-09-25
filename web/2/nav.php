<?php
$filename = basename($_SERVER['PHP_SELF']);
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">CS313</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item<?php if ($filename == "index.php") echo " active"; ?>"><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item<?php if ($filename == "about.php") echo " active"; ?>"><a href="about.php" class="nav-link"><i class="fas fa-question"></i> About</a></li>
                    <li class="nav-item<?php if ($filename == "assignments.php") echo " active"; ?>"><a href="assignments.php" class="nav-link"><i class="fas fa-list-ul"></i> Assignments</a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="https://727021.github.io"><i class="fab fa-github"></i> Github</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>