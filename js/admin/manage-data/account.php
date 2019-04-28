<?php
header('Content-Type: application/json');
require_once "../../../service/Connection.php";

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $limit = $_GET["limit"];
    $search = $_GET["search"];
    $data = getAll($page, $limit, $search);
    echo json_encode($data);
}

if (isset($_POST["create"])) {
    $result = insert($_POST);
    echo json_encode($result);
}

if (isset($_POST["update"])) {
    $result = update($_POST);
    echo json_encode($result);
}

if (isset($_POST["toggle"])) {
    $result = toggleEnable($_POST["id"], $_POST["enable"]);
    echo json_encode($result);
}

function getAll($page, $limit, $search)
{
    $queryCount = "SELECT * FROM `user`";
    $offset = ($page - 1) * ($limit);
    $query = "SELECT * FROM `user` WHERE `username` LIKE '%$search%' LIMIT $limit OFFSET $offset ";
    $conn = new Connection();
    $conn->createConnection();

    $count = $conn->excuteQuery($queryCount);

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return;
    }

    $response = array();
    $response["data"] = array();
    $response["totalElements"] = $count->num_rows;
    while ($row = $result->fetch_assoc()) {
        array_push($response["data"], $row);
    }
    $conn->closeConnection();
    return $response;
}

function insert($user)
{
    $query = "INSERT INTO `user` (`username`, `password`, `name`, `email`, `phone`, `address`, `enable`, `is_admin`) VALUES (" .
        "'".$user['username'] . "'," .
        "'".$user['password'] . "'," .
        "'".$user['name'] . "'," .
        "'".$user['email'] . "'," .
        "'".$user['phone'] . "'," .
        "'".$user['address'] . "'," .
        "'".$user['enable'] . "'," .
        "'".$user['is_admin'] . "'" .
        ")";

    $conn = new Connection();
    $conn->createConnection();

    $check = findByUsername($user["username"]);
    if ($check != null) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Username has already exist");
    }

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Create user failed");
    }
    return array("error" => 0, "message" => "Create user successfully");
}

function findById($id)
{
    $connection = new Connection;
    $connection->createConnection();
    $query = "SELECT * FROM `user` WHERE `id` = $id";
    $result = $connection->excuteQuery($query);
    if ($result == false || $result->num_rows <= 0) {
        $connection->closeConnection();
        return null;
    }
    $row = $result->fetch_assoc();
    $connection->closeConnection();
    return $row;
}

function findByUsername($username)
{
    $connection = new Connection;
    $connection->createConnection();
    $query = "SELECT * FROM `user` WHERE `username` = '$username'";
    $result = $connection->excuteQuery($query);
    if ($result == false || $result->num_rows <= 0) {
        $connection->closeConnection();
        return null;
    }
    $row = $result->fetch_assoc();
    $connection->closeConnection();
    return $row;
}

function update($user)
{
    $old = findById($user["id"]);
    if ($old == null) return false;

    $query = "UPDATE `user` SET `username` = " . "'" . $user['username'] . "'".
        ",`password` = " ."'". $user['password'] ."'".
        ",`name` = " ."'". $user['name'] ."'".
        ",`email` = " ."'". $user['email'] ."'".
        ",`phone` = " ."'". $user['phone'] ."'".
        ",`address` = " ."'". $user['address'] ."'".
        ",`enable` = " ."'". $user['enable'] ."'".
        ",`is_admin` = " ."'". $user['is_admin'] ."'".
        " WHERE `id` = " . $user['id'];

    $conn = new Connection();
    $conn->createConnection();

    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Update user failed");
    }
    return array("error" => 0, "message" => "Update user successfully");
}

function toggleEnable($id, $status)
{
    $query = "UPDATE `user` SET `enable` = $status WHERE `id` = $id";

    $conn = new Connection();
    $conn->createConnection();
    $result = $conn->excuteQuery($query);
    if ($result == false) {
        $conn->closeConnection();
        return array("error" => 1, "message" => "Disabled user failed");
    }
    return array("error" => 0, "message" => "Disabled user successfully");
}
