<!-- Modal -->
<?php
$applicantInfo = getApplicantInfo($conn);

$userid = $_SESSION['userid'];
if (isset($_POST['gmeet_date'])) {
    $gmeet_date = $_POST['gmeet_date'];
}
?>
<div class="modal fade" id="adoptionModal" tabindex="-1" aria-labelledby="adoptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content light-accent-bg">
            <div class="modal-header d-flex justify-content-between">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data" id="applicationforms">
                <div class="modal-body">
                    <h1 class="modal-title lilita text-center dark-accent-fg mb-3" id="adoptionModalLabel">APPLY NOW
                    </h1>
                    <h3 class="mb-3 lilita">Applicant's Info</h3>
                    <p class="mb-0 fw-bold">COMPLETE NAME <span class="text-danger">*</span></p>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" class="form-control mb-3 no-border" id="fname" placeholder="First"
                                value="<?= $user['fname'] ?>" readonly>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control mb-3 no-border" id="mname" placeholder="Middle"
                                value="<?= $user['mname'] ?>" readonly>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control mb-3 no-border" id="lname" placeholder="Last"
                                value="<?= $user['lname'] ?>" readonly>
                        </div>
                    </div>
                    <p class="mb-0 fw-bold">FULL ADDRESS <span class="text-danger">*</span></p>
                    <p class="text-muted mb-0">Follow this format: Unit, Building Name, House Number, Street,
                        Barangay,
                        City, Region, Zip Code</p>
                    <input type="text" class="form-control mb-3 no-border" id="address" placeholder="Address"
                        value="<?= $user['address'] ?>" readonly>
                    <div class="row">
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">PHONE NUMBER <span class="text-danger">*</span></p>
                            <input type="text" class="form-control mb-3 no-border" id="phone" placeholder="Phone"
                                value="<?= $user['phone'] ?>" readonly>
                        </div>
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></p>
                            <input type="email" class="form-control mb-3 no-border" id="email" placeholder="Email"
                                value="<?= $user['email'] ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">OCCUPATION <span class="text-danger">*</span></p>
                            <input type="occupation" name="occupation" class="form-control mb-3 no-border"
                                id="occupation" placeholder="Occupation"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['occupation'] : "" ?>" required>
                        </div>
                    </div>
                    <p class="mb-0 fw-bold">BIRTHDATE <span class="text-danger">*</span></p>
                    <p class="text-muted mb-0">If you are a Minor, please make sure you have your Parent/Guardian's
                        consent. They will also be asked to join the Adoption Interview.</p>
                    <input type="date" class="form-control mb-3 no-border" id="bday" value="<?= $user['bday'] ?>"
                        readonly>
                    <p class="mb-0 fw-bold">SOCIAL MEDIA PROFILE <span class="text-danger">*</span></p>
                    <p class="text-muted mb-0">Sample format: https://www.facebook.com/juandelacruz or type ‘N/A’ if
                        no
                        social media</p>
                    <input type="text" name="socialmedia" class="form-control mb-3 no-border" id="socialmedia"
                        placeholder="Social Media"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['socialmedia'] : "" ?>" required>
                    <p class="mb-0 fw-bold">ALTERNATE CONTACT <span class="text-danger">*</span></p>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="alt_fname" class="form-control mb-3 no-border" id="alt_fname"
                                placeholder="First"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['alt_fname'] : "" ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="alt_lname" class="form-control mb-3 no-border" id="alt_lname"
                                placeholder="Last"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['alt_lname'] : "" ?>" required>
                        </div>
                    </div>
                    <p class="text-muted mb-0">If the applicant is a minor, a parent or a guardian must be the
                        alternate
                        contact and co-sign the application.</p>
                    <div class="row">
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">RELATIONSHIP <span class="text-danger">*</span></p>
                            <input type="alt_relation" name="alt_relation" class="form-control mb-3 no-border"
                                id="alt_relation" placeholder="Relationship"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['alt_relation'] : "" ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">PHONE NUMBER <span class="text-danger">*</span></p>
                            <input type="text" name="alt_phone" class="form-control mb-3 no-border" id="alt_phone"
                                placeholder="Phone"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['alt_phone'] : "" ?>" required>
                        </div>
                        <div class="col-lg-4">
                            <p class="mb-0 fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></p>
                            <input type="email" name="alt_email" class="form-control mb-3 no-border" id="alt_email"
                                placeholder="Email"
                                value="<?= is_array($applicantInfo) ? $applicantInfo['alt_email'] : "" ?>" required>
                        </div>
                    </div>
                    <hr>
                    <h3 class="mb-3 lilita">Questionnaire</h3>
                    <p class="text-muted mb-0">In an effort to help the process go smoothly, please be as detailed
                        as
                        possible with your responses to the questions below.</p>
                    <p class="mb-0 fw-bold">TYPE OF DWELLING <span class="text-danger">*</span></p>
                    <?php
                    $dwellingType = isset($applicantInfo['dwelling_type']) ? $applicantInfo['dwelling_type'] : '';
                    ?>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_type" class="form-check-input" id="dwelling_condo"
                            value="condo" <?= ($dwellingType == "condo") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_condo">CONDO/UNIT</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_type" class="form-check-input"
                            id="dwelling_apartment" value="apartment" <?= ($dwellingType == "apartment") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_apartment">APARTMENT/TOWNHOUSE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_type" class="form-check-input" id="dwelling_single"
                            value="single" <?= ($dwellingType == "single") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_single">SINGLE-STOREY HOUSE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_type" class="form-check-input" id="dwelling_others"
                            value="others" <?= ($dwellingType == "others") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_others">OTHERS</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">IF YOU ARE RENTING, HAVE YOU CONFIRMED THAT PETS ARE ALLOWED BY THE
                        OWNER OR THE CONDO ADMIN? <span class="text-danger">*</span></p>
                    <?php
                    $petAllowed = isset($applicantInfo['pet_allowed']) ? $applicantInfo['pet_allowed'] : '';
                    ?>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pet_allowed" class="form-check-input" id="pet_allowed_yes"
                            value="1" <?= ($petAllowed == 1) ? "checked" : "" ?>>
                        <label class="form-check-label" for="pet_allowed_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pet_allowed" class="form-check-input" id="pet_allowed_no"
                            value="0" <?= ($petAllowed == 0) ? "checked" : "" ?>>
                        <label class="form-check-label" for="pet_allowed_no">NO</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pet_allowed" class="form-check-input"
                            id="pet_allowed_not_sure" value="not_sure" <?= ($petAllowed == "not_sure") ? "checked" : "" ?>>
                        <label class="form-check-label" for="pet_allowed_not_sure">NOT SURE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pet_allowed" class="form-check-input" id="pet_allowed_we_own"
                            value="we_own" <?= ($petAllowed == "we_own") ? "checked" : "" ?>>
                        <label class="form-check-label" for="pet_allowed_we_own">WE OWN OUR DWELLING</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">DWELLING OWNERSHIP <span class="text-danger">*</span></p>
                    <?php
                    $dwellingOwnership = isset($applicantInfo['dwelling_ownership']) ? $applicantInfo['dwelling_ownership'] : '';
                    ?>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_ownership" class="form-check-input"
                            id="dwelling_ownership_rent" value="rent" <?= ($dwellingOwnership == "rent") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_ownership_rent">RENT</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="dwelling_ownership" class="form-check-input"
                            id="dwelling_ownership_owned" value="owned" <?= ($dwellingOwnership == "owned") ? "checked" : "" ?>>
                        <label class="form-check-label" for="dwelling_ownership_owned">OWNED BY ME / OWNED BY MY
                            FAMILY</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">WHO DO YOU LIVE WITH? <span class="text-danger">*</span></p>
                    <?php
                    $liveWithArray = is_array($applicantInfo) ? explode(',', $applicantInfo['live_with']) : [];
                    ?>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_alone"
                            value="alone" <?= in_array("alone", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_alone">LIVING ALONE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_spouse"
                            value="spouse" <?= in_array("spouse", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_spouse">SPOUSE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_parents"
                            value="parent" <?= in_array("parent", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_parents">PARENTS</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_relatives"
                            value="relatives" <?= in_array("relatives", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_relatives">RELATIVES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_child_over"
                            value="child_over" <?= in_array("child_over", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_child_over">CHILDREN OVER 18</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_child_under"
                            value="child_under" <?= in_array("child_under", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_child_under">CHILDREN UNDER 18</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="live_with[]" class="form-check-input" id="live_with_rent"
                            value="rent" <?= in_array("rent", $liveWithArray) ? "checked" : "" ?>>
                        <label class="form-check-label" for="live_with_rent">ROOMMATE/S</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">ARE ALL THE MEMBERS OF YOUR HOUSEHOLD SUPPORTIVE OF ADOPTING? <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="support_adopt" class="form-check-input"
                            id="support_adopt_yes" value="1" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="support_adopt_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="support_adopt" class="form-check-input" id="support_adopt_no"
                            value="0" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="support_adopt_no">NO</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="support_adopt" class="form-check-input"
                            id="support_adopt_not_sure" value="not_sure" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == "not_sure" ? "checked" : "" ?>>
                        <label class="form-check-label" for="support_adopt_not_sure">NOT SURE</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">ARE YOU PLANNING TO MOVE IN THE FUTURE? <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="future_move" class="form-check-input" id="future_move_yes"
                            value="1" <?= is_array($applicantInfo) && $applicantInfo['future_move'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="future_move_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="future_move" class="form-check-input" id="future_move_no"
                            value="0" <?= is_array($applicantInfo) && $applicantInfo['future_move'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="future_move_no">NO</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">NAME OF RESCUE YOU WANT TO ADOPT <span class="text-danger">*</span>
                    </p>
                    <p class="text-muted mb-0">Type 'N/A' if you don't have a specific rescue in mind and/or want to
                        pick
                        and decide when you visit the shelter.</p>
                    <input type="text" name="picked" class="form-control mb-3 no-border" id="picked"
                        placeholder="Name of Pet Desired"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['picked'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">IF THE RESCUE YOU INDICATED ABOVE IS NO LONGER AVAILABLE, ARE YOU
                        OPEN TO CHOOSING ANOTHER RESCUE? <span class="text-danger">*</span></p>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pick_other" class="form-check-input" id="pick_other_yes"
                            value="1" <?= is_array($applicantInfo) && $applicantInfo['pick_other'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="pick_other_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="pick_other" class="form-check-input" id="pick_other_no"
                            value="0" <?= is_array($applicantInfo) && $applicantInfo['pick_other'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="pick_other_no">NO</label>
                    </div>
                    <p class="mb-0 fw-bold mt-3">WHO WILL BE RESPONSIBLE FOR FEEDING, GROOMING, AND GENERALLY CARING
                        FOR THE PET? <span class="text-danger">*</span>
                    </p>
                    <input type="text" name="who_groom" class="form-control mb-3 no-border" id="who_groom"
                        placeholder="Name of Responsible for Pet"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['who_groom'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">WHO WILL BE FINANCIALLY RESPONSIBLE FOR THE PET’S NEEDS (I.E. FOOD,
                        VET BILLS, ETC.)? <span class="text-danger">*</span>
                    </p>
                    <input type="text" class="form-control mb-3 no-border" id="who_finance"
                        placeholder="Name of Responsible Financially" name="who_finance"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['who_finance'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">DO YOU PLAN TO ADOPT THIS PET AS A GIFT? <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="as_gift" class="form-check-input" id="as_gift_yes" value="1"
                            <?= is_array($applicantInfo) && $applicantInfo['as_gift'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="as_gift_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="as_gift" class="form-check-input" id="as_gift_no" value="0"
                            <?= is_array($applicantInfo) && $applicantInfo['as_gift'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="as_gift_no">NO</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">WHO WILL LOOK AFTER YOUR PET IF YOU GO ON VACATION OR IN CASE OF
                        EMERGENCY? <span class="text-danger">*</span>
                    </p>
                    <input type="text" name="alt_care" class="form-control mb-3 no-border" id="alt_care"
                        placeholder="Name" value="<?= is_array($applicantInfo) ? $applicantInfo['alt_care'] : "" ?>"
                        required>
                    <p class="mb-0 fw-bold mt-3">WHICH OF THE FOLLOWING BEST DESCRIBES YOUR EXPERIENCE <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="owner_type" class="form-check-input" id="owner_type_new"
                            value="new" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "new" ? "checked" : "" ?>>
                        <label class="form-check-label" for="owner_type_new">
                            NEW PET OWNER (THIS WILL BE THE FIRST TIME OWNING A PET)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="owner_type" class="form-check-input"
                            id="owner_type_less_than" value="less_than" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "less_than" ? "checked" : "" ?>>
                        <label class="form-check-label" for="owner_type_less_than">
                            RECENT PET OWNER (MY FAMILY/I OWN/OWNED A PET LESS THAN 3 YEARS)
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="owner_type" class="form-check-input"
                            id="owner_type_more_than" value="more_than" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "more_than" ? "checked" : "" ?>>
                        <label class="form-check-label" for="owner_type_more_than">
                            SEASONED PET OWNER (MY FAMILY/I OWN/OWNED A PET MORE THAN 3 YEARS)
                        </label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">LIST ALL THE PETS YOU’VE HAD OR HAVE <span class="text-danger">*</span>
                    </p>
                    <p class="text-muted mb-0">Follow this format: Total number and breed (e.g 3 Shi Tzu, 1 Aspins,
                        4
                        Persian Cats).</p>
                    <input type="text" name="pet_list" class="form-control mb-3 no-border" id="pet_list"
                        placeholder="e.g 3 Shi Tzu, 1 Aspins, 4 Persian Cats"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['pet_list'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">DO YOU STILL OWN ALL OF THEM? <span class="text-danger">*</span>
                    </p>
                    <p class="text-muted mb-0">If not, please indicate the reason/s why. If your pet passed away,
                        kindly
                        type when it happened and the cause of death</p>
                    <input type="text" name="pet_still_owned" class="form-control mb-3 no-border" id="pet_still_owned"
                        placeholder="Still owned?"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['pet_still_owned'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">WHAT PROMPTED YOU TO ADOPT FROM SUPREMO? <span
                            class="text-danger">*</span></p>
                    <?php
                    $adopt_supremo = [];
                    if (is_array($applicantInfo) && isset($applicantInfo['adopt_supremo'])) {
                        $adopt_supremo = explode(',', $applicantInfo['adopt_supremo']);
                    }
                    ?>
                    <!-- FRIEND -->
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="adopt_supremo[]" class="form-check-input" id="adopt_supremo_friend"
                            value="friend" <?= in_array("friend", $adopt_supremo) ? "checked" : "" ?>>
                        <label class="form-check-label" for="adopt_supremo_friend">FRIENDS</label>
                    </div>
                    <!-- FACEBOOK -->
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="adopt_supremo[]" class="form-check-input"
                            id="adopt_supremo_facebook" value="facebook" <?= in_array("facebook", $adopt_supremo) ? "checked" : "" ?>>
                        <label class="form-check-label" for="adopt_supremo_facebook">FACEBOOK</label>
                    </div>
                    <!-- OTHER -->
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="adopt_supremo[]" class="form-check-input" id="adopt_supremo_other"
                            value="other" <?= in_array("other", $adopt_supremo) ? "checked" : "" ?>>
                        <label class="form-check-label" for="adopt_supremo_other">OTHER</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">HAVE YOU ADOPTED FROM SUPREMO BEFORE? <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="past_adopt" class="form-check-input" id="past_adopt_yes"
                            value="1" <?= is_array($applicantInfo) && $applicantInfo['past_adopt'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="past_adopt_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="past_adopt" class="form-check-input" id="past_adopt_no"
                            value="0" <?= is_array($applicantInfo) && $applicantInfo['past_adopt'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="past_adopt_no">NO</label>
                    </div>
                    <!-- ------------>
                    <p class="mb-0 fw-bold mt-3">WHAT MADE YOU CONSIDER ADOPTING A RESCUE? <span
                            class="text-danger">*</span>
                    </p>
                    <input type="text" name="why_adopt" class="form-control mb-3 no-border" id="why_adopt"
                        placeholder="Reason for Adoption"
                        value="<?= is_array($applicantInfo) ? $applicantInfo['why_adopt'] : "" ?>" required>
                    <p class="mb-0 fw-bold mt-3">UPLOAD A COPY OF VALID ID <span class="text-danger">*</span>
                    </p>
                    <p class="text-muted mb-0">Please upload a Government-issued ID or any Personal ID with your
                        picture
                        and name. Make sure the name you indicated in this application form matches the name on your
                        ID.
                    </p>
                    <input type="file" name="valid_id" class="form-control mb-0 no-border" id="valid_id" required>
                    <p class="text-muted mb-0">Max. file size: 8 MB. </p>
                    <?php
                    $validIdUrl = null;
                    // Assuming $conn and $userid are available
                    $validIdQuery = "SELECT valid_id FROM applicant WHERE userid = ? ORDER BY applicantid DESC LIMIT 1";
                    $stmt = $conn->prepare($validIdQuery);
                    $stmt->bind_param("i", $userid);
                    $stmt->execute();
                    $stmt->bind_result($validIdFile);
                    if ($stmt->fetch() && !empty($validIdFile)) {
                        $validIdUrl = "assets/img/uploads/id/" . $validIdFile;
                    }
                    $stmt->close();
                    ?>
                    <?php if ($validIdUrl): ?>
                        <div class="mt-3 d-flex justify-content-center">
                            <a href="<?= $validIdUrl ?>" target="_blank" class="btn dark-accent-bg text-white btn-sm">
                                View Uploaded Valid ID
                            </a>
                        </div>
                    <?php endif; ?>
                    <p class="mb-0 fw-bold mt-3">PLEASE ATTACH PHOTOS OF YOUR HOME <span class="text-danger">*</span>
                    </p>
                    <ol class="mb-0">
                        <li>Front of the house</li>
                        <li>Street photo</li>
                        <li>Living room</li>
                        <li>Dining area</li>
                        <li>Kitchen</li>
                        <li>Bedroom/s (if your pet will have access)</li>
                        <li>Windows (if adopting a cat)</li>
                        <li>Front & backyard (if adopting a dog)</li>
                    </ol>
                    <p class="mb-0 fw-bold text-muted">We value your privacy. Your photos will not be used for
                        purposes other than this adoption application. </p>
                    <input type="file" name="home_pic[]" multiple class="form-control mb-0 no-border" id="home_pic">
                    <p class="text-muted mb-0">Max. file size: 8 MB. </p>
                    <?php
                    $housePics = [];
                    $sql = "SELECT picurl FROM housepic WHERE userid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $userid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $housePics[] = $row['picurl'];
                    }
                    ?>
                    <div class="row d-flex justify-content-center">
                        <?php if (!empty($housePics)): ?>
                            <?php foreach ($housePics as $pic): ?>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <img src="assets/img/uploads/house/<?php echo htmlspecialchars($pic); ?>"
                                            class="img-fluid rounded border" alt="House Picture">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No house pictures uploaded.</p>
                        <?php endif; ?>
                    </div>
                    <p class="mb-0 fw-bold mt-3">INTERVIEW & VISITATION (MINORS MUST BE ACCOMPANIED BY A PARENT OR
                        GUARDIAN.) </p>
                    <?php
                    $currentDate = date('Y-m-d');
                    ?>
                    <!--                   
                                       <div class="row">
                        <div class="col">
                            <p class="mb-0 fw-bold mt-3">Preferred date for Google Meet Interview <span
                                    class="text-danger">*</span> </p>
                            <input type="date" name="gmeet_date" value="<= date('Y-m-d', strtotime('+1 day')) ?>"
                                class="form-control no-border" id="gmeet_date" required
                                min="?= date('Y-m-d', strtotime('+1 day')) ?>) ?>">
                            <p class="text-muted">We can't guarantee the availability of your requested time.</p>
                        </div>
                        <div class="col">
                            <p class="mb-0 fw-bold mt-3">Preferred time for Google Meet Interview <span
                                    class="text-danger">*</span> </p>
                            <input type="time" min="10:00" max="16:00" name="gmeet_time" value="10:00"
                                class="form-control no-border" id="gmeet_time" required>
                            <p class="text-muted">We can't guarantee the availability of your requested time.</p>
                        </div>
                    </div>
 -->



                    <?php
                    $isOlderThan30Days = false;
                    $message = "Cannot submit new application while there is another ongoing application.";

                    if (is_array($applicantInfo) && isset($applicantInfo['date_applied'])) {
                        $appliedDate = new DateTime($applicantInfo['date_applied']);
                        $now = new DateTime();
                        $interval = $appliedDate->diff($now);
                        $isOlderThan30Days = ($interval->days >= 30);

                        if (!$isOlderThan30Days) {
                            $message = "You must wait 30 days before submitting another application.";
                        }
                    }
                    ?>


                    <?php if (
                        (is_array($applicantInfo) && $applicantInfo['status'] != "New" && $applicantInfo['status'] != "For Gmeet Interview" && $isOlderThan30Days)
                        || !is_array($applicantInfo)
                    ): ?>

                        <p class="mb-0 fw-bold mt-3 text-center">Preferred date and time for Google Meet Interview <span
                                class="text-danger">*</span> </p>
                        <div class="row mb-4">
                            <div id="calendar-container" class="col-lg-6 d-flex align-items-center justify-content-center">
                            </div>
                            <input type="hidden" id="datepicker" name="gmeet_date" required>
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
                                            url: 'check_timeslots.php',
                                            type: 'POST',
                                            data: {
                                                gmeet_date: selectedDate
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

                                                // Re-enable and label all timeslots as available
                                                for (let id in allTimes) {
                                                    const input = $('#' + id);
                                                    const label = $('label[for="' + id + '"]');
                                                    input.prop('disabled', false);
                                                    label.removeClass('disabled').css('opacity', 1);
                                                    label.find('.status').text(' (Available Slot)');
                                                }

                                                // Disable and update label for unavailable slots
                                                unavailable.forEach(function (slotValue) {
                                                    $('input[name="gmeet_time"]').each(function () {
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

                            </script>
                            <div class="col-lg-6 ">
                                <div class="container mt-4">
                                    <div class="d-flex flex-column" role="group">
                                        <input type="radio" required class="btn-check" name="gmeet_time" id="time1"
                                            value="10:00 AM to 11:00 AM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita  rounded-pill px-4"
                                            for="time1">10:00 AM to 11:00 AM <span class="status"></span></label>
                                        <input type="radio" required class="btn-check" name="gmeet_time" id="time2"
                                            value="11:00 AM to 12:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita  rounded-pill px-4"
                                            for="time2">11:00 AM to 12:00 PM <span class="status"></span></label>
                                        <input type="radio" required class="btn-check" name="gmeet_time" id="time3"
                                            value="1:00 PM to 2:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita  rounded-pill px-4"
                                            for="time3">1:00 PM to 2:00 PM <span class="status"></span></label>
                                        <input type="radio" required class="btn-check" name="gmeet_time" id="time4"
                                            value="2:00 PM to 3:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita  rounded-pill px-4"
                                            for="time4">2:00 PM to 3:00 PM <span class="status"></span></label>
                                        <input type="radio" required class="btn-check" name="gmeet_time" id="time5"
                                            value="3:00 PM to 4:00 PM" autocomplete="off">
                                        <label class="btn btn-outline-dark-accent mb-2 lilita  rounded-pill px-4"
                                            for="time5">3:00 PM to 4:00 PM <span class="status"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col">
                                <p class="mb-0 fw-bold mt-3">Preferred date for Google Meet Interview <span
                                        class="text-danger">*</span> </p>
                                <input type="text" name="gmeet_date"
                                    value="<?= is_array($applicantInfo) && !empty($applicantInfo['gmeet_date']) ? date('F d, Y', strtotime($applicantInfo['gmeet_date'])) : '' ?>"
                                    class="form-control no-border" id="gmeet_date" disabled>

                            </div>
                            <div class="col">
                                <p class="mb-0 fw-bold mt-3">Preferred time for Google Meet Interview <span
                                        class="text-danger">*</span> </p>
                                <input type="text" name="gmeet_time" class="form-control no-border" id="gmeet_time"
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['gmeet_time'] : "" ?>" disabled>

                            </div>
                        </div>
                        <?php if (!empty($applicantInfo['gmeetlink'])): ?>
                            <div class="mb-3 text-center">
                                <label class="mb-0 fw-bold mt-3">Google Meet Link</label><br>
                                <a href="<?= htmlspecialchars($applicantInfo['gmeetlink']) ?>" target="_blank"
                                    class="btn dark-accent-bg text-white">
                                    Join Google Meet
                                </a>
                            </div>
                        <?php endif; ?>

                        <h5 class="lilita mt-3 text-center"><?= htmlspecialchars($message) ?></h5>

                    <?php endif; ?>
                    <p class="mb-0 fw-bold mt-3">Will you be able to visit the shelter for the meet-and-greet? <span
                            class="text-danger">*</span></p>
                    <!-- ------------>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="meet_greet" class="form-check-input" id="meet_greet_yes"
                            value="1" <?= is_array($applicantInfo) && $applicantInfo['meet_greet'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="meet_greet_yes">YES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" required name="meet_greet" class="form-check-input" id="meet_greet_no"
                            value="0" <?= is_array($applicantInfo) && $applicantInfo['meet_greet'] == 0 ? "checked" : "" ?>>
                        <label class="form-check-label" for="meet_greet_no">NO</label>
                    </div>
                    <!-- ------------>


                </div>

                <?php if (
                    (is_array($applicantInfo) && $applicantInfo['status'] != "New" && $applicantInfo['status'] != "For Gmeet Interview" && $isOlderThan30Days)
                    || !is_array($applicantInfo)
                ): ?>

                    <div class="text-center my-3">

                        <button type="submit" name="adoptbtn"
                            class="btn mid-accent-bg text-white fs-4 p-3 lilita">Submit</button>

                    </div>

                <?php else: ?>

                    <script>
                        // Disable the whole form
                        const form = document.getElementById('applicationforms');
                        const elements = form.elements;
                        for (let i = 0; i < elements.length; i++) {
                            elements[i].disabled = true;
                        }
                    </script>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>