<?php
require_once('db/server.php');
$petmode = "";
if (isset($_GET['pet'])) {
    $petmode = $_GET['pet'];
} else {
    header("location: adopt.php");
    exit;
}
$sql = "SELECT pet.petid, pet.name, 
               (SELECT picurl FROM petpics WHERE petpics.petid = pet.petid LIMIT 1) AS picurl
        FROM pet 
        WHERE pet.status = 'available' 
        AND pet.type = '$petmode'";
$result = $conn->query($sql);

if (isset(($_SESSION['userid']))) {
    require_once "db/adoptformmodalhandler.php";
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Home | Supremo Fur Babies</title>
    <style>
        .adopt-img-container {
            position: relative;
            height: 40vh;
        }

        .adopt-img {
            object-fit: cover;
        }

        .adopt-card {
            border-color: #d3a153;
            border-width: 3px;
        }
    </style>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <main>
        <?php require_once 'db/alert.php'; ?>
        <div class="container py-3 px-5">
            <hr>
            <h1 class="lilita text-center dark-accent-fg">ADOPT ME!</h1>

            <h4 class="fw-bold lilita text-center">Introducing the loving <?= $petmode ?> we are caring for</h4>

            <div class="row align-items-center justify-content-center">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card adopt-card rounded rounded-5">
                                <div class="card-body">
                                    <div
                                        class="adopt-img-container d-flex justify-content-center align-items-center w-100 overflow-hidden">
                                        <img src="assets/img/uploads/pets/<?= htmlspecialchars($row['picurl']); ?>"
                                            class="adopt-img h-100 rounded rounded-5 w-auto">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="petdetails.php?petid=<?= $row['petid']; ?>"
                                            class="text-white dark-accent-bg px-5 py-3 text-decoration-none lilita mt-3">
                                            <?= htmlspecialchars($row['name']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <h5 class="text-muted lilita">No available pets for adoption at the moment.</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset(($_SESSION['userid']))): ?>
            <button type="button"
                class="btn btn-primary position-fixed ms-3 start-0 top-50 translate-middle-y dark-accent-bg"
                data-bs-toggle="modal" data-bs-target="#adoptionModal"
                style="border-radius: 50%; width: 60px; height: 60px;">
                <i class="bi bi-file-earmark-text"></i>
            </button>
        <?php endif; ?>


    </main>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php';
    if (isset(($_SESSION['userid']))) {
        require_once 'adoptformmodal.php';
    } ?>


</body>

</html>