<?php
header('Content-Type: application/json');
require "../../../service/Connection.php";

if (isset($_GET["getAll"])) {
    $result = getAll($_GET);
    echo json_encode($result);
}

if (isset($_POST["save"])) {
    $result = saveEntity(json_decode($_POST["product"], true));
    echo json_encode($result);
}

if (isset($_POST["delete"])) {
    $result = delete($_POST["id"]);
    echo json_encode($result);
}

function getAll($params)
{
    $page = $params["page"];
    $limit = $params["limit"];
    $search = $params["search"];
    $offset = ($page - 1) * $limit;

    $queryCount = "SELECT * FROM `product` WHERE `name` LIKE '%$search%' AND `deleted` = '0'";
    $queryData = "SELECT * FROM `product` WHERE `name` LIKE '%$search%' AND `deleted` = '0' LIMIT $limit OFFSET $offset";

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
        $targetUrl = "../../../images/image_" . $milliseconds . "." . $ext;
        $image = "./images/image_" . $milliseconds . "." . $ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetUrl);
    }

    $entity["image"] = $image;

    if ($entity["id"] == null || $entity["id"] == "") {
        $result = insert($entity);
    } else {
        if ($image == "./image/no_image.png"){
            $product = findById($entity["id"]);
            if ($product != false){
                $entity["image"] = $product["image"];
            }
        }
        $result = update($entity);
    }
    return $result;
}

function findById($id){
    $query = "SELECT * FROM `product` WHERE `id` = $id";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();
    return $result->fetch_assoc();
}

function insert($entity)
{
    $query = "INSERT INTO `product` (`name`, `price`, `description`, `screen_size`, `memory`, `chipset`, `image`, `manufacturer_id`, `quantity`, `deleted`) VALUES (" .
        "'" . $entity['name'] . "'," .
        "'" . $entity['price'] . "'," .
        "'" . $entity['description'] . "'," .
        "'" . $entity['screen_size'] . "'," .
        "'" . $entity['memory'] . "'," .
        "'" . $entity['chipset'] . "'," .
        "'" . $entity['image'] . "'," .
        "'" . $entity['manufacturer_id'] . "'," .
        "'" . $entity['quantity'] . "'," .
        "'0'" .
        ")";

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    $conn->closeConnection();

    if ($result == false) return array("error" => 1, "message" => "Create product failed");
    return array("error" => 0, "message" => "Create product successfully");
}

function update($entity)
{
    $query = "UPDATE `product` SET `name` = " . "'" . $entity['name'] . "'" .
        ",`price` = " . "'" . $entity['price'] . "'" .
        ",`description` = " . "'" . $entity['description'] . "'" .
        ",`screen_size` = " . "'" . $entity['screen_size'] . "'" .
        ",`memory` = " . "'" . $entity['memory'] . "'" .
        ",`chipset` = " . "'" . $entity['chipset'] . "'" .
        ",`image` = " . "'" . $entity['image'] . "'" .
        ",`manufacturer_id` = " . "'" . $entity['manufacturer_id'] . "'" .
        ",`quantity` = " . "'" . $entity['quantity'] . "'" .
        " WHERE `id` = " . $entity['id'];

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);

    if ($result == false){
        $conn->closeConnection();
        return array("error" => 1, "message" => "Update product failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Update product successfully");
}

function delete($id)
{
    $query = "UPDATE `product` SET `deleted` = '1' WHERE `id` = $id";
    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Delete product failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Delete product successfully");
}

