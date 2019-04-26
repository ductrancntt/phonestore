<?php
if (!isset($_SESSION))
    session_start();

if(isset($_GET["id"])){

    if(isset($_SESSION["userCart"])){
        $userCart = $_SESSION["userCart"];
        $sum = 0;
        $isExist = false;
        for ($i =0 ; $i < count($userCart); $i++){
            $item = $userCart[$i];
            if($item["id"] == $_GET["id"]){
                $item["quantity"] = $item["quantity"] + 1;
                $userCart[$i] = $item;
                $isExist = true;
            }
            $sum += $userCart[$i]["quantity"];
        }
        if(!$isExist){
            array_push($userCart, ["id"=>$_GET["id"], "quantity" => 1]);
            echo "1";
        }else{
            echo $sum;
        }
        $_SESSION["userCart"] = $userCart;

    }
}

?>