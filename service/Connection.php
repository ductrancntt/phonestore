<?php
    class Connection {
    
        private $servername = 'localhost:3306';
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
            $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->schema);
        }

        public function closeConnection() {
            if ($this->conn) {
                mysqli_close($this->conn);
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