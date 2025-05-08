<?php
require_once('db/server.php');
$petmode = "";
if (isset($_GET['pet'])) {
    $petmode = $_GET['pet'];
    if ($petmode == "cat" || $petmode == "dog") {

    } else {
        header("location: adopthome.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Home | Supremo Fur Babies</title>
</head>

<body>

    <?php require_once 'db/nav.php'; ?>
    <main>
    <?php require_once 'db/alert.php'; ?>
        <div class="w-100 mid-accent-bg py-3 text-center">
            <h1 class="lilita dark-accent-fg fw-bolder">Adopt a <?= ucfirst($petmode) ?></h1>
        </div>
        <div class="container py-3">
            <?php if ($petmode == "cat"): ?>
                <h5 class="mid-accent-fg fw-bold mt-3 text-center fs-5 lilita">"Adopt a Cat—Because Every Home Needs a
                    Little
                    Purr-sonality!"</h5>
            <?php elseif ($petmode == "dog"): ?>
                <h5 class="mid-accent-fg fw-bold mt-3 text-center fs-5 lilita">"Life’s Better with a Wagging Tail!"</h5>
            <?php endif; ?>
            <div class="d-flex justify-content-center align-items-center flex-column">

                <h5 class="mb-3 fw-bold">Adoption Application Process:</h5>
                <div class="text-start mb-3">
                    <p class="m-0"><b>Step 1:</b> Fill out the Adoption Application Form</p>
                    <p class="m-0"><b>Step 2:</b> Adoption Interview</p>
                    <p class="m-0"><b>Step 3:</b> Visit the Shelter and bring home your new Best Friend!</p>
                </div>

                <?php if (isset($_SESSION['userid'])): ?>
                    <a href="adoptform.php?pet=<?= $petmode ?>"
                        class="btn dark-accent-bg text-white py-3 px-5 m-3 lilita fs-5"><?= strtoupper($petmode) ?> ADOPTION
                        FORM</a>
                <?php else: ?>
                    <a href="signin.php" class="btn dark-accent-bg text-white py-3 px-5 m-3 lilita fs-5">SIGN IN TO
                        CONTINUE</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>