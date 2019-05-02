<?php
    require_once "Connection.php";
    
    function getProvice(){
        $conn = new Connection;
        $conn->createConnection();

        $query = "SELECT * FROM `devvn_tinhthanhpho` ";
        $province_array = array(); 
        $result = $conn->excuteQuery($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               array_push($province_array,$row);
            }
            $conn->closeConnection();
    
        } else {
            $conn->closeConnection();
        }
        return json_encode($province_array);
    }
    
    


?>