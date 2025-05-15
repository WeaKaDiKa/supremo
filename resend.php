<?php
require_once 'db/server.php';
require_once 'db/sendmail.php';

if (!isset($_GET['email'])) {
    $_SESSION['errorMessage'] = "Email is required.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Error!";
    header("Location: signin.php");
    exit();
}

$email = trim($_GET['email']);

// Fetch user and token
$sql = "SELECT fname, token FROM user WHERE email = ? AND status != 'active'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $token = $user['token'];
    $fname = $user['fname'];

    // Compose and send email (adjust with your mail function)
    $activationLink = "https://supremofurbabies.great-site.net/verifyregister.php?token=" . urlencode($token);
    $subject = "Account Activation - Supremo Fur Babies";
    $message = "Hi $fname,\n\nPlease activate your account by clicking the link below:\n$activationLink\n\nThank you!";


    sendmail($email, $fname, $subject, $message);
    $_SESSION['errorMessage'] = "Activation email resent. Please check your inbox.";
    $_SESSION['errorType'] = "info";
    $_SESSION['errorHead'] = "Email Sent!";
} else {
    $_SESSION['errorMessage'] = "Account already active or does not exist.";
    $_SESSION['errorType'] = "warning";
    $_SESSION['errorHead'] = "Notice!";
}

header("Location: signin.php");
exit();
