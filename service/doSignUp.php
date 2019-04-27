<?php
    require "Connection.php";

    $user = isset($_POST['user']) ? json_decode($_POST['user']) : null;

    if ($user != null) {
        $conn = new Connection;

        $signUpQuery = "INSERT INTO `user` (`username`, `password`, `email`, `name`, `address`, `phone`, `is_admin`, `enable`) 
        VALUES ('".$user->username."', '".$user->password."', '".$user->email."', '".$user->name."', '".$user->address."', '".$user->phone."', 0, 1)";

        $conn->createConnection();
        $result = $conn->excuteQuery($signUpQuery);
        
        echo $result;

        if ($result) {
            header('Content-Type: application/json');
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
        }
    }

?>