<?php
// User.php
// Authors: Rob Wigmans & Shondrique de Jong

namespace Login\classes;
use Login\classes\Connection;

class User
{
    public $username;
    private $password;
    public $email;
    private $role;


    public function SetPassword($password)
    {
        $this->password = $password;
    }

    public function GetPassword()
    {
        return $this->password;
    }

    public function SetRole()
    {
        $allowedAdminUsernames = ['Shoni'];

        if (in_array($this->username, $allowedAdminUsernames)) 
        {
            $this->role = 'admin';
        } 
        else 
        {
            $this->role = 'user';
        }
    }

    public function GetRole()
    {
        return $this->role;
    }

    public function ShowUser() 
    {
        echo "<br>Username: " . $this->username . "<br>";
        echo "<br>Password: " . $this->getPassword() . "<br>";
        echo "<br>Email: " . $this->email . "<br>";
        echo "<br>Role: " . $this->getRole() . "<br>";
    }

    public function RegisterUser()
    {
        $errors = [];
            
        try 
        {
            $connection = new Connection();
            $pdo = $connection->getPdo();

            $query = "SELECT COUNT(*) FROM `user` WHERE `username` = :username OR 
                     `email` = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':username', $this->username);
            $stmt->bindValue(':email', $this->email);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) 
            {
                array_push($errors, "Username or email already exists");
            } 
            else
            {
                $query = "INSERT INTO `user` (`username`, `password`, `email`, `role`) 
                          VALUES (:username, :password, :email, :role)";
                    
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':username', $this->username);
                $stmt->bindValue(':password', $this->password);
                $stmt->bindValue(':email', $this->email);  
                $stmt->bindValue(':role', $this->role); 
                $stmt->execute();    
            }
        } 
        catch (\PDOException $e) 
        {
            error_log("Error inserting user: " . $e->getMessage());
            array_push($errors, "Error occurred.");              
        }
        return $errors;
    }

    public function ValidateRegistration()
    {
        $errors = [];
        
        if (empty($this->username) || empty($this->password) || empty($this->email)) {
            array_push($errors, "Username, password, or email cannot be empty.");
        }
        else if (strlen($this->username) < 3 || strlen($this->username) > 20) {
            array_push($errors, "Username must be between 3 and 20 characters");
        }
        return $errors;
    }
        
    public function ValidateLogin()
    {
        $errors = [];
        
        if (empty($this->username) || empty($this->password)) 
        {
            array_push($errors, "Username or password cannot be empty.");
        }
        else if (strlen($this->username) < 3 || strlen($this->username) > 20) 
        {
            array_push($errors, "Username must be between 3 and 20 characters");
        }
        return $errors;
    }

    public function LoginUser()
    {
        try 
        {
            $connection = new Connection();
            $pdo = $connection->getPdo();

            $query = "SELECT * FROM user WHERE username = :username";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':username', $this->username);
            $stmt->execute();
        
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                
            if ($user) 
            {
                if ($this->password === $user['password']) 
                {
                    $_SESSION['username'] = $user['username'];       
                    return true;
                } 
                else 
                {
                    return false;
                }
            }
            else
            {
                return false;
            } 
        }
        catch (\PDOException $e) 
        {
            error_log("Error inserting user: " . $e->getMessage());
            return false;
        }
    }

    public function IsLoggedin() 
    {
        if (isset($_SESSION['username']))
        {
            return true;
        } 
        else
        {
            return false;
        }
    }

    public function GetUser($username)
    {
        try 
        {
            $connection = new Connection();
            $pdo = $connection->getPdo();

            $query = "SELECT * FROM user WHERE username = :username";
        
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':username', $username);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0)
            {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
                $this->username = $user['username'];
                $this->email = $user['email'];
                $this->password = $user['password'];
                $this->role = $user['role'];
        
                return true;
            } 
            else
            {
            return false;
            }
        }
        catch (\PDOException $e)
        {
            error_log("Error inserting user: " . $e->getMessage());
            return false;
        }
    } 

    public function Logout()
    {
        session_unset();
            
        session_destroy();
    }
}