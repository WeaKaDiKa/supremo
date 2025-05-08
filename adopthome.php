<?php
require_once('db/server.php');

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
            <h1 class="lilita dark-accent-fg fw-bolder">Our Rescues</h1>
        </div>
        <div class="container py-3 px-5">
            <h5 class="dark-accent-fg fw-bold text-center mb-3">"Saving one animal won’t change the world, but for that
                one
                animal, the
                world will
                change forever." 🐾</h5>
            <p>At Supremo Furbabies, our rescued dogs and cats have been given a second chance at life. Each one has a
                unique story—some were abandoned, others rescued from neglect—but all of them are now safe, loved, and
                ready
                for a fresh start. They are waiting for kind and loving families to give them the forever home they
                deserve.
                Open your heart and home—<b>adopt, and change a life today.</b>
            </p>
            <p>They are all <b>vaccinated, dewormed and neutered</b> and can be visited anytime, just with prior
                registration.
                We
                are committed to ensuring that these rescues find not just any home, but the right home—with
                responsible,

            <div class="d-flex w-100 justify-content-center align-items-center">
                <p class="dark-accent-bg text-white text-center w-50 py-3 m-3 lilita fs-5">ADOPT</p>

            </div>
            <p class="lilita fs-5 text-center mid-accent-fg">"Is your heart and home ready for a new furry family
                member?"</p>

            <div class="d-flex justify-content-center align-items-center flex-column">

                <h5 class="mb-3 fw-bold">Adoption Application Process:</h5>
                <div class="text-start mb-3">
                    <p class="m-0"><b>Step 1:</b> Fill out the Adoption Application Form</p>
                    <p class="m-0"><b>Step 2:</b> Adoption Interview</p>
                    <p class="m-0"><b>Step 3:</b> Visit the Shelter and bring home your new Best Friend!</p>
                </div>
                <p class="w-100 mid-accent-bg text-white py-3 m-3 text-center lilita fs-5">ADOPTION FORM</p>
                <div class="row mt-3">
                    <div class="col-lg-6 mb-3">
                        <div class="card pic-dog-bg-adopt">
                            <div class="card-body text-center align-items-center justify-content-center d-flex flex-column"
                                style="min-height:35vh; z-index:3;">
                                <h3 class="lilita mid-accent-fg">Bestfriend for Life?</h3>
                                <p class="text-white fw-bold">When you adopt a dog, you’re not just giving them a home,
                                    you're welcoming a new
                                    member into your family.</p>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="adopt.php?pet=dog" class="btn dark-accent-bg text-white lilita">ADOPT A
                                        DOG</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card pic-cat-bg-adopt">
                            <div class="card-body text-center align-items-center justify-content-center d-flex flex-column"
                                style="min-height:35vh; z-index:3;">
                                <h3 class="lilita mid-accent-fg">Purrfect Companion</h3>
                                <p class="text-white fw-bold">Cats offer soothing purrs and quiet companionship, perfect
                                    for those who seek a
                                    peaceful, loving presence in their lives.</p>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="adopt.php?pet=cat" class="btn dark-accent-bg text-white lilita">ADOPT A
                                        CAT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>