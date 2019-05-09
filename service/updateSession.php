<?php
if (!isset($_SESSION))
    session_start();
if (isset($_POST["change"])){
    $idx = -1;
    foreach ($_SESSION["userCart"] as $index=>$item) {
        if ($item["id"] == $_POST["id"]){
            $idx = $index;
            break;
        }
    }
    $_SESSION["userCart"][$idx]["quantity"]=$_POST["quantity"];
    header('Content-Type: application/json');
    echo json_encode($_SESSION["userCart"]);
}