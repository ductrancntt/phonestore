<?php
header('Content-Type: application/json');
require "../../../service/Connection.php";

if (isset($_GET["getAll"])) {
    $result = getAll($_GET);
    echo json_encode($result);
}

if (isset($_GET["getTime"])) {
    $result = getBannerTime();
    echo json_encode($result);
}

if (isset($_POST["save"])) {
    $result = saveEntity(json_decode($_POST["entity"], true));
    echo json_encode($result);
}

if (isset($_POST["changeTime"])) {
    $result = changeTime($_POST["time"]);
    echo json_encode($result);
}

if (isset($_POST["delete"])) {
    $result = delete($_POST["id"]);
    echo json_encode($result);
}

function saveEntity($entity)
{
    $image = "./image/no_image.png";

    if (isset($_FILES["image"])) {
        if ($_FILES["image"]["error"] == 1) {
            return array("error" => 1, "message" => "Image size is too large");
        }
        if ($_FILES["image"]["error"] != 0) {
            return array("error" => 1, "message" => "Error upload image");
        }
        $path = $_FILES["image"]["name"];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $milliseconds = (int)round(microtime(true) * 1000);
        $targetUrl = "../../../image/banner_" . $milliseconds . "." . $ext;
        $image = "./image/banner_" . $milliseconds . "." . $ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetUrl);
    }

    $entity["image"] = $image;

    if ($entity["id"] == null || $entity["id"] == "") {
        $result = insert($entity);
    } else {
        if ($image == "./image/no_image.png") {
            $banner = findById($entity["id"]);
            if ($banner != false) {
                $entity["image"] = $banner["image"];
            }
        }
        $result = update($entity);
    }
    return $result;
}

function findById($id)
{
    $query = "SELECT * FROM `banner` WHERE `id` = $id";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();
    return $result->fetch_assoc();
}

function getAll($params)
{
    $page = $params["page"];
    $limit = $params["limit"];
    $offset = ($page - 1) * $limit;

    $queryCount = "SELECT * FROM `banner`";
    $queryData = "SELECT * FROM `banner` LIMIT $limit OFFSET $offset";

    $response = array();
    $response["totalElements"] = 0;
    $response["data"] = array();

    $conn = new Connection();
    $conn->createConnection();

    $count = $conn->excuteQuery($queryCount);
    $data = $conn->excuteQuery($queryData);

    if ($data == false || $count == false) {
        $conn->closeConnection();
        return $response;
    }

    $response["totalElements"] = $count->num_rows;
    while ($row = $data->fetch_assoc()) {
        array_push($response["data"], $row);
    }
    $conn->closeConnection();
    return $response;
}

function insert($entity)
{
    $query = "INSERT INTO `banner` (`image`, `enable`, `link`) VALUES (" .
        "'" . $entity['image'] . "'," .
        "'" . $entity['enable'] . "'," .
        "'#'" .
        ")";

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();

    if ($result == false) return array("error" => 1, "message" => "Create banner failed");
    return array("error" => 0, "message" => "Create banner successfully");
}

function update($entity)
{
    $query = "UPDATE `banner` SET `image` = " . "'" . $entity['image'] . "'" .
        ",`enable` = " . "'" . $entity['enable'] . "'" .
        " WHERE `id` = " . $entity['id'];

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);

    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Update banner failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Update banner successfully");
}

function delete($id)
{
    $query = "DELETE FROM `banner` WHERE `id` = $id";
    $conn = new Connection();
    $conn->createConnection();

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Delete banner failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Delete banner successfully");
}

function changeTime($time){
    $query = "UPDATE `setting` SET `value` = $time WHERE `id` = 1";
    $conn = new Connection();
    $conn->createConnection();

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Set time failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Set time successfully");
}



function getBannerTime(){
    $query = "SELECT * FROM `setting`";
    $conn = new Connection();
    $conn->createConnection();

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Set time failed");
    }
    $data = $result->fetch_assoc();
    $conn->closeConnection();
    return array("error" => 0, "data" => $data);
}