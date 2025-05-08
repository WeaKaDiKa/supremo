<?php
require_once('db/server.php');
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Visit | Supremo Fur Babies</title>

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

        .values ul {
            list-style-type: none;
            padding-left: 0;
        }

        .values li {
            margin-bottom: 10px;
            font-size: 1.2em;
            position: relative;
            padding-left: 30px;
        }

        .values li::before {
            content: "🐾";
            /* Paw print emoji */
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <main>
    <?php require_once 'db/alert.php'; ?>
        <div class="w-100 mid-accent-bg py-3 text-center">
            <h1 class="lilita dark-accent-fg fw-bolder">ABOUT US</h1>
        </div>

        <div class="container py-5 px-5">

            <p> Supremo Furbabies was officially founded in 2021, but our journey of rescuing and caring for stray and
                abandoned animals began in 2018 through the dedication of Miss Jennifer "Jennie" Torres. Driven by her
                deep compassion for animals, Jennie took it upon herself to rescue, rehabilitate, and rehome countless
                stray dogs and cats, believing that we, as humans, are their voice and their only hope for a better life
            </p>
            <p>
                What started as a personal mission soon grew into a full-fledged advocacy, uniting fellow animal lovers,
                volunteers, and supporters who share the same vision of providing love, shelter, and second chances to
                furbabies in need. Today, Supremo Furbabies is home to 260 rescued dogs and cats
                —and counting. We continue to expand our reach, offering a safe haven for rescued animals, facilitating
                adoptions, encouraging sponsorships, and engaging the community in volunteer efforts to create a kinder
                world for every stray in need. </p>

            <div class="row">
                <div class="col-md-4 p-3">
                    <img src="assets/img/aboutus1.png" class="w-100">

                </div>
                <div class="col-md-4 p-3">
                    <img src="assets/img/aboutus2.png" class="w-100">
                </div>
                <div class="col-md-4 p-3">
                    <img src="assets/img/aboutus3.png" class="w-100">
                </div>
            </div>

            <p>
                The struggle of stray and abandoned animals is an ongoing challenge—one that Supremo Furbabies cannot
                face alone. Every day, more dogs and
                cats are left to fend for themselves, suffering from hunger, illness, and neglect. But change is
                possible, and it starts with each of us taking action.</p>


            <p>
                Speak up against animal cruelty. Be a responsible pet owner. Promote neutering to help control
                overpopulation. And most importantly, be part of
                the solution—adopt, foster, sponsor, volunteer, or donate</p>


            <p>
                At Supremo Furbabies, we are committed to giving these animals a second chance, but we can't do it
                without your help. <strong>Will you stand with us and
                    be their voice?</strong></p>

            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100  rounded rounded-5">
                        <div class="card-body dark-accent-bg rounded rounded-5">
                            <h1 class="lilita mid-accent-fg text-center">MISSION</h1>
                            <p class="light-accent-fg lilita">To rescue, rehabilitate, and rehome stray and abandoned
                                dogs and cats while promoting
                                responsible pet ownership and animal welfare.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100  rounded rounded-5">
                        <div class="card-body dark-accent-bg rounded rounded-5">
                            <h1 class="lilita mid-accent-fg text-center">VISION</h1>
                            <p class="light-accent-fg lilita"> A future where every animal
                                has a safe, loving home and
                                a community that values
                                their well-being.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 rounded rounded-5">
                        <div class="card-body dark-accent-bg rounded rounded-5">
                            <h1 class="lilita mid-accent-fg text-center">VALUES</h1>
                            <div class="values">
                                <ul>
                                    <li class="light-accent-fg lilita">Compassion</li>
                                    <li class="light-accent-fg lilita">Commitment</li>
                                    <li class="light-accent-fg lilita">Integrity</li>
                                    <li class="light-accent-fg lilita">Community</li>
                                    <li class="light-accent-fg lilita">Advocacy</li>
                                </ul>
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