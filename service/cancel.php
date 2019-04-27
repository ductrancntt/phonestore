<?php
    if(isset($_GET["id"])){
        require_once "./Connection.php";
        $connection = new Connection();
        $connection->createConnection();
        $sql = "UPDATE invoice SET status = 3 WHERE id = ".$_GET["id"];
        $connection->excuteQuery($sql);
        $connection->closeConnection();
        header("location:../invoices.php?huy=success");
    }
?>
