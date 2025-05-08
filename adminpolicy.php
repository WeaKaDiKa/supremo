<?php
require_once('db/server.php');
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "policy";
    require_once 'db/head.php'; ?>
    <title>Admin | Supremo Fur Babies</title>


</head>

<body>
    <?php require_once 'db/nav.php'; ?>

    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg">
            <?php require_once 'db/alert.php'; ?>
            <div>

                <div class="py-5 px-5 container-fluid main-content">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h1 class="lilita dark-accent-fg">MANAGE RESCUES</h1>
                            <hr>
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>Sales</td>
                                        <td>$100</td>
                                        <td>2024-03-01</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jane Smith</td>
                                        <td>Marketing</td>
                                        <td>$200</td>
                                        <td>2024-03-02</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Michael Johnson</td>
                                        <td>Finance</td>
                                        <td>$300</td>
                                        <td>2024-03-03</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Emily Brown</td>
                                        <td>HR</td>
                                        <td>$150</td>
                                        <td>2024-03-04</td>
                                    </tr>
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