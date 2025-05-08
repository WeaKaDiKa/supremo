<?php
require_once('db/server.php');
$queries = [
    'successful_adoptions' => "SELECT COUNT(*) AS count FROM adoption",
    'rescued_animals' => "SELECT COUNT(*) AS count FROM rescue WHERE status = 'rescued'",
    'spayed' => "SELECT COUNT(*) AS count FROM pet WHERE spayed = 'yes'",
    'sheltered' => "SELECT COUNT(*) AS count FROM pet"
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
    <?php require_once 'db/head.php'; ?>
    <title>Home | Supremo Fur Babies</title>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <main>
        <?php require_once 'db/alert.php'; ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="assets/img/a.png" class="d-block w-100" alt="Slide 1">
                    <!-- Static Text Overlay -->
                    <div class="carousel-caption px-5">
                        <h1 class="lilita">Rescue. Rehabilitate. Rehome</h1>
                        <h3 class="lilita">Because every animal deserves a second chance</h3>
                        <a href="" class="btn btn-primary dark-accent-bg text-white fs-5 lilita p-3 mt-3">I WANT TO
                            HELP</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/img/d.png" class="d-block w-100" alt="Slide 3">
                    <!-- Static Text Overlay -->
                    <div class="carousel-caption px-5">
                        <h1 class="lilita">Open Your Heart, Open Your Home</h1>
                        <h3 class="lilita">Be the reason an animal finds their happy ending.</h3>
                        <a href="" class="btn btn-primary dark-accent-bg text-white fs-5 lilita p-3 mt-3">I WANT TO
                            ADOPT</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/img/e.png" class="d-block w-100" alt="Slide 3">
                    <!-- Static Text Overlay -->
                    <div class="carousel-caption px-5">
                        <h1 class="lilita">They Have Only Us—And We Have Only You</h1>
                        <h3 class="lilita">Your contribution makes it possible for us to rescue, feed, and care for
                            animals in need.</h3>
                        <a href="" class="btn btn-primary dark-accent-bg text-white fs-5 lilita p-3 mt-3">I WANT TO
                            DONATE</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="assets/img/f.png" class="d-block w-100" alt="Slide 3">
                    <!-- Static Text Overlay -->
                    <div class="carousel-caption px-5">
                        <h1 class="lilita">Your Time is Their Happiness</h1>
                        <h3 class="lilita">Join us as a volunteer and bring joy to animals in need through your care and
                            attention.</h3>
                        <a href="" class="btn btn-primary dark-accent-bg text-white fs-5 lilita p-3 mt-3">I WANT TO
                            VOLUNTEER</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container py-5">
            <h1 class="text-center dark-accent-fg lilita">
                Supremo Furbabies Malabon Shelter
            </h1>
            <p>
                Founded in 2021, Supremo Furbabies Malabon Shelter is a non-profit organization dedicated to the rescue,
                rehabilitation, and rehoming of stray and abandoned animals. However, the mission began much earlier—in
                2018—when Miss Jennifer "Jennie" Torres, driven by her deep compassion for animals, started rescuing and
                caring for stray dogs and cats on her own.
            </p>
            <p>
                Today, Supremo Furbabies has rescued and provided a safe haven for over 260 dogs and cats—and continues
                to grow. The shelter remains committed to expanding its reach through adoption programs, striving to
                create a kinder, more compassionate world for every stray in need.
            </p>
        </div>
        <div class="row w-100 p-0 m-0">
            <div class="col py-5 dark-accent-bg d-flex align-items-center justify-content-center flex-column">
                <h1 class="lilita text-white"><?= $counts['sheltered'] ?></h1>
                <h6 class="lilita text-white">SHELTERED</h6>
            </div>
            <div class="col py-5  mid-accent-bg d-flex align-items-center justify-content-center flex-column">
                <h1 class="lilita text-white"><?= $counts['rescued_animals'] ?></h1>
                <h6 class="lilita text-white">RESCUED</h6>
            </div>
            <div class="col py-5  darker-accent-bg d-flex align-items-center justify-content-center flex-column">
                <h1 class="lilita text-white"><?= $counts['spayed'] ?></h1>
                <h6 class="lilita text-white">SPAYED & NEUTERED</h6>
            </div>
            <div class="col py-5  light-accent-bg d-flex align-items-center justify-content-center flex-column">
                <h1 class="lilita dark-accent-fg"><?= $counts['successful_adoptions'] ?></h1>
                <h6 class="lilita dark-accent-fg">REHOMED</h6>
            </div>
        </div>
        <div class="container py-5">
            <h3 class="dark-accent-fg lilita">
                OUR SHELTER SERVE AS A HOME TO ATLEAST 260 RESCUES WHO WERE ONCE HOMELESS, ABUSED, NEGLECTED AND ON
                ABANDONED.
            </h3>
            <p>
                Our shelter is located in Malabon City. Come see the rescues that inspire us to keep fighting for the
                voiceless.
            </p>
            <div class="d-flex align-items-center justify-content-center">
                <img src="assets/img/homeimg.png" class="w-75 mx-5 rounded rounded-5" style="max-width:600px;">
            </div>
            <h4 class="text-center mt-3">
                11 Pacencia St.,Tugatog Malabon City
            </h4>
            <div class="d-flex align-items-center justify-content-center">
                <a class="btn dark-accent-bg text-white lilita mt-3 fs-5">COME VISIT US</a>
            </div>
            <h1 class="text-center dark-accent-fg mt-5 lilita">
                Meet Our Rescues!
            </h1>
            <?php
            // Fetch available pets with images
            $sql = "SELECT pet.petid, pet.name, 
               (SELECT picurl FROM petpics WHERE petpics.petid = pet.petid LIMIT 1) AS picurl
        FROM pet 
        WHERE pet.status = 'available' ";
            $result = $conn->query(query: $sql);
            // Store images in an array
            $images = [];
            while ($row = $result->fetch_assoc()) {
                $images[] = [
                    'url' => "assets/img/uploads/pets/" . $row['picurl'],
                    'id' => $row['petid']
                ];
            }
            $imagesJson = json_encode($images);
            ?>
            <div class="dark-accent-bg text-white d-flex justify-content-between align-items-center p-3">
                <h4 class="lilita m-0">ADOPT ME!</h4>
                <div class="d-flex">
                    <button class="btn btn-light me-3 fs-5" id="prevBtn">&larr;</button>
                    <button class="btn btn-light fs-5" id="nextBtn">&rarr;</button>
                </div>
            </div>
            <div class="row px-3 my-3" id="petGallery">
            </div>
            <script>
                let images = <?= $imagesJson ?>; // Get images from PHP
                let currentIndex = 0;
                const itemsPerPage = 4;
                function displayImages() {
                    let container = document.getElementById('petGallery');
                    container.innerHTML = '';
                    if (images.length === 0) {
                        container.innerHTML = '<div class="col-12 no-pets lilita text-center fs-3">No available pet for adoption</div>';
                        return;
                    }
                    for (let i = currentIndex; i < currentIndex + itemsPerPage && i < images.length; i++) {
                        let colDiv = document.createElement('div');
                        colDiv.className = 'col-md-6 col-lg-3 p-2';
                        let squareContainer = document.createElement('div');
                        squareContainer.className = 'square-container';
                        let link = document.createElement('a');
                        link.href = `petdetails.php?petid=${images[i].id}`;
                        let img = document.createElement('img');
                        img.src = images[i].url;
                        img.alt = 'Pet Image';
                        link.appendChild(img);
                        squareContainer.appendChild(link);
                        colDiv.appendChild(squareContainer);
                        container.appendChild(colDiv);
                    }
                }
                document.getElementById('prevBtn').addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex -= itemsPerPage;
                        displayImages();
                    }
                });
                document.getElementById('nextBtn').addEventListener('click', () => {
                    if (currentIndex + itemsPerPage < images.length) {
                        currentIndex += itemsPerPage;
                        displayImages();
                    }
                });
                // Initialize display
                displayImages();
            </script>
        </div>
    </main>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>
</body>

</html>