<?php
header('Content-Type: application/json');
require "../../../service/Connection.php";

if (isset($_GET["getAll"])){
    $data = getAll();
    echo json_encode($data);
}

if (isset($_POST["deleteId"])){
    delete($_POST["deleteId"]);
    $data = getAll();
    echo json_encode($data);
}

if (isset($_POST["name"])) {
    saveEntity();
}

function saveEntity(){
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $image = "";

    if ($name == "") return;


    if (isset($_FILES["image"])) {
        if ($_FILES["image"]["error"] == 1){
            echo json_encode(array('error' => 'Image size is too large!' ));
            return;
        }
        if ($_FILES["image"]["error"] != 0){
            echo json_encode(array('error' => 'Error upload image!' ));
            return;
        }
        $path = $_FILES["image"]["name"];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $milliseconds = (int)round(microtime(true) * 1000);
        $targetUrl = "../../../image/" . $milliseconds . "." . $ext;
        $image = "/image/" . $milliseconds . "." . $ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetUrl);
    }


    if ($id == "null"){
        if ($image == "") $image = "/image/no_image.png";
        insert($name, $address, $image);
    } else {
        if ($image == ""){
            $object = findById($id);
            $image = $object["image"];
        }
        update($id, $name, $address, $image);
    }
    echo json_encode(array('message' => 'Save successfully' ));
}

if (isset($_REQUEST["search"])){
    $data = searchByKeyword($_REQUEST["search"]);
    echo json_encode($data);
}

function findById($id)
{
    $connection = new Connection;
    $connection->createConnection();

    $query = "SELECT * FROM `manufacturer` WHERE `id` = $id";
    $result = $connection->excuteQuery($query);
    if ($result == false || $result->num_rows <= 0) {
        $connection->closeConnection();
        return null;
    }

    $row = $result->fetch_assoc();
    $connection->closeConnection();
    return $row;
}

function searchByKeyword($keyword){
    $query = "SELECT * FROM `manufacturer` WHERE `name` LIKE '%$keyword%'";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();
    $response = array();
    while($row = $result->fetch_assoc()){
        array_push($response, $row);
    }
    return $response;
}

function getAll(){
    $query = "SELECT * FROM `manufacturer`";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();
    $response = array();
    while($row = $result->fetch_assoc()){
        array_push($response, $row);
    }
    return $response;
}

function insert($name, $address, $image)
{
    $query = "INSERT INTO `manufacturer` (`name`, `address`, `image`) 
        VALUES ('".$name."', '".$address."', '".$image."')";

    $conn = new Connection;
    $conn->createConnection();
    $conn->excuteQuery($query);
    $conn->closeConnection();
}

function update($id, $name, $address, $image){
    $query = "UPDATE `manufacturer` SET `name` = '$name', `address` = '$address', `image` = '$image' WHERE `id` = $id";
    $conn = new Connection;
    $conn->createConnection();
    $conn->excuteQuery($query);
    $conn->closeConnection();
}

function delete($id){
    $query = "DELETE FROM `manufacturer` WHERE `id` = '$id'";
    $conn = new Connection;
    $conn->createConnection();
    $conn->excuteQuery($query);
    $conn->closeConnection();
}
