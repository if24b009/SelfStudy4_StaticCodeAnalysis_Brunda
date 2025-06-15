<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>

<!-- NAV-BAR -->
<nav class="navbar navbar-expand-xl bg-dark navbar-dark px-3">
    <a class="navbar-brand" href="./index.php">GeoVista</a>

    <!-- Burger-Menu Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar"
        aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <div
            class="d-flex flex-column flex-xl-row w-100 align-items-start align-items-xl-center justify-content-xl-between gap-3">

            <!-- Left and middle-->
            <ul
                class="navbar-nav flex-column flex-xl-row align-items-start align-items-xl-center w-100 justify-content-xl-center">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./imprint.php">Impressum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./registration.php">Registrieren</a>
                </li>
                <?php if (isset($_SESSION['userrole']) && $_SESSION['userrole'] === "Admin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./userlist.php">Usermanagement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./question_upload.php">Fragenerstellung</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Right: Profil & Login/Logout -->
            <div class="d-flex flex-column flex-xl-row align-items-start align-items-xl-center gap-2">
                <?php if (isset($_SESSION['userid'])): ?>
                    <a class="nav-link" href="./profil.php">
                        <img src="./res/img/icons/profil.png" alt="Profil Icon" style="width: 40px;">
                    </a>
                    <a class="btn btn-light" href="./logout.php" role="button">Logout</a>
                <?php else: ?>
                    <a class="btn btn-light" href="./login.php" role="button">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>