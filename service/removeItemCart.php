<?php
if (!isset($_SESSION))
    session_start();

if(isset($_GET["id"])){

    if(isset($_SESSION["userCart"])){
        $userCart = $_SESSION["userCart"];
        if(count($userCart) == 1) $_SESSION["userCart"] = array();
        else {
            for ($i = 0; $i < count($userCart); $i++) {
                $item = $userCart[$i];
                if ($item["id"] == $_GET["id"]) {
                    unset($userCart[$i]);
                }
            }
            $_SESSION["userCart"] = $userCart;
        }
        print_r($_SESSION["userCart"]);
       header("location:../cart.php");
    }
}
?>
