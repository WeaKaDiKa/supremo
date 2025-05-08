<?php
require_once('db/server.php');
require_once('db/adminloginverify.php');
$sql = "SELECT userid, CONCAT(fname, ' ', mname, ' ', lname) AS name, gender, phone, created_at FROM user";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "user";
    require_once 'db/head.php'; ?>
    <title>Users | Supremo Fur Babies</title>


</head>

<body>
    <?php require_once 'db/nav.php'; ?>

    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg" style="overflow-x: hidden!important;">
            <div class="py-5 container-fluid main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg">MANAGE USERS</h1>
                        <hr>
                        <div style="overflow-x: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['userid']; ?></td>
                                                <td><?= $row['name']; ?></td>
                                                <td><?= $row['gender']; ?></td>
                                                <td><?= $row['phone']; ?></td>
                                                <td><?= date("F j, Y  h:ma", strtotime($row['created_at'])); ?></td>
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
                });
            </script>
        </div>
    </div>
</body>

</html>