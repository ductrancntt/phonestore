<?php
    class User {

        private $id;
        private $username;
        private $password;
        private $email;
        private $name;
        private $address;
        private $phone;
        private $isAdmin;
        private $isEnable;

        function __construct() {
        }

        function __construct1($username, $password, $email, $name, $address, $phone, $isAdmin, $isEnable) {
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->name = $name;
            $this->address = $address;
            $this->phone = $phone;
            $this->isAdmin = $isAdmin;
            $this->isEnable = $isEnable;
        }

        function __destruct() {

        }

        
    }

?>