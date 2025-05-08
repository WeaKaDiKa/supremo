<?php
require_once 'db/server.php';
require_once 'db/sendmail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgotbtn'])) {
    $email = trim($_POST['email']);

    $sql = "SELECT userid, fname, lname FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['fname'] . ' ' . $user['lname'];

        $token = bin2hex(random_bytes(10)); // 20-character random string

        $update_sql = "UPDATE user SET token = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $token, $email);
        $update_stmt->execute();

        $subject = "Forgot Password";
        $message = "
            <p>Hello <strong>$name</strong>,</p>
            <p>You requested to reset your password. Please click the button below to reset it:</p>
            <p style='text-align:center; margin: 20px 0;'>
                <a href='https://supremofurbabies.great-site.net/resetpass.php?token=$token' style='
                    background-color: #d9a85b;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    font-weight: bold;
                '>RESET PASSWORD</a>
            </p>
            <p>If you did not make this request, you can safely ignore this email.</p>
        ";

        sendmail($email, $name, $subject, $message);

        $_SESSION['errorMessage'] = "Reset link has been sent to your email.";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Success!";
    } else {
        $_SESSION['errorMessage'] = "Email not used in any account";
        $_SESSION['errorType'] = "warning";
        $_SESSION['errorHead'] = "Warning!";
    }
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Home | Supremo Fur Babies</title>
</head>

<body class="pic-bg">
    <?php require_once 'db/nav.php'; ?>
    <main>
        
        <?php require_once 'db/alert.php'; ?>
        <div class="container my-5">
            <div class="light-accent-bg py-5 text-center position-relative">
                <!-- Heading -->
                <div class="dark-accent-bg text-white py-2 px-4 d-inline-block lilita fs-4 mb-3 fw-bold">
                    <h1 class="m-0 p-0">FORGOT PASSWORD?</h1>
                </div>

                <!-- Subheading -->
                <p class="mb-4 fw-bold lilita">Enter your email address so that we can send you a password reset link</p>

                <!-- Alert messages -->
                <?php require_once 'db/alert.php'; ?>

                <!-- Forgot password form -->
                <form method="post">
                    <div class="mb-3 text-center mx-auto" style="max-width: 400px;">
                        <label for="email" class="form-label special-label">EMAIL <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="mx-auto" style="max-width: 400px;">
                        <button type="submit" name="forgotbtn" class="btn w-100 lilita text-white mid-accent-bg"
                          >SEND EMAIL</button>
                    </div>
                </form>

                <!-- Back to login -->
                <div class="mt-4 lilita">
                    <a href="signin.php" class="text-dark text-decoration-none">
                        &gt; BACK TO LOGIN
                    </a>
                </div>

           
            </div>
        </div>


    </main>

    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>