<?php
require_once('db/server.php');

$queries = [
    'total_users' => "SELECT COUNT(*) AS count FROM user WHERE MONTH(created_at) = MONTH(CURRENT_DATE())",
    'successful_adoptions' => "SELECT COUNT(*) AS count FROM adoption WHERE MONTH(adoption_date) = MONTH(CURRENT_DATE())",
    'ongoing_adoptions' => "SELECT COUNT(*) AS count FROM applicant WHERE status = 'pending'",
    'rescued_animals' => "SELECT COUNT(*) AS count FROM pet WHERE MONTH(rescue_date) = MONTH(CURRENT_DATE())",
    'scheduled_visits' => "SELECT COUNT(*) AS count FROM visit WHERE status = 'scheduled' AND visittype = 'visit'",
    'volunteers_signed' => "SELECT COUNT(*) AS count FROM visit WHERE visittype = 'volunteer' AND status = 'scheduled' ",
    'pending_visits' => "SELECT COUNT(*) AS count FROM visit WHERE status = 'scheduled'",
    'pending_donate' => "SELECT COUNT(*) AS count FROM visit WHERE visittype = 'donate' AND status = 'scheduled' ",

    'pending_rescue_reports' => "SELECT COUNT(*) AS count FROM rescue WHERE status = 'pending'"
];

$counts = [];

foreach ($queries as $key => $sql) {
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $counts[$key] = $row['count'];
}


?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "dashboard";
    require_once 'db/head.php'; ?>
    <title>Admin | Supremo Fur Babies</title>


</head>

<body>
    <?php require_once 'db/nav.php'; ?>

    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg">
            <?php require_once 'db/alert.php'; ?>
            <div class="py-5 container-fluid main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg mb-5">Good Day, Admin</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="dark-accent-fg">TOTAL SYSTEM USERS THIS MONTH</h6>
                                <h1 class="lilita dark-accent-fg mb-3"><?= $counts['total_users'] ?></h1>
                                <h6 class="dark-accent-fg">TOTAL SUCCESSFUL ADOPTION THIS MONTH</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['successful_adoptions'] ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="dark-accent-fg">TOTAL ONGOING ADOPTION REQUESTS</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['ongoing_adoptions'] ?></h1>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="dark-accent-fg">TOTAL RESCUED ANIMALS THIS MONTH</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['rescued_animals'] ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="dark-accent-fg">TOTAL SCHEDULED VISITS</h6>
                                <h1 class="lilita dark-accent-fg mb-3"><?= $counts['scheduled_visits'] ?></h1>
                                <h6 class="dark-accent-fg">TOTAL VOLUNTEERS SIGNED UP</h6>
                                <h1 class="lilita dark-accent-fg mb-3"><?= $counts['volunteers_signed'] ?></h1>
                                <h6 class="dark-accent-fg">TOTAL PENDING SCHEDULE VISIT</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['pending_visits'] ?></h1>
                                <h6 class="dark-accent-fg">TOTAL PENDING DONATION VISIT</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['pending_donate'] ?></h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="dark-accent-fg">TOTAL PENDING RESCUE REPORT</h6>
                                <h1 class="lilita dark-accent-fg"><?= $counts['pending_rescue_reports'] ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            require_once 'db/script.php';
            ?>
        </div>
    </div>
</body>

</html>