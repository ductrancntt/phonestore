<?php
  $servername = "localhost";
  $databasename = "phone_store";
  $username="root";
  $password = "";
  $conn = null;
  if(isset($_POST["username"]) &&  isset($_POST["password"])){
    if(initConnection($servername, $username, $password, $databasename)){
      $user = login($_POST["username"], $_POST["password"]);
      closeConnection();
      header('Content-type: application/json; charset=utf-8');
      echo json_encode($user);
    }
  }
  
  function initConnection($servername, $username, $password, $databasename){
    global $conn;
    $conn = mysqli_connect($servername, $username, $password, $databasename);
    if(!$conn){
      die("connect fail");
      return false;
    }
    return true;
  }
  function closeConnection(){
    global $conn;
    if($conn){
      mysqli_close($conn);
    }
  }
  
  function login($username, $password){
    global $conn;
    $sql = "SELECT * FROM user WHERE username = '".$username."' AND password = '".$password."'";
    $result = $conn->query($sql); 
    $user = null;
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $user = array("id"=>$row["id"], "username" => $row["username"],
        "email" => $row["email"],"is_admin" => $row["is_admin"]);
        break;
      }
    }
    $result->close();
    return $user;
  }
?>