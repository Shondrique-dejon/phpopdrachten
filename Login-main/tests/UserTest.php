<?php
// UserTest.php

session_start();

use PHPUnit\Framework\TestCase;
use Login\classes\User;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testSetAndGetPassword()
    {
        $this->user->SetPassword('password');
        $this->assertEquals('password', $this->user->GetPassword());
    }

    public function testSetAndGetRole()
    {
        $this->user->SetRole();
        $this->assertEquals('user', $this->user->GetRole());
    }

    public function testRegisterUser()
    {
        $this->user->username = 'test';
        $this->user->SetPassword('password');
        $this->user->email = 'test@example.com';
        $this->user->SetRole();

        $errors = $this->user->RegisterUser();
        
        $this->assertEmpty($errors);
    }

    public function testValidateRegistration()
    {
        $errors = $this->user->ValidateRegistration();
    
        $this->assertNotEmpty($errors);
    }
    
    public function testValidateLogin()
    {
        $errors = $this->user->ValidateLogin();
    
        $this->assertNotEmpty($errors);
    }    

    public function testLoginUser()
    {
        $this->user->username = 'test';
        $this->user->SetPassword('password');

        $this->assertTrue($this->user->LoginUser());
    }

    public function testIsNotLoggedIn()
    {
        unset($_SESSION['username']);

        $this->assertFalse($this->user->IsLoggedIn());
    }

    public function testIsLoggedIn()
    {
        $_SESSION['username'] = 'test';
        
        $this->assertTrue($this->user->IsLoggedIn());
    }

    public function testGetUser()
    {
        $this->assertTrue($this->user->GetUser('test'));
    }

    public function testLogout()
    {
        $_SESSION['username'] = 'test';

        $this->user->Logout();

        $this->assertFalse(isset($_SESSION['username']));
    }
}