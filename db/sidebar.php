<?php
// Count scheduled visits
$visitQuery = $conn->query("SELECT COUNT(*) AS total FROM visit WHERE status = 'Scheduled'");
$visitCount = $visitQuery ? $visitQuery->fetch_assoc()['total'] : 0;

// Count pending rescue reports
$rescueQuery = $conn->query("SELECT COUNT(*) AS total FROM rescue WHERE status = 'pending'");
$rescueCount = $rescueQuery ? $rescueQuery->fetch_assoc()['total'] : 0;

$applicantResult = $conn->query("SELECT COUNT(*) AS total FROM applicant WHERE status = 'pending'");
$applicantCount = $applicantResult ? $applicantResult->fetch_assoc()['total'] : 0;
?>

<nav id="sidebar">
    <ul class="list-unstyled">
        <li>
            <a href="admindashboard.php" class="lilita <?= $page == "dashboard" ? "active" : "" ?>">Dashboard</a>
        </li>
        <li>
            <a href="adminuser.php" class="lilita  <?= $page == "user" ? "active" : "" ?>">User</a>
        </li>
        <li>
            <a href="adminanimal.php" class="lilita  <?= $page == "animal" ? "active" : "" ?>">Animal</a>
        </li>
    </ul>

    <ul class="list-unstyled mt-3">
        <li>
            <a href="adminadoption.php" class="lilita  <?= $page == "adoption" ? "active" : "" ?>">
                <div class="d-flex justify-content-between">
                    <p class="m-0">Adoption</p>
                    <?php if ($applicantCount > 0): ?>
                        <span class="badge dark-accent-bg text-white"><?= $applicantCount ?></span>
                    <?php endif; ?>
                </div>
            </a>

        </li>
        <li>
            <a href="adminshelter.php" class="lilita <?= $page == "visit" ? "active" : "" ?>">
                <div class="d-flex justify-content-between">
                    <p class="m-0">Shelter Visit</p>
                    <?php if ($visitCount > 0): ?>
                        <span class="badge dark-accent-bg text-white"><?= $visitCount ?></span>
                    <?php endif; ?>
                </div>

            </a>
        </li>
        <li>
            <a href="adminrescue.php" class="lilita <?= $page == "rescue" ? "active" : "" ?>">
                <div class="d-flex justify-content-between">
                    <p class="m-0"> Rescue Report</p>
                    <?php if ($rescueCount > 0): ?>
                        <span class="badge dark-accent-bg text-white"><?= $rescueCount ?></span>
                    <?php endif; ?>
                </div>
            </a>
        </li>


    </ul>

</nav>