<?php
    require "Connection.php";

    if (!isset($_SESSION))
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
                if ($row["enable"] == false) {
                    $connection->closeConnection();
                    header("location:../signin.php?error=true");
                }

                $_SESSION['signedIn'] = true;
                $_SESSION['username'] = $row["username"];
                $_SESSION['isAdmin'] = $row["is_admin"];
                
                break;
            }
            $connection->closeConnection();
            header("location:../home.php");
        } else {
            $connection->closeConnection();
            header("location:../signin.php?error=true");
        }
    }
?>