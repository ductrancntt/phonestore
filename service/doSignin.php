<?php
    require "Connection.php";

    session_start();

    if (isset($_POST["username"]) &&  isset($_POST["password"])) {
        $connection = new Connection;
        $connection->createConnection();

        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM user WHERE username = '".$username."' AND password = '".$password."'";

        $result = $connection->excuteQuery($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = array("id"=>$row["id"], "username" => $row["username"], "email" => $row["email"], "is_admin" => $row["is_admin"]);
                break;
            }
            $connection->closeConnection();
            header("location:../home.php");
        } else {
            header("location:../signin.php?error=true");
        }
    }
?>