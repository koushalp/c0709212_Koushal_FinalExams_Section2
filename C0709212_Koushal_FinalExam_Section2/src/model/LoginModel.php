<?php

namespace model;

class LoginModel {
    private $sessionLocation = "LoggedIn";
    private $sessionUsername = "Username";

    public function __construct() {
        
    }

    
    public function doLogin($username, $password) {
        if($username == "admin" && $password == "admin@123")
        {
            $_SESSION[$this->sessionLocation] = true;
            $_SESSION[$this->sessionUsername] = $username;
            
        }
        else
        {
            throw new \Exception;
        }
    }

    public function doAutoLogin($username, $token) {

        if ($username == "admin" && $this->retriveToken($username) == $token)
        {
            
            $_SESSION[$this->sessionLocation] = true;
            $_SESSION[$this->sessionUsername] = $username;
        }
        else
        {
            throw new \Exception;
        }
    }

    
    public function doLogout() {
        $_SESSION[$this->sessionLocation] = null;
    }

    
    public function getLoginStatus() {
        if(!(isset($_SESSION[$this->sessionLocation])) || $_SESSION[$this->sessionLocation] === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    
    public function retriveUsername() {
        return $_SESSION[$this->sessionUsername];
    }

    
    public function retriveToken($username) {
        
            return "hai";
       
    }
}