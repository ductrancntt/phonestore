<?php
if (!isset($_SESSION))
    session_start();

if(isset($_GET["id"])){
    require_once "./Connection.php";
    $product = null;
    $connection = new Connection;
    $connection->createConnection();
    $query = "SELECT * FROM product WHERE id = ".$_GET["id"];
    $result  = $connection->excuteQuery($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = $row;
            break;
        }
        $connection->closeConnection();

    } else {
        $connection->closeConnection();
    }
    if(isset($_SESSION["userCart"])){

        $userCart = $_SESSION["userCart"];
        $sum = 0;
        $isExist = false;
        for ($i =0 ; $i < count($userCart); $i++){
            $item = $userCart[$i];
            if($item["id"] == $_GET["id"]){
                if($product["quantity"] < $item["quantity"] + $_GET['quantity']){
                    echo -1;
                    return;
                }
                $item["quantity"] = $item["quantity"] + $_GET['quantity'];
                $userCart[$i] = $item;
                $isExist = true;
            }
            $sum += $userCart[$i]["quantity"];
        }
        if(!$isExist){
            if($product["quantity"] < $_GET['quantity']){
                echo -1;
                return;
            }
            array_push($userCart, ["id"=>$_GET["id"], "quantity" => $_GET['quantity']]);
            echo $sum + $_GET['quantity'];
        }else{
            echo $sum;
        }
        $_SESSION["userCart"] = $userCart;

    }
}

?>