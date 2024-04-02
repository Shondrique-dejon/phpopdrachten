<?php

namespace Login\classes;
use PDO;
class User {
    // Eigenschappen 
    public $username;
    public $email;
    private $password;
    private $role = "user";
    private $db;

    function SetPassword($password) {
        $this->password = $password;
    }

    function GetPassword() {
        return $this->password;
    }

    public function ShowUser() {
        echo "<br>Username: $this->username<br>";
        echo "<br>Password: $this->password<br>";
        echo "<br>Email: $this->email<br>";
        echo "<br>Role:$this->role<br>";
    }

    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=inlog_new", "root", "");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function RegisterUser() {
        $status = false;
        $errors = [];
        if($this->username !="" && $this->password !=""){
    
        if ($this->GetUser($this->username)) {
            array_push($errors, "Username bestaat al.");
            
        }else{
        
        // 执行注册操作
        $this->Insert('user', [
            'username' => $this->username,
            'password' => $this->password,
            'email' => '',
            'role' => $this->role
        ]);
           $status= true;
    }
    }
    
        return $errors;
    }
    
    
    
    

    function ValidateUser() {
        $errors = [];
        if (empty($this->username)) {
            array_push($errors, "Invalid username");
        } else if (empty($this->password)) {
            array_push($errors, "Invalid password");
        } else {
            $len_username = strlen($this->username);
            if ($len_username < 3 || $len_username > 50) {
                array_push($errors, "Length username must be > 3 and < 50.");
            }
        }
        return $errors;
    }

    public function LoginUser() {
        $status = false;
        // Zoek user in de table user
        if ($this->username != '') {
            $query = $this->db->prepare("SELECT * FROM user WHERE username = :username");
            $query->execute([':username' => $this->username]);
            $row = $query->fetch();
            if ($query->rowCount() > 0 && $row['password'] == $this->password) {
                session_start();
                $_SESSION['user'] = $this->username;
                $status = true;
            }
        }
        return $status;
    }

    public function IsLoggedin() {
        // Check if user session has been set
        if (isset($_SESSION['user'])) {
            $this->username = $_SESSION['user'];
            return true;
        }
        return false;
    }

    public function GetUser($username) {
        $query = $this->db->prepare("SELECT * FROM user WHERE username = :username");
        $query->execute([':username' => $this->username]);
        if ($query->rowCount() == 1) {
            $row = $query->fetch();
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role = $row['role'];
            return true;
        } else {
            return false;
        }
    }

    public function Logout() {
        session_start();
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
        header('location: index.php');
    }
    public function Insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));
        $placeholders = ':' . $values;

        $query = $this->db->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        $query->execute();
    }
}
?>
