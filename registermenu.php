<?php
require_once('db/server.php');
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
            <div class="w-75 light-accent-bg card p-4">
                <div class="row">
                    <div class="col-2">

                    </div>
                    <div class="col-8 text-center">
                        <h1 class="lilita dark-accent-fg">NEW USER</h1>
                        <p class="lilita">By creating an account on the Supremo Furbabies website allows
                            you to easily submit adoption or sponsorship applications, sign up as a
                            volunteer and send your donations- in one place</p>
                    </div>
                    <div class="col-2">

                    </div>
                </div>

            </div>

            <div class="row mb-5 px-3">
                <div class="col-md-4 my-3">
                    <a href="register.php?next=adopt" class="mid-accent-bg p-4 text-center d-flex align-items-center h-100">
                        <h3 class="lilita p-0 m-0">
                            Do you want to adopt?
                        </h3>
                    </a>
                </div>
                <div class="col-md-4 my-3">
                    <a href="register.php?next=volunteer" class="mid-accent-bg p-4 text-center d-flex align-items-center h-100">
                        <h3 class="lilita p-0 m-0">
                            Do you want to volunteer?
                        </h3>
                    </a>
                </div>
                <div class="col-md-4 my-3">
                    <a href="register.php?next=donate" class="mid-accent-bg p-4 text-center d-flex align-items-center h-100">
                        <h3 class="lilita p-0 m-0">
                            Do you want to donate?
                        </h3>
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