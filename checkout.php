<?php
function getProductById($id)
{

    $connection = new Connection();
    $connection->createConnection();
    $product = null;

    $sql = "SELECT * FROM product WHERE id = " . $id;
    $result = $connection->excuteQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = $row;
        }
    }
    $connection->closeConnection();
    return $product;
}
if (!isset($_SESSION))
    session_start();
include("sendmail.php");
require_once "./service/Connection.php";
$connection = new Connection();
$connection->createConnection();
try {
    mysqli_query($connection->getConnection(), "START TRANSACTION");
    $date = new DateTime();
    $dateStr = $date->format("YmdHis");
    $sql = "INSERT INTO invoice(ship_address, created_date, user_id) VALUES('" . $_GET['diachi'] . "'," . $dateStr . "," . $_SESSION['user_id'] . ")";
    $invoiceId = insert($connection, $sql);
    $sum = 0;
    foreach ($_SESSION["userCart"] as $item) {
        $product = getProductById($item["id"]);
        if ($product["quantity"] >= $item["quantity"]) {
            $sql = "UPDATE product SET quantity = " . ($product["quantity"] - $item["quantity"]) . " WHERE id = " . $item["id"];
            $connection->excuteQuery($sql);
        }else{
            throw new ErrorException("hàng còn lại không đủ");
        }
        $sql = "INSERT INTO item(invoice_id, product_id,quantity, order_price) 
            VALUES(" . $invoiceId . "," . $item["id"] . "," . $item["quantity"] . "," . $product["price"] . ")";
        $sum += $item["quantity"]*$product["price"];
        insert($connection, $sql);
    }
    $sql = "UPDATE invoice SET total = " . $sum . " WHERE id = " . $invoiceId;
    $connection->excuteQuery($sql);
    sendMail($_SESSION["email"]);
    mysqli_query($connection->getConnection(), "COMMIT");
    $_SESSION["userCart"] = array();
    echo "COMMIT";
    header("location:./cart.php?success=true");
} catch (Exception $e) {
    print_r($e);
    mysqli_query($connection->getConnection(), "ROLLBACK");
    echo "ROLL BACK";
    header("location:./cart.php?success=false");
}

function insert($connection, $query)
{
    $connection->excuteQuery($query);
    $insertId = mysqli_insert_id($connection->getConnection());
    if ($insertId == 0) {
        throw new Exception("insert fail with query " . $query);
    }
    return $insertId;
}

?>