<?php

if (!isset($_SESSION['logintype'])) {
    header("location: signin.php");
} else {
    if ($_SESSION['logintype'] != "admin") {
        header("location: index.php");
    }
}