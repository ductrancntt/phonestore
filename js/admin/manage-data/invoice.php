<?php
header('Content-Type: application/json');
require "../../../service/Connection.php";

if (isset($_GET["getAll"])) {
    $result = getAll($_GET);
    echo json_encode($result);
}

if (isset($_POST["save"])) {
    $result = saveEntity($_POST);
    echo json_encode($result);
}

function saveEntity($entity)
{
    $query = "UPDATE `invoice` SET `status` = " . "'" . $entity['status'] . "'" .
        " WHERE `id` = " . $entity['id'];

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);

    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Update invoice failed");
    }
    $conn->closeConnection();
    return array("error" => 0, "message" => "Update invoice successfully");
}

function getAll($params)
{
    $page = $params["page"];
    $limit = $params["limit"];
    $search = $params["search"];
    $startDate = $params["startDate"];
    $endDate = $params["endDate"];
    $offset = ($page - 1) * $limit;

    $queryUser = "SELECT * FROM `user`";

    $queryCount = "SELECT * FROM `invoice` WHERE `id` LIKE '%$search%' AND `created_date` BETWEEN $startDate AND $endDate";
    $queryData = "SELECT * FROM `invoice` WHERE `id` LIKE '%$search%' AND `created_date` BETWEEN $startDate AND $endDate LIMIT $limit OFFSET $offset";

    if ($startDate == "" || $endDate == "" || $startDate > $endDate){
        $queryCount = "SELECT * FROM `invoice` WHERE `id` LIKE '%$search%'";
        $queryData = "SELECT * FROM `invoice` WHERE `id` LIKE '%$search%' LIMIT $limit OFFSET $offset";
    }

    $response = array();
    $response["totalElements"] = 0;
    $response["data"] = array();
    $response["users"] = array();

    $conn = new Connection();
    $conn->createConnection();

    $users = $conn->excuteQuery($queryUser);
    while ($row = $users->fetch_assoc()) {
        array_push($response["users"], $row);
    }

    $count = $conn->excuteQuery($queryCount);
    $data = $conn->excuteQuery($queryData);

    if ($data == false || $count == false) {
        $conn->closeConnection();
        return $response;
    }

    $response["totalElements"] = $count->num_rows;
    while ($row = $data->fetch_assoc()) {
        $row["created_date"] = DateTime::createFromFormat('YmdHis', $row["created_date"])->format('d/m/Y H:i:s');
        array_push($response["data"], $row);
    }
    $conn->closeConnection();
    return $response;
}

