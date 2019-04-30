<?php
header('Content-Type: application/json');
require "../../../service/Connection.php";

if (isset($_GET["getAll"])) {
    $result = getAll($_GET);
    echo json_encode($result);
}

if (isset($_POST["save"])) {
    $result = saveEntity(json_decode($_POST["entity"], true));
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
        $targetUrl = "../../../image/" . $milliseconds . "." . $ext;
        $image = "./image/" . $milliseconds . "." . $ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetUrl);
    }

    $entity["image"] = $image;

    if ($entity["id"] == null || $entity["id"] == "") {
        $result = insert($entity);
    } else {
        if ($image == "./image/no_image.png") {
            $manufacturer = findById($entity["id"]);
            if ($manufacturer != false) {
                $entity["image"] = $manufacturer["image"];
            }
        }
        $result = update($entity);
    }
    return $result;
}

function findById($id)
{
    $query = "SELECT * FROM `manufacturer` WHERE `id` = $id";
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
    $search = $params["search"];
    $offset = ($page - 1) * $limit;

    $queryAll = "SELECT * FROM `manufacturer` WHERE `deleted` = '0'";
    $queryCount = "SELECT * FROM `manufacturer` WHERE `name` LIKE '%$search%' AND `deleted` = '0'";
    $queryData = "SELECT * FROM `manufacturer` WHERE `name` LIKE '%$search%' AND `deleted` = '0' LIMIT $limit OFFSET $offset";

    $response = array();
    $response["totalElements"] = 0;
    $response["data"] = array();

    $conn = new Connection();
    $conn->createConnection();

    if ($limit == 0 || $limit == "0") {
        $all = $conn->excuteQuery($queryAll);
        if ($all == false) {
            $conn->closeConnection();
            return $response;
        }
        while ($row = $all->fetch_assoc()) {
            array_push($response["data"], $row);
        }
        $conn->closeConnection();
        return $response;
    }

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
    $query = "INSERT INTO `manufacturer` (`name`, `address`, `image`, `deleted`) VALUES (" .
        "'" . $entity['name'] . "'," .
        "'" . $entity['address'] . "'," .
        "'" . $entity['image'] . "'," .
        "'0'" .
        ")";

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();

    if ($result == false) return array("error" => 1, "message" => "Create manufacturer failed");
    return array("error" => 0, "message" => "Create manufacturer successfully");
}

function update($entity)
{
    $query = "UPDATE `manufacturer` SET `name` = " . "'" . $entity['name'] . "'" .
        ",`address` = " . "'" . $entity['address'] . "'" .
        ",`image` = " . "'" . $entity['image'] . "'" .
        " WHERE `id` = " . $entity['id'];

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);

    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Update manufacturer failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Update manufacturer successfully");
}

function delete($id)
{
    $query = "UPDATE `manufacturer` SET `deleted`='1' WHERE `id` = $id";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Delete manufacturer failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Delete manufacturer successfully");
}
