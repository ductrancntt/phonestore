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

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getUsername(){
            return $this->username;
        }
    
        public function setUsername($username){
            $this->username = $username;
        }
    
        public function getPassword(){
            return $this->password;
        }
    
        public function setPassword($password){
            $this->password = $password;
        }
    
        public function getEmail(){
            return $this->email;
        }
    
        public function setEmail($email){
            $this->email = $email;
        }
    
        public function getName(){
            return $this->name;
        }
    
        public function setName($name){
            $this->name = $name;
        }
    
        public function getAddress(){
            return $this->address;
        }
    
        public function setAddress($address){
            $this->address = $address;
        }
    
        public function getPhone(){
            return $this->phone;
        }
    
        public function setPhone($phone){
            $this->phone = $phone;
        }
    
        public function getIsAdmin(){
            return $this->isAdmin;
        }
    
        public function setIsAdmin($isAdmin){
            $this->isAdmin = $isAdmin;
        }
    
        public function getIsEnable(){
            return $this->isEnable;
        }
    
        public function setIsEnable($isEnable){
            $this->isEnable = $isEnable;
        }
    }

?>