<?php
require_once('db/server.php');

if (isset($_GET['type'])) {
    if ($_GET['type'] == "inkind") {
        $type = $_GET['type'];
    } elseif ($_GET['type'] == "online") {
        $type = $_GET['type'];
    } else {
        $type = "home";
    }
} else {
    $type = "home";
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Home | Supremo Fur Babies</title>

    <style>
        .hero {
            background-image: url('assets/img/a.png');
            background-size: cover;
            background-position: center;
            position: relative;
            height: 50vh
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <main>
        <?php require_once 'db/alert.php'; ?>
        <?php if ($type == "home"): ?>
            <section class="hero d-flex align-items-center justify-content-center text-center text-white">
                <div class="overlay"></div>
                <div class="container" style="z-index:3;">
                    <h1 class="display-3 lilita">Donate</h1>
                    <p class="lead lilita fs-3">Every donation brings us closer to saving more lives.</p>

                </div>
            </section>
            <div class="container py-5 px-5">
                <h5 class="dark-accent-fg fw-bold lilita mb-3">Your contribution makes it possible for us to rescue,
                    feed, and care for animals in need</h5>
                <p>Our shelter relies on donations to continue rescuing, rehabilitating, and rehoming abused and stray dogs
                    and cats. Your support helps us provide essentials like food, medical care, and a safe environment for
                    every animal in need.
                </p>


                <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        <a href="donate.php?type=online" class="btn text-white dark-accent-bg lilita fs-4">
                            DONATE ONLINE
                        </a>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <a href="donate.php?type=inkind" class="btn text-white mid-accent-bg lilita fs-4">
                            DONATE IN-KIND
                        </a>
                    </div>
                </div>
                <p class="mt-3">Your generous donation is vital in helping us provide the necessary care, nourishment, and
                    shelter for
                    rescued animals as they wait for their forever homes.
                </p>

            </div>
            <img src="assets/img/donatebanner.png" class="w-100 mt-3">
        <?php elseif ($type == "online"): ?>
            <div class="w-100 mid-accent-bg py-3 text-center">
                <h1 class="lilita dark-accent-fg fw-bolder">DONATION CHANNELS</h1>
            </div>
            <div class="container py-3 px-3">
                <div class="row mt-3">
                    <div class="col-lg-4 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <img src="assets/img/gcash.png" class="w-100">

                    </div>
                    <div class="col-lg-4 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <img src="assets/img/qr.png" class="w-100">

                    </div>
                    <div class="col-lg-4 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <img src="assets/img/maya.png" class="w-100">

                    </div>
                </div>
            </div>
        <?php elseif ($type == "inkind"): ?>
            <div class="w-100 mid-accent-bg py-3 text-center">
                <h1 class="lilita dark-accent-fg fw-bolder">IN-KIND DONATIONS</h1>
            </div>
            <div class="container py-3 px-5">
                <div class="row mt-3">
                    <div class="col-lg-5 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <img src="assets/img/e.png" class="w-100">

                    </div>
                    <div class="col-lg-7 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <div class="row">
                            <div class="col-lg-5">
                                <h4 class="lilita dark-accent-fg text-center">Cat & Dog Wishlist</h4>
                                <ul class="ms-0">
                                    <li>Dog food (kibble and canned)</li>
                                    <li>Cat food (kibble and canned)</li>
                                    <li>Crates, carriers or cages</li>
                                    <li>Pee pads</li>
                                    <li>Scratching posts for the cats</li>
                                    <li>Chew toys for the dogs</li>
                                    <li>Vaccines, medicine and vitamins</li>
                                    <li>Dog and cat treats</li>
                                    <li>Leashes, harnesses and collars</li>
                                </ul>

                            </div>
                            <div class="col d-flex align-items-center justify-content-center ">
                                <div class="vr dark-accent-fg dark-accent-border"
                                    style="width:3px!important; opacity:1!important;">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <h4 class="lilita dark-accent-fg text-center">Shelter Wishlist</h4>
                                <ul class="ms-0">
                                    <li>Detergent powder and bleach</li>
                                    <li>Dishwashing paste or liquid</li>
                                    <li>Bath towels</li>
                                    <li>Garbage bags (XXL)</li>
                                    <li>Foot rugs or door mats</li>
                                    <li>Clinic supplies (alcohol, cotton, etc.)</li>
                                    <li>Old newspapers</li>
                                    <li>Toilet paper</li>
                                    <li>Mops and brooms</li>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="w-100 mid-accent-bg py-3 text-center">
                <h1 class="lilita dark-accent-fg fw-bolder">WHERE TO SEND</h1>
            </div>
            <div class="container py-3 px-5">
                <div class="row mt-3">
                    <div class="col-lg-5 px-5 mb-3 d-flex align-items-center justify-content-center px-5">
                        <img src="assets/img/e.png" class="w-100">

                    </div>
                    <div class="col-lg-7 px-5 mb-3">
                        <h3 class="lilita dark-accent-fg text-center">Supremo Furbabies</h3>
                        <p><strong>Jennie Torres</strong></p>
                        <p>(0995) 427 4925</p>
                        <p><strong>Address:</strong> 11 Pacencia St., Tugatog, Malabon City</p>
                        <p><strong>**** BY APPOINTMENT/SCHEDULE ONLY ****</strong></p>
                        <p>Click map to enlarge or <a href="https://www.google.com/maps" class="dark-accent-fg fw-bold"
                                target="_blank">view Google Map
                                here</a>.</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="visit.php" class="btn dark-accent-bg text-white fs-3 lilita mt-3">BOOK A VISIT</a>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif ?>
    </main>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>