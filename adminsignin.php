<?php
require_once('db/server.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginbtn'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT adminid, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['adminid'] = $row['adminid'];
            $_SESSION['logintype'] = "admin";
            $_SESSION['errorMessage'] = "Login Successful";
            $_SESSION['errorType'] = "success";
            $_SESSION['errorHead'] = "Success!";
            header("Location: admindashboard.php");
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = "Wrong Credentials";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Warning!";
    }
}


?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Login | Supremo Fur Babies</title>
</head>

<body class="pic-bg">
    <?php require_once 'db/nav.php'; ?>
    <main>
        <div class="container my-5">

            <!-- Left Side (New User) -->


            <!-- Right Side (Registered User) -->
            <div class="light-accent-bg p-4 d-flex flex-column justify-content-center">
                <h1 class="text-center lilita">ADMIN USER</h1>

                <p>If you have an account, sign in with your email address.</p>
                <?php require_once 'db/alert.php'; ?>


                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label lilita mb-0">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label lilita mb-0">PASSWORD</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>

                    <button type="submit" name="loginbtn" class="btn mid-accent-bg text-white w-100 lilita">LOGIN <i
                            class="bi bi-person-circle"></i></button>

                    <div class="mt-2">
                        <a href="#" class="text-muted">Forgot your password?</a>
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