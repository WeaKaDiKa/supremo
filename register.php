<?php
require_once('db/server.php');
require_once('db/sendmail.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerbtn'])) {
    $fname = trim($_POST['first_name']);
    $mname = trim($_POST['middle_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['mobile']);
    $address = trim($_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $bday = $_POST['birthday'];

    // Check if email already exists
    $check_sql = "SELECT userid, status FROM user WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        if ($row['status'] === 'inactive') {
            $delete_sql = "DELETE FROM user WHERE userid = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $row['userid']);
            $delete_stmt->execute();
        } else {
            $_SESSION['errorMessage'] = "This email is already registered and verified.";
            $_SESSION['errorType'] = "danger";
            $_SESSION['errorHead'] = "Warning!";
            header("Location: register.php");
            exit();
        }
    }

    $token = bin2hex(random_bytes(10));
    $fullname = $fname . ' ' . $lname;

    $subject = "Verify Your Account";
    $message = "
        <p>Hello <strong>$fullname</strong>,</p>
        <p>Thank you for registering. Please click the button below to verify your email:</p>
        <p style='text-align:center; margin: 20px 0;'>
            <a href='https://supremofurbabies.great-site.net/verifyregister.php?token=$token' style='
                background-color: #d9a85b;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
            '>VERIFY EMAIL</a>
        </p>
        <p>If you did not register, please ignore this email.</p>
    ";

    sendmail($email, $fullname, $subject, $message);

    $insert_sql = "INSERT INTO user (fname, mname, lname, email, phone, address, password, gender, bday, token) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssssssssss", $fname, $mname, $lname, $email, $phone, $address, $password, $gender, $bday, $token);

    if ($stmt->execute()) {
        $_SESSION['errorMessage'] = "Registration successful! Please check your email to verify your account.";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorHead'] = "Success!";
        header("Location: signin.php");
        exit();
    } else {
        $_SESSION['errorMessage'] = "Registration failed. Try again.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorHead'] = "Error!";
    }
}
?>


?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'db/head.php'; ?>
    <title>Register | Supremo Fur Babies</title>
</head>

<body class="pic-bg">
    <?php require_once 'db/nav.php'; ?>
    <main>
        <?php require_once 'db/alert.php'; ?>
        <div class="container d-flex flex-column justify-content-cente align-items-center my-5">

            <div class="w-50 dark-accent-bg text-white card py-2 rounded rounded-0 mb-5">

                <h4 class="lilita dark-accent-fg text-white text-center m-0 p-2">CREATE AN ACCOUNT</h>


            </div>
            <div class="row justify-content-center px-3">
                <div class="col-md-8">
                    <div class="card light-accent-bg p-4 position-relative">
                        <div class="title-banner lilita">NEW USERS</div>
                        <form method="post">
                            <div class="row g-3 mt-5">


                                <div class="col-md-6">
                                    <h3 class="mb-3">Create an Account</h3>
                                    <div class="mb-3">
                                        <label for="email" class="form-label special-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label special-label">Mobile<span
                                                class="text-danger">*</span></label>
                                        <input type="tel" name="mobile" class="form-control" id="mobile" required
                                            placeholder="+639123456789" pattern="^\+63\d{10}$"
                                            title="Format: +639XXXXXXXXX">
                                        <script>
                                            document.getElementById('mobile').addEventListener('input', function (e) {
                                                // Allow only + and digits
                                                this.value = this.value.replace(/[^+\d]/g, '');

                                                // Ensure + is only at the start
                                                if (this.value.indexOf('+') > 0) {
                                                    this.value = this.value.replace(/\+/g, ''); // remove all +
                                                    this.value = '+' + this.value; // prepend one +
                                                }
                                            });
                                        </script>

                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label special-label">
                                            Password<span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" id="password"
                                                required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$"
                                                title="Password must be at least 8 characters long, include 1 lowercase, 1 uppercase, and 1 number or special character.">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password', 'toggleIcon1')">
                                                <i id="toggleIcon1" class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm-password" class="form-label special-label">
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





                                </div>
                                <div class="col-md-6">
                                    <h3 class="mb-3">Personal Information</h3>
                                    <div class="mb-3">
                                        <label for="first-name" class="form-label special-label">First Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control" id="first-name"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="middle-name" class="form-label special-label">Middle
                                                Name</label>
                                            <input type="text" name="middle_name" class="form-control" id="middle-name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last-name" class="form-label special-label">Last Name<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control" id="last-name"
                                                required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gender" class="form-label special-label">Gender<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="gender" id="gender" required>
                                            <option selected disabled>Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Prefer not to say">Prefer not to say</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthday" class="form-label special-label">Birthday<span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="birthday" class="form-control" id="birthday" required>
                                    </div>
                                </div>
                            </div>
                            <label for="birthday" class="form-label special-label">FULL ADDRESS <span
                                    class="text-danger">*</span></label>



                            <input type="text" name="address" class="form-control" id="address" required>

                            <?php require_once 'db/alert.php'; ?>

                            <div class="text-center mt-4">
                                <button type="submit" name="registerbtn"
                                    class="btn mid-accent-bg text-white w-100 lilita">REGISTER</button>
                                <div class="mt-2">
                                    <a href="signin.php" class="text-muted">Already have an account?</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


    </main>

    <?php
    require_once 'db/script.php';
    require_once 'db/footer.php'; ?>

</body>

</html>