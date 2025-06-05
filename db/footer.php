<!-- Footer -->
<footer class="footer light-accent-bg py-3">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Back to Top -->
            <div class="col-md-3 col-12 d-md-flex align-items-end d-none">
                <a href="#"
                    class="back-to-top text-white dark-accent-bg lilita fs-4 d-flex align-items-center justify-content-center">TOP</a>
            </div>

            <!-- Page Name & Address -->
            <div class="col-md col-12 pt-3 pt-md-0">

                <h2 class="lilita mb-0">SUPREMO</h2>
                <h5 class="lilita dark-accent-fg">FUR BABIES</h5>

                <hr>
                <p class="mb-0 fw-bold">MALABON, PHILIPPINES </p>
                <p class="mb-0">0995 427 4925</p>
                <p class="mb-0">gjprias0618@gmail.com</p>
            </div>

            <!-- Logo -->
            <div class="col-md-3 d-flex align-items-center justify-content-center">
                <img src="assets/img/logo.png" alt="Logo" style="max-width: 150px;">
            </div>

        </div>
    </div>
</footer>
<div class="position-fixed me-3 bottom-0 end-0" style="z-index:1000; transform:translateY(-15%)!important;">
    <div class="social-icons d-flex align-items-end my-auto justify-content-around">
        <a href="https://www.facebook.com/share/192zHGyWSs/?mibextid=wwXIfr" target="_blank"><img src="assets/img/fb.png" class="mb-2"
                style="width:50px; background-color:white; border-radius: 50%;"></a>
     
        <div class="dark-accent-bg d-flex align-items-center justify-content-center ps-3"
            style=" border-radius: 50px; height:50px;">
            <p class="lilita text-white m-0 p-0">REPORT TO US</p>
            <a href="#" data-bs-toggle="modal" data-bs-target="#reportModal"><img src="assets/img/report.png"
                    class="ms-2" style="width:50px; background-color:white; border-radius: 50%;"></a>
        </div>

    </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mid-accent-bg dark-accent-fg">
                <h3 class="modal-title lilita" id="reportModalLabel">RESCUE REQUEST</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lh-0 mb-0" style="font-size:10px;"><b>DISCLAIMER</b></p>
                <p class="lh-0" style="font-size:10px;">Supremo Furbabies only conducts rescues within Malabon City. For
                    cases outside our area,
                    please contact local shelters. Thank you for understanding and helping us save lives!
                    🐾💙</p>
                <?php if (isset($_SESSION['userid'])):
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="animalType">WHAT TYPE OF ANIMAL NEEDS HELP <span
                                    class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="animalType" id="dog" value="dog">
                                    <label class="form-check-label" for="dog">DOG</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="animalType" id="cat" value="cat">
                                    <label class="form-check-label" for="cat">CAT</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="animalCondition">WHAT IS THE CONDITION OF THE ANIMAL <span
                                    class="text-danger">*</span></label>
                            <div>
                                <div class="form-check py-2">
                                    <input class="form-check-input" type="checkbox" id="abused" name="abused"
                                        value="abused">
                                    <label class="form-check-label" for="abused">ABUSED</label>
                                </div>
                                <div class="form-check py-2">
                                    <input class="form-check-input" type="checkbox" id="hitByVehicle" name="hitByVehicle"
                                        value="hitByVehicle">
                                    <label class="form-check-label" for="hitByVehicle">HIT BY VEHICLE</label>
                                </div>
                                <div class="form-check py-2">
                                    <input class="form-check-input" type="checkbox" id="stray" name="stray" value="stray">
                                    <label class="form-check-label" for="stray">STRAY</label>
                                </div>
                                <div class="form-check py-2">
                                    <input class="form-check-input" type="checkbox" id="starving" name="starving"
                                        value="starving">
                                    <label class="form-check-label" for="starving">STARVING</label>
                                </div>
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="checkbox" id="others" name="others"
                                        value="others">
                                    <label class="form-check-label me-2" for="others">OTHERS</label>
                                    <input type="text" class="form-control w-auto" id="specifyOthers" name="specifyOthers"
                                        placeholder="Specify" disabled>
                                </div>

                                <!-- Optional: Enable input field only when checkbox is checked -->
                                <script>
                                    document.getElementById("others").addEventListener("change", function () {
                                        document.getElementById("specifyOthers").disabled = !this.checked;
                                    });
                                </script>

                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="animalLocation">WHERE IS THE ANIMAL LOCATED <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="animalLocation" required name="animalLocation"
                                placeholder="Exact address or nearest landmark in Malabon">
                        </div>

                        <div class="form-group  mb-3">
                            <label for="uploadVideo">CAN YOU PROVIDE A VIDEO OR PHOTO OF THE ANIMAL <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" id="uploadVideo" name="uploadVideo" required>
                            <p><small class="form-text text-muted">Make sure your video is no longer than 10 minutes</small>
                            </p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="yourName">YOUR NAME <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="yourName"
                                value="<?= $user['fname'] ?> <?= $user['lname'] ?>" readonly placeholder="Your Name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="yourContactInfo">YOUR CONTACT INFORMATION <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="yourContactInfo" value="<?= $user['phone'] ?>"
                                readonly placeholder="Your Contact Information">
                        </div>
                        <div class="form-group mb-3">
                            <label for="additionalInfo">ADDITIONAL INFORMATION (Any other details that might help the rescue
                                team)</label>
                            <textarea class="form-control" id="additionalInfo" name="additionalInfo" rows="4"
                                placeholder="Provide any other relevant information"></textarea>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="submit" name="reportsubmit"
                                class="btn text-white dark-accent-bg p-2 lilita fs-4">SUBMIT</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="d-flex justify-content-center">
                        <a href="signin.php" class="btn dark-accent-bg text-white py-3 px-5 m-3 lilita fs-5">SIGN IN TO
                            CONTINUE</a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>