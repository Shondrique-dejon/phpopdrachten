<?php
    // Functie: classdefinitie User 
    // Auteur: Wigmans
    require_once 'classes/Database.php';

    class User{

        // Eigenschappen 
        public $username;
        public $email;
        private $password;
        public $role;
        private static $db;
        
        public function __construct() {
            self::$db = new Database("localhost", "login", "root", "");
        }

        function SetPassword($password){
            $this->password = $password;
        }
        function GetPassword(){
            return $this->password;
        }

        public function ShowUser() {
            echo "<br>Username: $this->username<br>";
            echo "<br>Password: $this->password<br>";
            echo "<br>Email: $this->email<br>";
        }

        public function RegisterUser(){
            $status = false;
            $errors=[];
            if($this->username != "" || $this->password != ""){

                // Check user exist
                $query = "SELECT username FROM users WHERE username = ?;";
                $params = array($this->username);

                $result = self::$db->executeQuery($query, $params);

                if($result->rowCount() != 0){
                    array_push($errors, "Username bestaat al.");
                } else {
                    $query = "INSERT INTO `users` (`username`, `password`, `role`) VALUES (?, ?, ?);";
                    $params = array($this->username, password_hash($this->password, PASSWORD_DEFAULT), "");

                    $result = self::$db->executeQuery($query, $params);
                    
                    $status = true;
                }
                            
                
            }
            return $errors;
        }

        function ValidateUser() {
            $errors = $this->ValidateUsername();

            if (empty($errors)) {
                $query = "SELECT password FROM users WHERE username = ?;";
                $params = array($this->username);

                $result = self::$db->executeQuery($query, $params);

                if ($result->rowCount() == 0) {
                    array_push($errors, "Invalid username");
                }
                else if (!password_verify($this->password, $result->fetch(PDO::FETCH_ASSOC)["password"]))
                {
                    array_push($errors, "Invalid password");
                }
            }
            
            return $errors;
        }

        function ValidateUsername() {
            $errors=[];
            
            if (strlen($this->username) < 3) {
                array_push($errors, "Username too short");
            } else if (strlen($this->username) > 50) {
                array_push($errors, "Username too long");
            }

            return $errors;
        }

        public function LoginUser()
        {
            // Check user exist
            $query = "SELECT username FROM users WHERE username = ?;";
            $params = array($this->username);

            $result = self::$db->executeQuery($query, $params);
            if($result->rowCount() != 0) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    // Start the session
                    session_start();
                }
                $_SESSION['username'] = $this->username;
                return true;
            }
            return false;
        }

        // Check if the user is already logged in
        public function IsLoggedin() {
            // Check if user session has been set
            if (session_status() !== PHP_SESSION_ACTIVE) {
                // Start the session
                session_start();
            }
            return isset($_SESSION['username']);
        }

        public function GetUser($username) {
            
		    // Check user exist
            $query = "SELECT username FROM users WHERE username = ?;";
            $params = array($_SESSION['username']);

            $result = self::$db->executeQuery($query, $params);
            if($result->rowCount() != 0) {
                //Indien gevonden eigenschappen vullen met waarden uit de SELECT
                $this->username = $result->fetch(PDO::FETCH_ASSOC)["username"];
            } else {
                Logout();
            }   
        }

        public function Logout() {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                // Start the session
                session_start();
            }
            
            session_unset();
            session_destroy();

            header('location: index.php');
        }


    }

    

?>