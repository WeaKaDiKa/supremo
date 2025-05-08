<?php
require_once "db/sendmail.php";
// Function to get applicant details
function getApplicantInfo($conn)
{
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM applicant WHERE userid = ? ORDER BY applicantid DESC LIMIT 1";

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adoptbtn'])) {
    $userid = $_SESSION['userid'];

    $occupation = $_POST['occupation'];
    $socialmedia = $_POST['socialmedia'];
    $alt_fname = $_POST['alt_fname'];
    $alt_lname = $_POST['alt_lname'];
    $alt_relation = $_POST['alt_relation'];
    $alt_phone = $_POST['alt_phone'];
    $alt_email = $_POST['alt_email'];
    $dwelling_type = $_POST['dwelling_type'];
    $dwelling_ownership = $_POST['dwelling_ownership'];
    $pet_allowed = $_POST['pet_allowed'];
    $live_with = isset($_POST['live_with']) ? implode(",", $_POST['live_with']) : "";

    $support_adopt = $_POST['support_adopt'];
    $future_move = $_POST['future_move'];
    $picked = $_POST['picked'];
    $pick_other = $_POST['pick_other'];
    $who_groom = $_POST['who_groom'];
    $who_finance = $_POST['who_finance'];
    $as_gift = $_POST['as_gift'];
    $alt_care = $_POST['alt_care'];
    $owner_type = $_POST['owner_type'];
    $pet_list = $_POST['pet_list'];
    $pet_still_owned = $_POST['pet_still_owned'];
    $adopt_supremo = isset($_POST['adopt_supremo']) ? implode(",", $_POST['adopt_supremo']) : "";

    $past_adopt = $_POST['past_adopt'];
    $why_adopt = $_POST['why_adopt'];
    $gmeet_date = $_POST['gmeet_date'];
    $gmeet_time = $_POST['gmeet_time'];
    $meet_greet = $_POST['meet_greet'];

    // Process both valid_id and home_pic uploads
    $uploadDir = "../assets/img/uploads/";
    $timestamp = date("Ymd_His");

    $valid_id_name = "";
    $home_pic_name = "";

    // if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] === UPLOAD_ERR_OK) {
    //     $validIdOriginal = basename($_FILES['valid_id']['name']);
    //     $validIdExt = pathinfo($validIdOriginal, PATHINFO_EXTENSION);
    //     $valid_id_name = pathinfo($validIdOriginal, PATHINFO_FILENAME) . "_$timestamp.$validIdExt";
    //     move_uploaded_file($_FILES['valid_id']['tmp_name'], $uploadDir . "id/" . $valid_id_name);
    // }

    if (!empty($_FILES["valid_id"]["name"])) {
        $target_dir = "assets/img/uploads/id/"; // Folder to store ID

        // Create folder if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES["valid_id"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["valid_id"]["tmp_name"], $target_file)) {
            $valid_id_name = $file_name; // Save to DB later
        }
    }


    // $home_pics = [];

    // if (isset($_FILES['home_pic']) && is_array($_FILES['home_pic']['name'])) {
    //     foreach ($_FILES['home_pic']['name'] as $index => $originalName) {
    //         if ($_FILES['home_pic']['error'][$index] === UPLOAD_ERR_OK) {
    //             $homePicExt = pathinfo($originalName, PATHINFO_EXTENSION);
    //             $fileBase = pathinfo($originalName, PATHINFO_FILENAME);
    //             $home_pic_name = $fileBase . "_$timestamp" . "_$index.$homePicExt";
    //             $targetPath = $uploadDir . "house/" . $home_pic_name;

    //             if (move_uploaded_file($_FILES['home_pic']['tmp_name'][$index], $targetPath)) {
    //                 $home_pics[] = $home_pic_name; // Save for DB insert
    //             }
    //         }
    //     }
    // }

    $home_pics = [];

    if (!empty($_FILES["home_pic"]["name"][0])) {
        $target_dir = "assets/img/uploads/house/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        foreach ($_FILES["home_pic"]["name"] as $key => $value) {
            $file_name = time() . "_" . $key . "_" . basename($_FILES["home_pic"]["name"][$key]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES["home_pic"]["tmp_name"][$key], $target_file)) {
                $home_pics[] = $file_name;
            }
        }
    }


    if ($valid_id_name != "") {
        $sql = "INSERT INTO applicant (
            userid, occupation, socialmedia, alt_fname, alt_lname, alt_relation, alt_phone, alt_email, 
            dwelling_type, dwelling_ownership, pet_allowed, live_with, support_adopt, future_move, picked, pick_other, 
            who_groom, who_finance, as_gift, alt_care, owner_type, pet_list, pet_still_owned, adopt_supremo, 
            past_adopt, why_adopt, valid_id, gmeet_date, gmeet_time, meet_greet
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "isssssssssssssssssssssssssssss",
            $userid,
            $occupation,
            $socialmedia,
            $alt_fname,
            $alt_lname,
            $alt_relation,
            $alt_phone,
            $alt_email,
            $dwelling_type,
            $dwelling_ownership,
            $pet_allowed,
            $live_with,
            $support_adopt,
            $future_move,
            $picked,
            $pick_other,
            $who_groom,
            $who_finance,
            $as_gift,
            $alt_care,
            $owner_type,
            $pet_list,
            $pet_still_owned,
            $adopt_supremo,
            $past_adopt,
            $why_adopt,
            $valid_id_name,
            $gmeet_date,
            $gmeet_time,
            $meet_greet
        );

        if ($stmt->execute()) {
            if (!empty($home_pics)) {

                $getOldPicsSql = "SELECT picurl FROM housepic WHERE userid = ?";
                $getOldPicsStmt = $conn->prepare($getOldPicsSql);
                $getOldPicsStmt->bind_param("i", $userid);
                $getOldPicsStmt->execute();
                $result = $getOldPicsStmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $oldFile = $uploadDir . "house/" . $row['picurl'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $deleteOldSql = "DELETE FROM housepic WHERE userid = ?";
                $deleteOldStmt = $conn->prepare($deleteOldSql);
                $deleteOldStmt->bind_param("i", $userid);
                $deleteOldStmt->execute();


                $housePicSql = "INSERT INTO housepic (userid, picurl) VALUES (?, ?)";
                $housePicStmt = $conn->prepare($housePicSql);

                foreach ($home_pics as $picName) {
                    $housePicStmt->bind_param("is", $userid, $picName);
                    $housePicStmt->execute();
                }
            }
            $userid = $_SESSION['userid']; // Get logged-in user ID
            $users = userdetails($conn, $userid);

            $email = $users['email'];
            $name = $users['fname'] . ' ' . $users['lname'];
            $subject = "Application Submitted Successfully";
            $message = "
                <p>Dear $name,</p>
                <p>Your adoption application has been <strong>successfully submitted</strong>.</p>
                <p>Your selected schedule for the Google Meet is on <strong>$gmeet_date</strong> at <strong>$gmeet_time</strong>.</p>
                <p>Please wait for further updates. We will contact you with more details soon.</p>
                <p>Thank you for your interest in adopting!</p>
                <p>Best regards,<br>Adoption Team</p>
            ";
            sendmail($email, $name, $subject, $message);

            $_SESSION['errorMessage'] = "Application successful!";
            $_SESSION['errorType'] = "success";
            $_SESSION['errorHead'] = "Success!";
        } else {
            $_SESSION['errorMessage'] = "Application failed. Try again.";
            $_SESSION['errorType'] = "danger";
            $_SESSION['errorHead'] = "Error!";
        }
    } else {
        $_SESSION['errorMessage'] = "No valid ID uploaded or there was an upload error.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Error!";
    }

    header('Location: adopthome.php');
    exit();
}
