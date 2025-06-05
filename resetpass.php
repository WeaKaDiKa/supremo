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
$sql = "SELECT userid FROM user WHERE token = ?";
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resetbtn'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['errorMessage'] = "Passwords do not match.";
        $_SESSION['errorType'] = "warning";
        $_SESSION['errorHead'] = "Warning!";
    } else {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the user's password and remove token
        $updateSql = "UPDATE user SET password = ?, token = NULL WHERE userid = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $hashedPassword, $userid);
        if ($updateStmt->execute()) {
            $_SESSION['errorMessage'] = "Password has been reset successfully. You may now log in.";
            $_SESSION['errorType'] = "success";
            $_SESSION['errorHead'] = "Success!";
            header("Location: signin.php");
            exit();
        } else {
            $_SESSION['errorMessage'] = "An error occurred while updating the password.";
            $_SESSION['errorType'] = "danger";
            $_SESSION['errorHead'] = "Error!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>RESET PASSWORD | Supremo Fur Babies</title>
</head>

<body class="pic-bg">
    <?php require_once 'db/nav.php'; ?>
    <main>

        <?php require_once 'db/alert.php'; ?>
        <div class="container my-5">
            <div class="light-accent-bg p-3 text-center position-relative">
                <div class="dark-accent-bg text-white py-2 px-4 d-inline-block lilita fs-4 mb-3 fw-bold">
                    <h1 class="m-0 p-0">RESET PASSWORD</h1>
                </div>

                <p class="mb-4 fw-bold lilita">Please kindly set your new password</p>

                <?php require_once 'db/alert.php'; ?>

                <form method="post">
   <!--                  <div class="mb-3 text-center mx-auto" style="max-width: 400px;">
                        <label for="password" class="form-label lilita">NEW PASSWORD <span
                                class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" id="password" required
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$"
                            title="Password must be at least 8 characters long, include 1 lowercase, 1 uppercase, and 1 number or special character.">
                    </div>

                    <div class="mb-3 text-center mx-auto" style="max-width: 400px;">
                        <label for="confirm_password" class="form-label lilita">CONFIRM PASSWORD <span
                                class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                            required>
                    </div> -->

                    <div class="mb-3">
                        <label for="password" class="form-label lilita">
                            Password<span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" required
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$"
                                title="Password must be at least 8 characters long, include 1 lowercase, 1 uppercase, and 1 number or special character.">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('password', 'toggleIcon1')">
                                <i id="toggleIcon1" class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm-password" class="form-label lilita">
                            Confirm Password<span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm-password" required>
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('confirm-password', 'toggleIcon2')">
                                <i id="toggleIcon2" class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <script>
                        function togglePassword(inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);
                            if (input.type === "password") {
                                input.type = "text";
                                icon.classList.remove("bi-eye-slash");
                                icon.classList.add("bi-eye");
                            } else {
                                input.type = "password";
                                icon.classList.remove("bi-eye");
                                icon.classList.add("bi-eye-slash");
                            }
                        }
                    </script>

                    <div class="mx-auto" style="max-width: 400px;">
                        <button type="submit" name="resetbtn" class="btn w-100 lilita text-white mid-accent-bg">
                            RESET PASSWORD
                        </button>
                    </div>
                </form>



            </div>
        </div>


    </main>

    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>