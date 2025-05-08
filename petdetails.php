<?php
require_once('db/server.php');
$petmode = "";
if (isset($_GET['petid'])) {
    $petmode = $_GET['petid'];
} else {
    header("location: adoptform.php");
    exit;
}
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
            height: 30vh;
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
        <?php
        // Check if petid is provided
        if (isset($_GET['petid'])) {
            $petid = $_GET['petid'];

            // Database connection assumed as $conn
        
            // Fetch pet details
            $sql = "SELECT pet.*, GROUP_CONCAT(petpics.picurl) AS picurls
            FROM pet
            LEFT JOIN petpics ON pet.petid = petpics.petid
            WHERE pet.petid = ?
            GROUP BY pet.petid";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $petid);
            $stmt->execute();
            $result = $stmt->get_result();
            $pet = $result->fetch_assoc();

            if ($pet):
                $pics = explode(",", $pet['picurls']);
                ?>

                <div class="container py-3 px-5">
                    <hr>
                    <h1 class="lilita text-center dark-accent-fg">ADOPT ME!</h1>
                    <h4 class="fw-bold lilita text-center">Selected Pet Details</h4>

                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card adopt-card w-75 rounded rounded-5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div
                                            class="adopt-img-container d-flex justify-content-center align-items-center w-100 overflow-hidden">
                                            <img src="assets/img/uploads/pets/<?= htmlspecialchars($pics[0]) ?>"
                                                class="adopt-img h-100 rounded rounded-5 w-auto">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h4 class="text-white dark-accent-bg px-5 py-3 lilita mt-3">
                                                <?= htmlspecialchars(strtoupper($pet['name'])) ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 d-flex justify-content-center flex-column">
                                        <h1 class="dark-accent-fg py-3 lilita mb-3">
                                            <?= htmlspecialchars(strtoupper($pet['name'])) ?>
                                        </h1>
                                        <p class="fs-5 mb-1"><b>PET:</b> <?= htmlspecialchars($pet['type']) ?>
                                        <p class="fs-5 mb-1"><b>GENDER:</b> <?= htmlspecialchars($pet['gender']) ?></p>
                                        <p class="fs-5 mb-1"><b>AGE:</b> <?= htmlspecialchars($pet['age']) ?></p>
                                        <p class="fs-5 mb-1"><b>COLOR:</b> <?= htmlspecialchars($pet['color']) ?></p>
                                        <p class="fs-5 mb-1"><b>DESCRIPTION:</b> <?= htmlspecialchars($pet['description']) ?>
                                        </p>

                                        <div class="d-flex justify-content-center">

                                            <?php if (isset(($_SESSION['userid']))): ?>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#adoptionModal"
                                                    class="text-white mid-accent-bg btn fs-3 text-decoration-none lilita mt-3">ADOPT
                                                    ME!</a>
                                            <?php else: ?>
                                                <a href="signin.php"
                                                    class="btn dark-accent-bg text-white py-3 px-5 m-3 lilita fs-5">SIGN IN TO
                                                    CONTINUE</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <?php foreach ($pics as $pic): ?>
                            <div class="col">
                                <div
                                    class="adopt-img-container mb-3 d-flex justify-content-center align-items-center w-100 overflow-hidden">
                                    <img src="assets/img/uploads/pets/<?= htmlspecialchars($pic) ?>"
                                        class="adopt-img h-100 rounded rounded-5 w-auto">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php
            else:
                echo "<p class='text-center mt-5'>No pet found with ID: " . htmlspecialchars($petid) . "</p>";
            endif;
        } else {
            echo "<p class='text-center mt-5'>No pet selected.</p>";
        }
        ?>
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
    }
    ?>


</body>

</html>