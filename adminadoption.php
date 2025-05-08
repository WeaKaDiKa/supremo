<?php
require_once('db/server.php');
require_once('db/adminloginverify.php');
$sql = "
SELECT 
    a.adoptionid, 
    u.fname AS user_fname, u.lname AS user_lname, 
    p.name AS pet_name, 
    ad.fname AS admin_fname, ad.lname AS admin_lname, 
    a.adoption_date
FROM adoption a
JOIN user u ON a.userid = u.userid
JOIN pet p ON a.petid = p.petid
JOIN user ad ON a.adminid = ad.userid
";

$result = $conn->query($sql);

$sql = "
SELECT 
    u.fname, 
    u.lname, 
    a.occupation, 
    a.picked, 
    a.gmeet_date, 
    a.gmeet_time,
    a.applicantid,
    a.status,
    a.gmeetlink
FROM applicant a
JOIN user u ON a.userid = u.userid
";
$result2 = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "adoption";
    require_once 'db/head.php'; ?>
    <title>Admin | Supremo Fur Babies</title>


</head>

<body>
    <?php require_once 'db/nav.php'; ?>

    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg" style="overflow-x: hidden!important;">
            <?php require_once 'db/alert.php'; ?>
            <div class="py-5 container-fluid main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg">MANAGE ADOPTION APPLICANTS</h1>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable2" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>User Name</th>
                                        <th>Occupation</th>
                                        <th>Picked Pet</th>
                                        <th>Gmeet Date</th>
                                        <th>Gmeet Time</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result2->num_rows > 0): ?>
                                        <?php while ($row = $result2->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></td>
                                                <td><?= htmlspecialchars($row['occupation']); ?></td>
                                                <td><?= htmlspecialchars($row['picked']); ?></td>
                                                <td><?= date("F j, Y", strtotime($row['gmeet_date'])); ?></td>
                                                <td><?= htmlspecialchars($row['gmeet_time']); ?></td>
                                                <td><?= htmlspecialchars($row['status']); ?></td>
                                                <td>
                                                    <form method="post" action="viewapplicantinfo.php">
                                                        <input type="hidden"
                                                            value="<?= htmlspecialchars($row['applicantid']) ?>"
                                                            name="applicantid">
                                                        <button class="btn dark-accent-bg text-white btn-sm" type="submit">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <?php if (!empty($row['gmeetlink'])): ?>
                                                            <a class="btn dark-accent-bg text-white btn-sm"
                                                                href="<?= htmlspecialchars($row['gmeetlink']); ?>" target="_blank">
                                                                <i class="bi bi-camera-video-fill"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <button class="btn btn-secondary btn-sm" disabled>
                                                                <i class="bi bi-camera-video-off"></i>
                                                            </button>
                                                        <?php endif; ?>

                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                        
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg">MANAGE ADOPTIONS</h1>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Adoption ID</th>
                                        <th>User Name</th>
                                        <th>Pet Name</th>
                                        <th>Admin Name</th>
                                        <th>Adoption Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['adoptionid']; ?></td>
                                                <td><?= $row['user_fname'] . ' ' . $row['user_lname']; ?></td>
                                                <td><?= $row['pet_name']; ?></td>
                                                <td><?= $row['admin_fname'] . ' ' . $row['admin_lname']; ?></td>
                                                <td><?= date("F j, Y", strtotime($row['adoption_date'])); ?></td>
                                            </tr>
                                        <?php endwhile; ?>

                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <?php
            require_once 'db/script.php';

            ?>
            <script>
                $(document).ready(function () {
                    $('#dataTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "lengthChange": true
                    });
                    $('#dataTable2').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "lengthChange": true
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>