<?php
    if (!isset($_SESSION))
        session_start();
    if (isset($_SESSION['signedIn'])) {
        unset($_SESSION['signedIn']);
        unset($_SESSION['isAdmin']);
        unset($_SESSION['username']);
        unset($_SESSION["userCart"]);
        header("location:../search-result.php");
    }
?>
