<?php if (!isset($_SESSION['logintype']) || $_SESSION['logintype'] == "client"): ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php#">
                <img src="assets/img/logonav.png" alt="Supremo" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                $current_page = basename($_SERVER['PHP_SELF']); // Get current file name
                ?>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link lilita nav-larger <?= ($current_page == 'index.php') ? 'active' : ''; ?>"
                            href="index.php">HOME</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link lilita nav-larger dropdown-toggle <?= ($current_page == 'adopt.php') ? 'active' : ''; ?>"
                            role="button" data-bs-toggle="dropdown">
                            ADOPT
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="adopthome.php">OUR RESCUES</a></li>
                            <li><a class="dropdown-item" href="adopt.php?pet=cat">ADOPT A CAT</a></li>
                            <li><a class="dropdown-item" href="adopt.php?pet=dog">ADOPT A DOG</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link lilita nav-larger dropdown-toggle <?= ($current_page == 'donate.php') ? 'active' : ''; ?>"
                            href="#" role="button" data-bs-toggle="dropdown">
                            DONATE
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="donate.php">DONATE</a></li>
                            <li><a class="dropdown-item" href="donate.php?type=online">DONATE ONLINE</a></li>
                            <li><a class="dropdown-item" href="donate.php?type=inkind">IN-KIND DONATION</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link lilita nav-larger dropdown-toggle <?= ($current_page == 'visit.php') ? 'active' : ''; ?>"
                            href="#" role="button" data-bs-toggle="dropdown">
                            VOLUNTEER
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="visit.php">HELP AND VISIT OUR SHELTER</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link lilita nav-larger dropdown-toggle <?= ($current_page == 'aboutus.php' || $current_page == 'contactus.php' || $current_page == 'faqs.php') ? 'active' : ''; ?>"
                            href="#" role="button" data-bs-toggle="dropdown">
                            ABOUT
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="aboutus.php">ABOUT US</a></li>
                            <!-- <li><a class="dropdown-item" href="contactus.php">CONTACT US</a></li> -->
                            <!-- <li><a class="dropdown-item" href="faqs.php">FAQS</a></li> -->
                        </ul>
                    </li>

                    <li class="nav-item">
                        <?php if (!checklogin()): ?>

                            <a class="nav-link lilita nav-larger <?= ($current_page == 'signin.php') ? 'active' : ''; ?>"
                                href="signin.php">SIGN IN</a>
                        <?php else: ?>
                            <?php
                            $userid = $_SESSION['userid']; // Get logged-in user ID
                            $user = userdetails($conn, $userid);
                            ?>
                            <form method="post">
                                <button
                                    class="nav-link lilita nav-larger <?= ($current_page == 'signin.php') ? 'active' : ''; ?>"
                                    type="submit" name="logoutbtn">LOGOUT</button>
                            </form>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php elseif (isset($_SESSION['logintype']) && $_SESSION['logintype'] == "admin"): ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-0">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="btn dark-accent-bg text-white m-3 d-md-none">
                <i class="bi bi-list"></i>
            </button>

            <a class="navbar-brand" href="index.php#">
                <img src="assets/img/logonav.png" alt="Supremo" class="d-none d-sm-block" height="100">
            </a>

            <ul class="navbar-nav ms-auto">
                <div class="d-flex align-items-center">
                    <?php

                    $appResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM applicant WHERE status = 'New'");
                    $appRow = mysqli_fetch_assoc($appResult);
                    $appCount = $appRow['total'] ?? 0;


                    $reportResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rescue WHERE status = 'pending'");
                    $reportRow = mysqli_fetch_assoc($reportResult);
                    $reportCount = $reportRow['total'] ?? 0;

                    // Total notifications
                    $totalNotifications = $appCount + $reportCount;
                    ?>
                    <li class="nav-item me-4">
                        <div class="notification-bell position-relative">
                            <i class="bi bi-bell-fill" style="font-size: 1.5rem; color: #ffc50f;"></i>
                            <?php if ($totalNotifications > 0): ?>
                                <span
                                    class="badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $totalNotifications ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </li>

                    <li class="nav-item me-2">

                        <?php
                        $userid = $_SESSION['adminid']; // Get logged-in user ID
                        $user = admindetails($conn, $userid);
                        ?>
                        <form method="post">
                            <button class="avatar" type="submit" name="logoutbtn">
                                <i class="bi bi-person-fill"></i>
                            </button>
                        </form>

                    </li>
                </div>
            </ul>
        </div>
    </nav>
<?php endif; ?>