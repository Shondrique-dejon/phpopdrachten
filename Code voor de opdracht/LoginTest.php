<?php

use \PHPUnit\Framework\TestCase;
require_once __DIR__ . '/vendor/autoload.php';


use Login\classes\User;

class LoginTest extends Testcase{
    protected $user;

    protected function setUp(): void{
        $this->user = new User();
    }

    public function testSetAndGetPassword(){
        $password = "password123";
        $this->user->SetPassword($password);
        $this->assertEquals($password,$this->user->GetPassword());
    }
    public function testemptyPassword(){
        $this->user->username = "john";
        $this->user->SetPassword("");
        $errors = $this->user-> ValidateUser();
        $this->assertNotEmpty($errors);
        $this->assertContains("Invalid password", $errors);
    }
    public function testemptyUsername(){
        $this->user->username = "";
        $this->user->SetPassword("password");
        $errors = $this->user->ValidateUser();
        $this->assertNotEmpty($errors);
        $this->assertContains("Invalid username", $errors);

    }
    public function testshortUsername(){
        $this->user->username = "jobn";
        $errors = $this->user->ValidateUser();
        $this->assertContains("Length username must be > 3 and < 50.", $errors); 
    }
    
    public function testIslogin_set(){
        session_start();
        $_SESSION['user'] = "test";
        $this->assertTrue($this->user->Isloggedin());
    }
    public function testIslogin_noset(){
        $this->user->Logout();
        $this->assertFalse($this->user->Isloggedin());
    }
    
    public function testLogout(){
         session_start();
         $this->user->Logout();
         $isDeleted = (session_status() == PHP_SESSION_NONE || empty(session_id()));
         $this->assertTrue($isDeleted);
    }
}

?>