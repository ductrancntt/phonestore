<?php

    require "Connection.php";
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }

    $userId = $_SESSION['user_id'];

    $password = isset($_POST['password']) ? json_decode($_POST['password']) : null;
    $newPassword = isset($_POST['newPassword']) ? json_decode($_POST['newPassword']) : null;

    $connection = new Connection();

    $connection->createConnection();

    $getCurrentPasswordQuery = "SELECT * FROM user WHERE user.id = ".$userId;
    $result = $connection->excuteQuery($getCurrentPasswordQuery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['password'] == $password) {
                $connection->excuteQuery("UPDATE user SET password='".$newPassword."' WHERE id=".$userId);
                $connection->closeConnection();
                header('Content-Type: application/json');
            }
        }
    } else {
        $connection->closeConnection();
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
    }

?>