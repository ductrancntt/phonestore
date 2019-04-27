<?php

    require "Connection.php";
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    } else {
        $userId = $_SESSION['user_id'];

        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : null;

        $connection = new Connection();
        $connection->createConnection();

        $getCurrentPasswordQuery = "SELECT * FROM `user` WHERE `id`=".$userId;
        $result = $connection->excuteQuery($getCurrentPasswordQuery);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (strcmp($row['password'], $password) == 0) {
                    $connection->excuteQuery("UPDATE `user` SET `password`='".$newPassword."' WHERE `id`=".$userId);
                    $connection->closeConnection();
                } else {
                    $connection->closeConnection();
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json; charset=UTF-8');
                }
                break;
            }
        } else {
            $connection->closeConnection();
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
        }
    }

?>