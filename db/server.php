<?php

require_once 'serverinfo.php';
$conn = new mysqli($host, $username, $password, $database, 3318);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '0');
ini_set('error_log', './');

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

function checklogin(): bool
{
  return isset($_SESSION['userid']) && !empty($_SESSION['userid']);
}

function adminchecklogin(): bool
{
  return isset($_SESSION['adminid']) && !empty($_SESSION['adminid']);
}

function userdetails($conn, $userid)
{
  $sql = "SELECT fname, lname, phone, gender, bday, email, mname, address FROM user WHERE userid = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  return $result->fetch_assoc(); // Return a single user row
}

function admindetails($conn, $userid)
{
  $sql = "SELECT fname, lname, phone, email, mname FROM admin WHERE adminid = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  return $result->fetch_assoc(); // Return a single user row
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logoutbtn'])) {
  session_unset();
  session_destroy();
  session_start();
  $_SESSION['errorMessage'] = "Logout successful! Please log in.";
  $_SESSION['errorType'] = "success";
  $_SESSION['errorHead'] = "Success!";
  header("Location: signin.php");
  exit();
}

date_default_timezone_set("Asia/Manila");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reportsubmit'])) {

  
  // Validate required fields
  if (empty($_POST['animalType']) || empty($_POST['animalLocation'])) {
    $_SESSION['errorMessage'] = "Please fill in all required fields.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Error!";
  } else {
    $pet_type = $_POST['animalType'];
    $location = $_POST['animalLocation'];
    $additionalInfo = $_POST['additionalInfo'];
    $userid = $_SESSION['userid']; // Get logged-in user ID

    // Get all selected conditions
    $conditions = [];
    if (isset($_POST['abused']))
      $conditions[] = "Abused";
    if (isset($_POST['hitByVehicle']))
      $conditions[] = "Hit by Vehicle";
    if (isset($_POST['stray']))
      $conditions[] = "Stray";
    if (isset($_POST['starving']))
      $conditions[] = "Starving";
    if (isset($_POST['others']) && !empty($_POST['specifyOthers'])) {
      $conditions[] = $_POST['specifyOthers']; // Add the "Others" input
    }
    $pet_condition = implode(", ", $conditions); // Convert array to comma-separated string

    // Handle file upload
    $picurl = "";
    if (!empty($_FILES["uploadVideo"]["name"])) {
      $target_dir = "assets/img/uploads/rescue/"; // Folder to store images
      $file_name = time() . "_" . basename($_FILES["uploadVideo"]["name"]);
      $target_file = $target_dir . $file_name;
      if (move_uploaded_file($_FILES["uploadVideo"]["tmp_name"], $target_file)) {
        $picurl = $file_name; // Save only filename to DB
      }
    }

    // Insert into `rescue` table
    $sql = "INSERT INTO rescue (pet_type, pet_condition, location, picurl, userid, additional) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $pet_type, $pet_condition, $location, $picurl, $userid, $additionalInfo);
    if ($stmt->execute()) {
      $_SESSION['errorMessage'] = "Rescue report submitted successfully.";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorHead'] = "Success!";

    } else {
      $_SESSION['errorMessage'] = "Error submitting report.";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorHead'] = "Error!";
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
}