<?php
require_once('db/server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginbtn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT userid, fname, mname, lname, email, password, status, token FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if account is active
        if ($user['status'] !== 'Active') {
            $_SESSION['errorMessage'] = "Your account is not yet activated. <a href='resend.php?email=" . urlencode($user['email']) . "' class='text-decoration-underline'>Click here to resend verification email</a>.";
            $_SESSION['errorType'] = "warning";
            $_SESSION['errorHead'] = "Account Not Activated!";
            header("Location: signin.php");
            exit();
        }

        // Check password
        if (password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['logintype'] = "client";
            $_SESSION['userfname'] = $user['fname'];
            $_SESSION['usermname'] = $user['mname'];
            $_SESSION['userlname'] = $user['lname'];
            $_SESSION['useremail'] = $user['email'];
            $_SESSION['errorMessage'] = "Login Successful";
            $_SESSION['errorType'] = "success";
            $_SESSION['errorHead'] = "Success!";

            // Determine redirection
            $next = $_GET['next'] ?? '';
            switch ($next) {
                case 'donate': header("Location: donate.php"); break;
                case 'volunteer': header("Location: visit.php"); break;
                case 'adopt': header("Location: adopthome.php"); break;
                default: header("Location: index.php"); break;
            }
            exit();
        }
    }

    // If login fails
    $_SESSION['errorMessage'] = "Wrong email or password.";
    $_SESSION['errorType'] = "danger";
    $_SESSION['errorHead'] = "Warning!";
    header("Location: signin.php");
    exit();
}
?>


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
            <div class="row g-0">
                <!-- Left Side (New User) -->
                <div class="col-md-6 mid-accent-bg text-white p-4 d-flex flex-column justify-content-center">
                    <h1 class="text-center lilita">NEW USER</h1>
                    <p>
                        By creating an account on the Supremo Furbabies website, you can easily submit adoption or
                        sponsorship applications, sign up as a volunteer, and send your donations – all in one place.
                    </p>
                    <div class="text-center">
                        <a class="btn w-100 dark-accent-bg text-white lilita" href="register.php">CREATE AN ACCOUNT
                            <i class="bi bi-person-circle"></i></a>
                    </div>
                </div>

                <!-- Right Side (Registered User) -->
                <div class="col-md-6 light-accent-bg p-4 d-flex flex-column justify-content-center">
                    <h1 class="text-center lilita">REGISTERED USER</h1>

                    <p>If you have an account, sign in with your email address.</p>
                    <?php require_once 'db/alert.php'; ?>


                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label lilita mb-0">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>

                  
<div class="mb-3">
    <label for="password" class="form-label lilita mb-0">PASSWORD</label>
    <div class="input-group">
        <input type="password" name="password" class="form-control" id="password" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
            <i id="toggleIcon" class="bi bi-eye-slash"></i>
        </button>
    </div>
</div>
<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
}
</script>

                        <button type="submit" name="loginbtn" class="btn mid-accent-bg text-white w-100 lilita">LOGIN <i
                                class="bi bi-person-circle"></i></button>

                        <div class="mt-2">
                            <a href="forgotpass.php" class="text-muted">Forgot your password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>