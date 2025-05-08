<?php
require_once('db/server.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session
    $userid = $_SESSION['userid'];
    $visitType = $_POST['visitType'];
    $schedule_date = $_POST['datepicker'];
    $schedule_time = $_POST['time'];
    $number_people = $_POST['numvisitor'];
    $comment = $_POST['comment'];
    if (!isset($_POST['agree'])) {
        $_SESSION['errorMessage'] = "You must agree to the terms.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
        header("Location: visit.php");
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO visit (userid, schedule_date, schedule_time, visittype, number_people, comment, liability) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $liability = 1;
    $stmt->bind_param("isssisi", $userid, $schedule_date, $schedule_time, $visitType, $number_people, $comment, $liability);
    if ($stmt->execute()) {
        $_SESSION['errorMessage'] = "Booking successful";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Success!";
        header("Location: visit.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "Error: " . $stmt->error;
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
        header("Location: visit.php");
        exit();
    }
}
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
    </style>
</head>

<body>
    <?php require_once 'db/nav.php'; ?>
    <main>
        <?php require_once 'db/alert.php'; ?>
        <div class="w-100 mid-accent-bg py-3 text-center">
            <h1 class="lilita dark-accent-fg fw-bolder">VOLUNTEER AT OUR SHELTER</h1>
        </div>
        <section class="hero d-flex align-items-center justify-content-center text-center text-white">
            <div class="overlay"></div>
        </section>
        <div class="container py-5 px-5">
            <h5 class="dark-accent-fg fw-bold lilita mb-3 text-center">Helping isn’t limited to adoption, donating, or
                sponsorship—every little effort counts!</h5>
            <p>We warmly welcome visitors and volunteers to our shelter in Malabon! Schedule your visit today and share
                meaningful moments with our rescues.
            </p>
            <p>
                Volunteers make a huge difference by helping our rescues adjust and feel loved. Your time and care can
                significantly boost their happiness and development. Volunteers can also assist in cleaning the shelter,
                giving baths to the rescues, administering their medicine, and feeding them, all of which are vital to
                their well-being and recovery.
            </p>
            <p><strong class="fw-bold dark-accent-fg">Please Note:</strong> Although our rescues are generally
                approachable, their behavior can vary.
                <strong class="fw-bold dark-accent-fg">PLEASE ENSURE RESPONSIBLE INTERACTION WITH OUR RESCUES.</strong>
                Always consult our staff before
                interacting with them to ensure they are comfortable. Avoid sudden gestures or petting, and allow them
                to approach you at their own pace.
            </p>
            <p>You’re also welcome to bring your pets, but please provide proof of updated vaccinations.</p>
            <p>If you’d like to visit, kindly <span class="fw-bold dark-accent-fg">book an appointment</span> using the
                form below to let us know in advance!</p>
            <div class="d-flex align-items-center justify-content-center">
                <div class="d-flex justify-content-center">

                    <?php if (isset(($_SESSION['userid']))): ?>
                        <button class="btn text-white dark-accent-bg lilita fs-4" data-bs-toggle="modal"
                            data-bs-target="#bookVisitModal">
                            BOOK A VISIT
                        </button>
                    <?php else: ?>
                        <a href="signin.php" class="btn dark-accent-bg text-white py-3 px-5 m-3 lilita fs-5">SIGN IN TO
                            CONTINUE</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <div class="w-100 mid-accent-bg py-3 text-center">
            <h1 class="lilita dark-accent-fg fw-bolder">TASK YOU CAN DO</h1>
        </div>
        <div class="container py-5 px-5">
            <div class="row">
                <div class="col-lg-3">
                    <img src="assets/img/e.png" class="w-100">
                </div>
                <div class="col-lg-6 d-flex align-items-center justify-content-center flex-column">
                    <ul class="my-3">
                        <li class="lilita">Help Clean and Organize the Shelter</li>
                        <li class="lilita">Bathe Dogs</li>
                        <li class="lilita">Administer Medicine to Rescues</li>
                        <li class="lilita">Socialize with Rescues</li>
                        <li class="lilita">Help with Feeding in the Afternoon</li>
                    </ul>
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="donate.php?type=inkind" class="btn text-white dark-accent-bg mb-3 mt-3 lilita fs-4">
                            SHELTER WISHLIST
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <img src="assets/img/e.png" class="w-100">
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="bookVisitModal" tabindex="-1" aria-labelledby="bookVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content light-accent-bg">
                <form method="post">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h1 class="modal-title lilita text-center dark-accent-fg fs-1 mb-3" id="bookVisitModalLabel">
                            BOOK A VISIT
                        </h1>
                        <h3 class="m-3 lilita">SUPREMO FURBABIES MALABON SHELTER VISIT</h3>
                        <p class="m-0 p-0"><span class="fw-bold">ADDRESS:</span> 11 Pacencia St., Tugatog, Malabon City
                        </p>
                        <p class="m-0 p-0"><span class="fw-bold">OPERATING HOURS:</span> Tuesdays to Sundays, 10 AM to 4
                            PM</p>
                        <p class="fw-bold mt-3 mb-0">APPOINTMENT DETAILS</p>
                        <p class="m-0 p-0">Kindly provide the requested information so we can better prepare for your
                            planned visit.</p>
                        <h6 class="mt-3">Type of Visit</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="visitType" id="spendTime" value="visit">
                            <label class="form-check-label" for="spendTime">
                                I PLAN TO VISIT SO I CAN SPEND TIME WITH THE RESCUES
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="visitType" id="donationsAndSpendTime"
                                value="donate">
                            <label class="form-check-label" for="donationsAndSpendTime">
                                I PLAN TO DROP-OFF DONATIONS VISIT AND ALSO SPEND TIME WITH THE RESCUES
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="visitType" id="volunteer"
                                value="volunteer">
                            <label class="form-check-label" for="volunteer">
                                I WOULD LIKE TO DO ACTUAL VOLUNTEER WORK
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="visitType" id="pickup"
                                value="pickup pet">
                            <label class="form-check-label" for="volunteer">
                                I WOULD LIKE TO PICK UP MY ADOPTED PET
                            </label>
                        </div>
                        <p class="mb-0"><b>MAXIMUM OF 10 PEOPLE PER GROUP.</b> Visitors are allowed to stay as long
                            as they want.
                            PLEASE
                            MAKE SURE TO CHOOSE A DATE AND TIME BELOW.</p>
                        <p>Book your Appointment</p>
                        <div class="row mb-4">
                            <div id="calendar-container"
                                class="col-md-6 d-flex align-items-center justify-content-center"></div>
                            <input type="text" id="datepicker" name="datepicker" required class="d-none">
                            <script>
                                $(document).ready(function () {
                                    var tomorrow = new Date();
                                    tomorrow.setDate(tomorrow.getDate() + 1);
                                    $('#calendar-container').datepicker({
                                        format: 'yyyy-mm-dd',
                                        autoclose: true,
                                        startDate: tomorrow
                                    });
                                    $('#calendar-container').on('changeDate', function () {
                                        var selectedDate = $('#calendar-container').datepicker('getFormattedDate');
                                        $('#datepicker').val(selectedDate);
                                        $.ajax({
                                            url: 'check_timeslots_visit.php',
                                            type: 'POST',
                                            data: {
                                                schedule_date: selectedDate
                                            },
                                            success: function (response) {
                                                let unavailable = JSON.parse(response);
                                                const allTimes = {
                                                    "time1": "10:00 AM to 11:00 AM",
                                                    "time2": "11:00 AM to 12:00 PM",
                                                    "time3": "1:00 PM to 2:00 PM",
                                                    "time4": "2:00 PM to 3:00 PM",
                                                    "time5": "3:00 PM to 4:00 PM"
                                                };

                                                // Re-enable all timeslots and reset label text
                                                for (let id in allTimes) {
                                                    const input = $('#' + id);
                                                    const label = $('#label-' + id);
                                                    input.prop('disabled', false);
                                                    label.removeClass('disabled').css('opacity', 1);
                                                    label.find('.status').text(' (Available Slot)');
                                                }

                                                // Disable and update text for unavailable ones
                                                unavailable.forEach(function (slotValue) {
                                                    $('input[name="time"]').each(function () {
                                                        if ($(this).val() === slotValue) {
                                                            $(this).prop('disabled', true);
                                                            const label = $('label[for="' + $(this).attr('id') + '"]');
                                                            label.addClass('disabled').css('opacity', 0.5);
                                                            label.find('.status').text(' (Unavailable Slot)');
                                                        }
                                                    });
                                                });
                                            }
                                        });
                                    });

                                });
                                $userid = $_SESSION['userid'];
                                $schedule_date = $_POST['schedule_date'];
                            </script>
                            <div class="col-md-6 ">
                                <div class="container mt-4">
                                    <div class="d-flex flex-column" role="group">
                                        <input type="radio" class="btn-check" name="time" id="time1"
                                            value="10:00 AM to 11:00 AM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita rounded-pill px-4"
                                            for="time1" id="label-time1">
                                            10:00 AM to 11:00 AM <span class="status"></span>
                                        </label>

                                        <input type="radio" class="btn-check" name="time" id="time2"
                                            value="11:00 AM to 12:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita rounded-pill px-4"
                                            for="time2" id="label-time2">
                                            11:00 AM to 12:00 PM <span class="status"></span>
                                        </label>
                                        <input type="radio" class="btn-check" name="time" id="time3"
                                            value="1:00 PM to 2:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita rounded-pill px-4"
                                            for="time3" id="label-time3">
                                            1:00 PM to 2:00 PM <span class="status"></span>
                                        </label>
                                        <input type="radio" class="btn-check" name="time" id="time4"
                                            value="2:00 PM to 3:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita rounded-pill px-4"
                                            for="time4" id="label-time4">
                                            2:00 PM to 3:00 PM <span class="status"></span>
                                        </label>
                                        <input type="radio" class="btn-check" name="time" id="time5"
                                            value="3:00 PM to 4:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita rounded-pill px-4"
                                            for="time5" id="label-time5">
                                            3:00 PM to 4:00 PM <span class="status"></span>
                                        </label>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 fw-bold">NAME <span class="text-danger">*</span></p>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="fname" class="form-control mb-0 no-border" id="fname"
                                    value="<?= $user['fname'] ?>" readonly required>
                                <p class="text-muted mb-3">First Name</p>
                            </div>
                            <div class="col">
                                <input type="text" name="lname" class="form-control mb-0 no-border" id="fname"
                                    value="<?= $user['lname'] ?>" readonly required>
                                <p class="text-muted mb-3">Last Name</p>
                            </div>
                        </div>
                        <p class="mb-0 fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></p>
                        <input type="text" name="email" class="form-control mb-0 no-border" id="email"
                            value="<?= $user['email'] ?>" readonly required>
                        <p class="text-muted mb-3">example@example.com</p>
                        <p class="mb-0 fw-bold">TOTAL NUMBER OF PEOPLE VISITING <span class="text-danger">*</span>
                        </p>
                        <input type="number" placeholder="e.g., 10" name="numvisitor"
                            class="form-control mb-0 no-border" id="numvisitor" value="1" min="1" required>
                        <p class="text-muted mb-3">If you are not sure, an estimate will be enough</p>
                        <p class="mb-0 fw-bold">COMMENTS/QUESTIONS</p>
                        <textarea name="comment" id="comment" class="form-control w-100"
                            style="resize:none; height:150px;">
</textarea>
                        <hr>
                        <p class="fw-bold text-decoration-underline">Shelter Visit Liability Waiver</p>
                        <p><strong>Assumption of Risk:</strong> I understand that working with animals involves
                            certain inherent risks, including but not limited to the risk of bites, scratches,
                            allergic reactions, and other injuries. I voluntarily assume all risks associated with
                            my participation as a visitor and/or volunteer at the Shelter.</p>
                        <p><strong>Health and Safety:</strong> I certify that I am physically and mentally capable
                            of performing the tasks required of a visitor and/or volunteer at the Shelter. I agree
                            to follow all safety instructions provided by the Shelter staff.</p>
                        <p><strong>Release of Liability:</strong> In consideration for being allowed to volunteer at
                            the Shelter, I hereby release, discharge, and hold harmless the Shelter, its officers,
                            employees, and team members from any and all claims, demands, actions, or causes of
                            action arising out of or in any way related to my visit.</p>
                        <p><strong>Emergency Medical Treatment:</strong> In the event of an emergency, I authorize
                            the Shelter to obtain medical treatment for me, including but not limited to first aid
                            treatment.</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                            <label class="form-check-label" for="agree">
                                I have read and agree to the terms above.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-center">
                        <button type="submit"
                            class="btn dark-accent-bg text-white lilita py-3  fs-4 px-5">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>
</body>

</html>