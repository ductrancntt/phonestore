<?php

    require "Connection.php";
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }

    $userId = $_SESSION['user_id'];

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    $connection = new Connection();
    $connection->createConnection();

    function generateUpdateQuery($data, $id) {
        return "UPDATE `user` SET ".$data." WHERE `user`.`id`=".$id;
    }

    if ($name != null)
        $connection->excuteQuery(generateUpdateQuery("`name` = '".$name."'", $userId));
    if ($address != null)
        $connection->excuteQuery(generateUpdateQuery("`address` = '".$address."'", $userId));
    if ($phone != null)
        $connection->excuteQuery(generateUpdateQuery("`phone` = '".$phone."'", $userId));
    if ($email != null)
        $connection->excuteQuery(generateUpdateQuery("`email` = '".$email."'", $userId));

    $connection->closeConnection();

?>