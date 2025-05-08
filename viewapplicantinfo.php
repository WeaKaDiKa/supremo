<?php
require_once('db/server.php');
require_once('db/adminloginverify.php');

require_once('db/sendmail.php');
function getApplicantInfo($conn)
{
    $userid = $_POST['applicantid'];
    $sql = "SELECT * FROM applicant WHERE applicantid = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the latest matching row
    } else {
        return "0";
    }
}



$applicantInfo = getApplicantInfo($conn);
$appicantDetail = userdetails($conn, $applicantInfo["userid"]);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['applicantedit'])) {

    $applicantid = intval($_POST['applicantid']);
    $status = $_POST['status'];
    $gmeetlink = !empty(trim($_POST['gmeetlink'])) ? trim($_POST['gmeetlink']) : null;


    $stmt = $conn->prepare("UPDATE applicant SET status = ?, gmeetlink = ? WHERE applicantid = ?");
    $stmt->bind_param("ssi", $status, $gmeetlink, $applicantid);
    $stmt->execute();
    $stmt->close();


    $detailQuery = $conn->prepare("SELECT u.email, u.fname, u.lname, a.userid
    FROM applicant a
    JOIN user u ON a.userid = u.userid
    WHERE a.applicantid = ?
    ");
    $detailQuery->bind_param("i", $applicantid);
    $detailQuery->execute();
    $detailQuery->bind_result($email, $fname, $lname, $userid);
    $detailQuery->fetch();
    $detailQuery->close();

    $name = $fname . ' ' . $lname;


    $subject = "Application Status Update";
    $message = "<p>Dear $name,</p>";

    if ($status === 'For Gmeet Interview' && $gmeetlink) {
        $message .= "<p>Your application status is now <strong>For Gmeet Interview</strong>.</p>
                     <p>Please join the meeting using the following link:</p>
                     <p><a href='$gmeetlink' target='_blank' style='background-color:#1a73e8;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;'>Join Google Meet</a></p>";
    } elseif ($status === 'Approved') {
        $message .= "<p>Congratulations! Your application has been <strong>Approved</strong>.</p>
                     <p>Thank you for adopting a pet!</p>";
    } elseif ($status === 'Disapproved') {
        $message .= "<p>We're sorry to inform you that your application has been <strong>Disapproved</strong>.</p>";
    }

    $message .= "<p>Best regards,<br>Adoption Team</p>";


    sendmail($email, $name, $subject, $message);


    if ($status === 'Approved' && isset($_POST['petid'])) {
        $petid = intval($_POST['petid']);
        $adminid = $_SESSION['adminid'];
        $adoptionDate = date('Y-m-d');

        $insertAdoption = $conn->prepare("INSERT INTO adoption (petid, userid, adminid, adoption_date) VALUES (?, ?, ?, ?)");
        $insertAdoption->bind_param("iiis", $petid, $userid, $adminid, $adoptionDate);
        $insertAdoption->execute();
        $insertAdoption->close();

        $updatePetStatus = $conn->prepare("UPDATE pet SET status = 'unavailable' WHERE petid = ?");
        $updatePetStatus->bind_param("i", $petid);
        $updatePetStatus->execute();
        $updatePetStatus->close();
    }

    $_SESSION['successMessage'] = "Application updated and email sent successfully.";
    header("Location: adminadoption.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php
    $page = "adoption";
    require_once 'db/head.php'; ?>
    <title>Admin | Supremo Fur Babies</title>


</head>

<body>
    <?php require_once 'db/nav.php'; ?>

    <div class="d-flex w-100 align-items-stretch flex-grow-1 flex-column flex-md-row">
        <?php require_once 'db/sidebar.php'; ?>
        <div class="flex-grow-1 gradient-bg" style="overflow-x: hidden!important;">
            <?php require_once 'db/alert.php'; ?>
            <div class="py-5 container-fluid main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="lilita dark-accent-fg">Applicant</h1>
                        <hr>

                        <h3 class="mb-3 lilita">Applicant's Info</h3>
                        <p class="mb-0 fw-bold">COMPLETE NAME <span class="text-danger">*</span></p>
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-3 no-border" id="fname" placeholder="First"
                                    value="<?= $appicantDetail['fname'] ?>" disabled>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-3 no-border" id="mname" placeholder="Middle"
                                    value="<?= $appicantDetail['mname'] ?>" disabled>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-3 no-border" id="lname" placeholder="Last"
                                    value="<?= $appicantDetail['lname'] ?>" disabled>
                            </div>
                        </div>
                        <p class="mb-0 fw-bold">FULL ADDRESS <span class="text-danger">*</span></p>
                        <p class="text-muted mb-0">Follow this format: Unit, Building Name, House Number, Street,
                            Barangay,
                            City, Region, Zip Code</p>
                        <input type="text" name="address" class="form-control mb-3 no-border" id="address"
                            placeholder="Address"
                            value="<?= is_array($appicantDetail) ? $appicantDetail['address'] : "" ?>">
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">PHONE NUMBER <span class="text-danger">*</span></p>
                                <input type="text" class="form-control mb-3 no-border" id="phone" placeholder="Phone"
                                    value="<?= $appicantDetail['phone'] ?>" disabled>
                            </div>
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></p>
                                <input type="email" class="form-control mb-3 no-border" id="email" placeholder="Email"
                                    value="<?= $appicantDetail['email'] ?>" disabled>
                            </div>
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">OCCUPATION <span class="text-danger">*</span></p>
                                <input type="occupation" name="occupation" class="form-control mb-3 no-border"
                                    id="occupation" placeholder="Occupation" disabled
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['occupation'] : "" ?>">
                            </div>
                        </div>
                        <p class="mb-0 fw-bold">BIRTHDATE <span class="text-danger">*</span></p>
                        <p class="text-muted mb-0">If you are a Minor, please make sure you have your
                            Parent/Guardian's
                            consent. They will also be asked to join the Adoption Interview.</p>
                        <input type="date" class="form-control mb-3 no-border" id="bday"
                            value="<?= $appicantDetail['bday'] ?>" disabled>

                        <p class="mb-0 fw-bold">SOCIAL MEDIA PROFILE <span class="text-danger">*</span></p>
                        <p class="text-muted mb-0">Sample format: https://www.facebook.com/juandelacruz or type
                            ‘N/A’ if
                            no
                            social media</p>
                        <input type="text" name="socialmedia" class="form-control mb-3 no-border" id="socialmedia"
                            disabled placeholder="Social Media"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['socialmedia'] : "" ?>">
                        <p class="mb-0 fw-bold">ALTERNATE CONTACT <span class="text-danger">*</span></p>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="alt_fname" class="form-control mb-3 no-border" id="alt_fname"
                                    placeholder="First" disabled
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['alt_fname'] : "" ?>">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="alt_lname" class="form-control mb-3 no-border" id="alt_lname"
                                    placeholder="Last" disabled
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['alt_lname'] : "" ?>">
                            </div>
                        </div>
                        <p class="text-muted mb-0">If the applicant is a minor, a parent or a guardian must be the
                            alternate
                            contact and co-sign the application.</p>
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">RELATIONSHIP <span class="text-danger">*</span></p>
                                <input type="alt_relation" disabled name="alt_relation"
                                    class="form-control mb-3 no-border" id="alt_relation" placeholder="Relationship"
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['alt_relation'] : "" ?>">
                            </div>
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">PHONE NUMBER <span class="text-danger">*</span></p>
                                <input type="text" disabled name="alt_phone" class="form-control mb-3 no-border"
                                    id="alt_phone" placeholder="Phone"
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['alt_phone'] : "" ?>">
                            </div>
                            <div class="col-lg-4">
                                <p class="mb-0 fw-bold">EMAIL ADDRESS <span class="text-danger">*</span></p>
                                <input type="email" disabled name="alt_email" class="form-control mb-3 no-border"
                                    id="alt_email" placeholder="Email"
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['alt_email'] : "" ?>">
                            </div>

                        </div>

                        <hr>
                        <h3 class="mb-3 lilita">Questionnaire</h3>
                        <p class="text-muted mb-0">In an effort to help the process go smoothly, please be as
                            detailed
                            as
                            possible with your responses to the questions below.</p>
                        <p class="mb-0 fw-bold">TYPE OF DWELLING <span class="text-danger">*</span></p>

                        <?php
                        $dwellingType = isset($applicantInfo['dwelling_type']) ? $applicantInfo['dwelling_type'] : '';
                        ?>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_type" class="form-check-input"
                                id="dwelling_condo" value="condo" <?= ($dwellingType == "condo") ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="dwelling_condo">CONDO/UNIT</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_type" class="form-check-input"
                                id="dwelling_apartment" value="apartment" <?= ($dwellingType == "apartment") ? "checked" : "" ?>>
                            <label class="form-check-label" for="dwelling_apartment">APARTMENT/TOWNHOUSE</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_type" class="form-check-input"
                                id="dwelling_single" value="single" <?= ($dwellingType == "single") ? "checked" : "" ?>>
                            <label class="form-check-label" for="dwelling_single">SINGLE-STOREY HOUSE</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_type" class="form-check-input"
                                id="dwelling_others" value="others" <?= ($dwellingType == "others") ? "checked" : "" ?>>
                            <label class="form-check-label" for="dwelling_others">OTHERS</label>
                        </div>

                        <!-- ------------>

                        <p class="mb-0 fw-bold mt-3">IF YOU ARE RENTING, HAVE YOU CONFIRMED THAT PETS ARE ALLOWED BY
                            THE
                            OWNER OR THE CONDO ADMIN? <span class="text-danger">*</span></p>
                        <?php
                        $petAllowed = isset($applicantInfo['pet_allowed']) ? $applicantInfo['pet_allowed'] : '';
                        ?>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pet_allowed" class="form-check-input"
                                id="pet_allowed_yes" value="yes" <?= ($petAllowed == 1) ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="pet_allowed_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pet_allowed" class="form-check-input" id="pet_allowed_no"
                                value="no" <?= ($petAllowed == 0) ? "checked" : "" ?>>
                            <label class="form-check-label" for="pet_allowed_no">NO</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pet_allowed" class="form-check-input"
                                id="pet_allowed_not_sure" value="not_sure" <?= ($petAllowed == "not_sure") ? "checked" : "" ?>>
                            <label class="form-check-label" for="pet_allowed_not_sure">NOT SURE</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pet_allowed" class="form-check-input"
                                id="pet_allowed_we_own" value="we_own" <?= ($petAllowed == "we_own") ? "checked" : "" ?>>
                            <label class="form-check-label" for="pet_allowed_we_own">WE OWN OUR DWELLING</label>
                        </div>
                        <!-- ------------>

                        <p class="mb-0 fw-bold mt-3">DWELLING OWNERSHIP <span class="text-danger">*</span></p>

                        <?php
                        $dwellingOwnership = isset($applicantInfo['dwelling_ownership']) ? $applicantInfo['dwelling_ownership'] : '';
                        ?>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_ownership" class="form-check-input"
                                id="dwelling_ownership_rent" value="rent" <?= ($dwellingOwnership == "rent") ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="dwelling_ownership_rent">RENT</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="dwelling_ownership" class="form-check-input"
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
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_alone" value="alone" <?= in_array("alone", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_alone">LIVING ALONE</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_spouse" value="spouse" <?= in_array("spouse", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_spouse">SPOUSE</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_parents" value="parent" <?= in_array("parent", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_parents">PARENTS</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_relatives" value="relatives" <?= in_array("relatives", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_relatives">RELATIVES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_child_over" value="child_over" <?= in_array("child_over", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_child_over">CHILDREN OVER 18</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_child_under" value="child_under" <?= in_array("child_under", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_child_under">CHILDREN UNDER 18</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="live_with[]" class="form-check-input"
                                id="live_with_rent" value="rent" <?= in_array("rent", $liveWithArray) ? "checked" : "" ?>>
                            <label class="form-check-label" for="live_with_rent">ROOMMATE/S</label>
                        </div>
                        <!-- ------------>


                        <p class="mb-0 fw-bold mt-3">ARE ALL THE MEMBERS OF YOUR HOUSEHOLD SUPPORTIVE OF ADOPTING?
                            <span class="text-danger">*</span>
                        </p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="support_adopt" class="form-check-input"
                                id="support_adopt_yes" value="yes" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="support_adopt_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="support_adopt" class="form-check-input"
                                id="support_adopt_no" value="no" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="support_adopt_no">NO</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="support_adopt" class="form-check-input"
                                id="support_adopt_not_sure" value="not_sure" <?= is_array($applicantInfo) && $applicantInfo['support_adopt'] == "not_sure" ? "checked" : "" ?>>
                            <label class="form-check-label" for="support_adopt_not_sure">NOT SURE</label>
                        </div>
                        <!-- ------------>

                        <p class="mb-0 fw-bold mt-3">ARE YOU PLANNING TO MOVE IN THE FUTURE? <span
                                class="text-danger">*</span></p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="future_move" class="form-check-input"
                                id="future_move_yes" value="yes" <?= is_array($applicantInfo) && $applicantInfo['future_move'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="future_move_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="future_move" class="form-check-input" id="future_move_no"
                                value="no" <?= is_array($applicantInfo) && $applicantInfo['future_move'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="future_move_no">NO</label>
                        </div>

                        <!-- ------------>
                        <p class="mb-0 fw-bold mt-3">NAME OF RESCUE YOU WANT TO ADOPT <span class="text-danger">*</span>
                        </p>
                        <p class="text-muted mb-0">Type 'N/A' if you don't have a specific rescue in mind and/or
                            want to
                            pick
                            and decide when you visit the shelter.</p>
                        <input type="text" disabled name="picked" class="form-control mb-3 no-border" id="picked"
                            placeholder="Name of Pet Desired"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['picked'] : "" ?>">


                        <p class="mb-0 fw-bold mt-3">IF THE RESCUE YOU INDICATED ABOVE IS NO LONGER AVAILABLE, ARE
                            YOU
                            OPEN TO CHOOSING ANOTHER RESCUE? <span class="text-danger">*</span></p>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pick_other" class="form-check-input" id="pick_other_yes"
                                value="yes" <?= is_array($applicantInfo) && $applicantInfo['pick_other'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="pick_other_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="pick_other" class="form-check-input" id="pick_other_no"
                                value="no" <?= is_array($applicantInfo) && $applicantInfo['pick_other'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="pick_other_no">NO</label>
                        </div>


                        <p class="mb-0 fw-bold mt-3">WHO WILL BE RESPONSIBLE FOR FEEDING, GROOMING, AND GENERALLY
                            CARING
                            FOR THE PET? <span class="text-danger">*</span>
                        </p>
                        <input type="text" disabled name="who_groom" class="form-control mb-3 no-border" id="who_groom"
                            placeholder="Name of Responsible for Pet"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['who_groom'] : "" ?>">



                        <p class="mb-0 fw-bold mt-3">WHO WILL BE FINANCIALLY RESPONSIBLE FOR THE PET’S NEEDS (I.E.
                            FOOD,
                            VET BILLS, ETC.)? <span class="text-danger">*</span>
                        </p>
                        <input type="text" disabled class="form-control mb-3 no-border" id="who_finance"
                            placeholder="Name of Responsible Financially" name="who_finance"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['who_finance'] : "" ?>">


                        <p class="mb-0 fw-bold mt-3">DO YOU PLAN TO ADOPT THIS PET AS A GIFT? <span
                                class="text-danger">*</span></p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="as_gift" class="form-check-input" id="as_gift_yes"
                                value="yes" <?= is_array($applicantInfo) && $applicantInfo['as_gift'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="as_gift_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="as_gift" class="form-check-input" id="as_gift_no"
                                value="no" <?= is_array($applicantInfo) && $applicantInfo['as_gift'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="as_gift_no">NO</label>
                        </div>
                        <!-- ------------>

                        <p class="mb-0 fw-bold mt-3">WHO WILL LOOK AFTER YOUR PET IF YOU GO ON VACATION OR IN CASE
                            OF
                            EMERGENCY? <span class="text-danger">*</span>
                        </p>
                        <input type="text" disabled name="alt_care" class="form-control mb-3 no-border" id="alt_care"
                            placeholder="Name"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['alt_care'] : "" ?>">



                        <p class="mb-0 fw-bold mt-3">WHICH OF THE FOLLOWING BEST DESCRIBES YOUR EXPERIENCE <span
                                class="text-danger">*</span></p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="owner_type" class="form-check-input" id="owner_type_new"
                                value="new" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "new" ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="owner_type_new">
                                NEW PET OWNER (THIS WILL BE THE FIRST TIME OWNING A PET)
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="owner_type" class="form-check-input"
                                id="owner_type_less_than" value="less_than" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "less_than" ? "checked" : "" ?>>
                            <label class="form-check-label" for="owner_type_less_than">
                                RECENT PET OWNER (MY FAMILY/I OWN/OWNED A PET LESS THAN 3 YEARS)
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabledname="owner_type" class="form-check-input"
                                id="owner_type_more_than" value="more_than" <?= is_array($applicantInfo) && $applicantInfo['owner_type'] == "more_than" ? "checked" : "" ?>>
                            <label class="form-check-label" for="owner_type_more_than">
                                SEASONED PET OWNER (MY FAMILY/I OWN/OWNED A PET MORE THAN 3 YEARS)
                            </label>
                        </div>
                        <!-- ------------>


                        <p class="mb-0 fw-bold mt-3">LIST ALL THE PETS YOU’VE HAD OR HAVE <span
                                class="text-danger">*</span>
                        </p>
                        <p class="text-muted mb-0">Follow this format: Total number and breed (e.g 3 Shi Tzu, 1
                            Aspins,
                            4
                            Persian Cats).</p>
                        <input type="text" disabled name="pet_list" class="form-control mb-3 no-border" id="pet_list"
                            placeholder="e.g 3 Shi Tzu, 1 Aspins, 4 Persian Cats"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['pet_list'] : "" ?>">


                        <p class="mb-0 fw-bold mt-3">DO YOU STILL OWN ALL OF THEM? <span class="text-danger">*</span>
                        </p>
                        <p class="text-muted mb-0">If not, please indicate the reason/s why. If your pet passed
                            away,
                            kindly
                            type when it happened and the cause of death</p>
                        <input type="text" disabled name="pet_still_owned" class="form-control mb-3 no-border"
                            id="pet_still_owned" placeholder="Still owned?"
                            value="<?= is_array($applicantInfo) ? $applicantInfo['pet_still_owned'] : "" ?>">


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
                            <input type="checkbox" disabled name="adopt_supremo[]" class="form-check-input"
                                id="adopt_supremo_friend" value="friend" <?= in_array("friend", $adopt_supremo) ? "checked" : "" ?>>
                            <label class="form-check-label" for="adopt_supremo_friend">FRIENDS</label>
                        </div>

                        <!-- FACEBOOK -->
                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="adopt_supremo[]" class="form-check-input"
                                id="adopt_supremo_facebook" value="facebook" <?= in_array("facebook", $adopt_supremo) ? "checked" : "" ?>>
                            <label class="form-check-label" for="adopt_supremo_facebook">FACEBOOK</label>
                        </div>

                        <!-- OTHER -->
                        <div class="form-check form-check-inline">
                            <input type="checkbox" disabled name="adopt_supremo[]" class="form-check-input"
                                id="adopt_supremo_other" value="other" <?= in_array("other", $adopt_supremo) ? "checked" : "" ?>>
                            <label class="form-check-label" for="adopt_supremo_other">OTHER</label>
                        </div>

                        <!-- ------------>


                        <p class="mb-0 fw-bold mt-3">HAVE YOU ADOPTED FROM SUPREMO BEFORE? <span
                                class="text-danger">*</span></p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="past_adopt" class="form-check-input" id="past_adopt_yes"
                                value="yes" <?= is_array($applicantInfo) && $applicantInfo['past_adopt'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="past_adopt_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="past_adopt" class="form-check-input" id="past_adopt_no"
                                value="no" <?= is_array($applicantInfo) && $applicantInfo['past_adopt'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="past_adopt_no">NO</label>
                        </div>

                        <!-- ------------>

                        <p class="mb-0 fw-bold mt-3">WHAT MADE YOU CONSIDER ADOPTING A RESCUE? <span
                                class="text-danger">*</span>
                        </p>
                        <input type="text" name="why_adopt" class="form-control mb-3 no-border" id="why_adopt"
                            placeholder="Reason for Adoption" disabled
                            value="<?= is_array($applicantInfo) ? $applicantInfo['why_adopt'] : "" ?>">


                        <p class="mb-0 fw-bold mt-3">UPLOAD A COPY OF VALID ID <span class="text-danger">*</span>
                        </p>

                        <?php
                        $validIdUrl = null;

                        // Assuming $conn and $userid are available
                        $validIdQuery = "SELECT valid_id FROM applicant WHERE userid = ? ORDER BY applicantid DESC LIMIT 1";
                        $stmt = $conn->prepare($validIdQuery);
                        $stmt->bind_param("i", $applicantInfo['userid']);
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


                        <p class="mb-0 fw-bold mt-3">PLEASE ATTACH PHOTOS OF YOUR HOME <span
                                class="text-danger">*</span>
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


                        <?php
                        $housePics = [];

                        $sql = "SELECT picurl FROM housepic WHERE userid = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $applicantInfo['userid']);
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



                        <p class="mb-0 fw-bold mt-3">INTERVIEW & VISITATION (MINORS MUST BE ACCOMPANIED BY A PARENT
                            OR
                            GUARDIAN.) </p>



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
                                    value="<?= is_array($applicantInfo) ? $applicantInfo['gmeet_time'] : "" ?>"
                                    disabled>

                            </div>
                        </div>




                        <p class="mb-0 fw-bold mt-3">Will you be able to visit the shelter for the meet-and-greet?
                            <span class="text-danger">*</span>
                        </p>
                        <!-- ------------>
                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="meet_greet" class="form-check-input" id="meet_greet_yes"
                                value="yes" <?= is_array($applicantInfo) && $applicantInfo['meet_greet'] == 1 ? "checked" : "checked" ?>>
                            <label class="form-check-label" for="meet_greet_yes">YES</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" disabled name="meet_greet" class="form-check-input" id="meet_greet_no"
                                value="no" <?= is_array($applicantInfo) && $applicantInfo['meet_greet'] == 0 ? "checked" : "" ?>>
                            <label class="form-check-label" for="meet_greet_no">NO</label>
                        </div>
                        <!-- ------------>
                        <form method="post">

                            <input type="hidden" name="applicantid"
                                value="<?= htmlspecialchars($applicantInfo['applicantid']) ?>">


                            <label for="status" class="mb-0 fw-bold mt-3">Application Status</label>
                            <select class="form-select" id="status" name="status" required
                                <?= $applicantInfo['status'] === 'Disapproved' || $applicantInfo['status'] === 'Approved' ? 'disabled' : '' ?>>
                                <option disabled <?= $applicantInfo['status'] === 'New' ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="For Gmeet Interview" <?= $applicantInfo['status'] === 'For Gmeet Interview' ? 'selected' : '' ?>>For Gmeet Interview</option>
                                <option value="Disapproved" <?= $applicantInfo['status'] === 'Disapproved' ? 'selected' : '' ?>>Disapproved</option>
                                <option value="Approved" <?= $applicantInfo['status'] === 'Approved' ? 'selected' : '' ?>
                                    <?= $applicantInfo['status'] !== 'Approved' ? 'disabled' : '' ?>>Approved</option>
                            </select>

                            <div id="gmeet-link-group">
                                <label for="gmeetlink" class="mb-0 fw-bold mt-3">Google Meet Link
                                    <span class="text-danger" id="gmeet-required-indicator"
                                        style="display: none;">*</span>
                                </label>
                                <input type="url" name="gmeetlink" id="gmeetlink" class="form-control"
                                    value="<?= isset($applicantInfo['gmeetlink']) ? htmlspecialchars($applicantInfo['gmeetlink']) : '' ?>">
                            </div>

                            <script>
                                function handleStatusChange() {
                                    const status = $('#status').val();
                                    const gmeetGroup = $('#gmeet-link-group');
                                    const gmeetInput = $('#gmeetlink');
                                    const requiredIndicator = $('#gmeet-required-indicator');

                                    if (status === 'New') {
                                        gmeetGroup.hide();
                                        gmeetInput.prop('required', false).prop('readonly', false).val('');
                                        $('#status option[value="Approved"]').prop('disabled', true);
                                    } else if (status === 'For Gmeet Interview') {
                                        gmeetGroup.show();
                                        gmeetInput.prop('required', true).prop('readonly', false);
                                        requiredIndicator.show();
                                        $('#status option[value="Approved"]').prop('disabled', false);
                                    } else if (status === 'Approved') {
                                        gmeetGroup.show();
                                        gmeetInput.prop('required', false).prop('readonly', true);
                                        requiredIndicator.hide();
                                        $('#status option[value="Approved"]').prop('disabled', false);
                                    } else if (status === 'Disapproved') {
                                        gmeetGroup.hide();
                                        gmeetInput.prop('required', false).prop('readonly', false);
                                        requiredIndicator.hide();
                                        $('#status option[value="Approved"]').prop('disabled', false);
                                    }
                                }

                                $(document).ready(function () {
                                    handleStatusChange(); // initial load
                                    $('#status').on('change', handleStatusChange);
                                });
                            </script>




                            <div id="pet-selection" style="display: none;">
                                <label for="petid" class="mb-0 fw-bold mt-3">Select Pet for Adoption</label>
                                <select class="form-select" id="petid" name="petid"
                                    <?= $applicantInfo['status'] === 'Approved' ? 'disabled' : '' ?>>
                                    <?php
                                    // Fetch available pets
                                    $petQuery = "SELECT petid, name FROM pet WHERE status = 'available'";
                                    $petResult = $conn->query($petQuery);
                                    while ($pet = $petResult->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($pet['petid']) . '">' . htmlspecialchars($pet['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" name="applicantedit" class="btn btn-primary mt-3"
                                <?= $applicantInfo['status'] === 'Approved' ? 'disabled' : '' ?>>Save
                                Changes</button>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const statusSelect = document.getElementById('status');
                                const petSelection = document.getElementById('pet-selection');

                                function togglePetSelection() {
                                    if (statusSelect.value === 'Approved') {
                                        petSelection.style.display = 'block';
                                    } else {
                                        petSelection.style.display = 'none';
                                    }
                                }

                                statusSelect.addEventListener('change', togglePetSelection);
                                togglePetSelection(); // Initialize on page load
                            });
                        </script>


                    </div>
                </div>


            </div>
            <?php
            require_once 'db/script.php';
            //   require_once 'adoptformmodal.php';
            ?>
            <script>
                $(document).ready(function () {
                    $('#dataTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "lengthChange": true
                    });
                    $('#dataTable2').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "lengthChange": true
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>