<?php
    class Connection {
    
        private $servername = 'localhost:3307';
        private $schema = "phone_store";
        private $username ="root";
        private $password = "";
        private $conn = null;

        function __construct() {
        }

        function __construct1($servername, $schema, $username, $password) {
            $this->servername = $servername;
            $this->schema = $schema;
            $this->username = $username;
            $this->password = $password;
        }

        public function createConnection() {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->schema);
            mysqli_set_charset($this->conn,"utf8");
        }

        public function closeConnection() {
            if ($this->conn) {
                $this->conn->close();
            }
        }

        public function excuteQuery($sql) {
            return $this->conn->query($sql);
        }

        public function getConnection() {
            return $this->conn;
        }

    }

?>