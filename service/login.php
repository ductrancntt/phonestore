<?php
  if(isset($_POST["username"])){
    header('Content-type: application/json; charset=utf-8');
    echo json_encode(["username" => $_POST["username"]]);
  }

?>