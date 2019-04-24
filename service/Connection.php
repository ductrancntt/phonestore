<?php
    class Connection {
    
        private $servername = 'localhost:3307';
        private $schema = "phone_store";
        private $username="root";
        private $password = "";
        private $conn = null;

        function __construct() {
        }

        function createConnection() {
            $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->schema);
        }

        function closeConnection() {
            if ($this->conn) {
                mysqli_close($this->conn);
            }
        }

        function excuteQuery($sql) {
            return $this->conn->query($sql);
        }

        function getConnection() {
            return $this->conn;
        }

    }

?>