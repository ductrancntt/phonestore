<?php
    require "Connection.php";
    if (!isset($_SESSION))
        session_start();

    if (isset($_POST["username"]) &&  isset($_POST["password"])) {
        $connection = new Connection;
        $connection->createConnection();

        $username = $_POST["username"];
        $password = $_POST["password"];

        // $signInQuery = "SELECT * FROM user WHERE (username = '".$username."' OR email = '".$username."') AND password = '".$password."'";

        $signInQuery = "SELECT * FROM user WHERE username = '".$username."' AND password = '".$password."'";

        $result = $connection->excuteQuery($signInQuery);
    
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

            if ($_SESSION['isAdmin'])
                header("location:../admin.php");
            else {
                $_SESSION["userCart"] = array();
                header("location:../search-result.php");
            }


        } else {
            $connection->closeConnection();
            header("location:../signin.php?error=true");
        }
    }
?>


