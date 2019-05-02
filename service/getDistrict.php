<?php
    require_once "Connection.php";
    
    
    if(isset($_GET["id"])){
    
        $conn = new Connection;
        $conn->createConnection();

        $query = "SELECT * FROM `devvn_quanhuyen` WHERE `matp` = ".$_GET["id"];
        
        $district_array = array(); 
        $result = $conn->excuteQuery($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               array_push($district_array,$row);
            }
            $conn->closeConnection();
    
        } else {
            $conn->closeConnection();
        }
        echo json_encode($district_array);
    }


?>