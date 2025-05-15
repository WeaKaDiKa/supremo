<?php
require_once 'db/server.php';

if (!isset($_GET['token']) || empty(trim($_GET['token']))) {
    $_SESSION['errorMessage'] = "Invalid or missing token.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Error!";
    header("Location: signin.php");
    exit();
}

$token = trim($_GET['token']);

// Check if token exists in the database
$sql = "SELECT userid, fname, mname, lname, email, status FROM user WHERE token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['errorMessage'] = "Invalid or expired token.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Error!";
    header("Location: signin.php");
    exit();
}

$user = $result->fetch_assoc();
$userid = $user['userid'];
$status = $user['status'];

if ($status === 'active') {
    $_SESSION['errorMessage'] = "Your account is already activated.";
    $_SESSION['errorType'] = "info";
    $_SESSION['errorHead'] = "Notice!";
    header("Location: signin.php");
    exit();
}

// Activate the user account and remove the token
$updateSql = "UPDATE user SET status = 'active', token = NULL WHERE userid = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("i", $userid);

if ($updateStmt->execute()) {
    // Auto-login
  /*   $_SESSION['auth'] = true;
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['userfname'] = $user['fname'];
    $_SESSION['usermname'] = $user['mname'];
    $_SESSION['userlname'] = $user['lname'];
    $_SESSION['useremail'] = $user['email']; */

    $_SESSION['errorMessage'] = "Account activated successfully!";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorHead'] = "Welcome!";

    header("Location: signin.php");
} else {
    $_SESSION['errorMessage'] = "An error occurred while activating your account.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Error!";
    header("Location: register.php");
    exit();
}

