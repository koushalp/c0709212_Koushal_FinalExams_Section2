<?php

namespace controller;

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/view/MessageView.php");
require_once("src/view/CookieStorageView.php");

class LoginController {
    private $model;
    private $view;
    private $messages;
    private $autoLogin;

    public function getPostedUsername() {
        return $_POST["username"];;
    }

    public function getPostedPassword() {
        return $_POST["password"];;
    }

    
    public function __construct() {
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
        $this->messages = new \view\MessageView();
        $this->autoLogin = new \view\CookieStorageView();
    }

    public function checkActions() {
        if($this->model->getLoginStatus() == false && isset($_COOKIE[$this->autoLogin->getCookieUsername()]) && isset($_COOKIE[$this->autoLogin->getCookieToken()]))
        {
            if ($this->autoLogin->autoLoginCreationDate($_COOKIE[$this->autoLogin->getCookieUsername()], $_COOKIE[$this->autoLogin->getCookieCreationDate()]) == true)
            {
                try
                {
                    
                    $this->model->doAutoLogin($_COOKIE[$this->autoLogin->getCookieUsername()], $_COOKIE[$this->autoLogin->getCookieToken()]);
                    $this->messages->save("Please login");
                    header('Location: index.php');
                    exit;
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Login");
                    $this->autoLogin->autoLoginCookieRemove();
                }
            }
            else
            {
                $this->messages->save("Login");
                $this->autoLogin->autoLoginCookieRemove();
            }
        }

        
        if($this->view->onClickLogin())
        {
            if ($this->getPostedUsername() == "")
            {
                $this->messages->save("Hi How are you");
            }
            elseif ($this->getPostedPassword() == "")
            {
                $this->messages->save("Final test submission");
            }
            else
            {
                try
                {
                   
                    $this->model->doLogin($this->getPostedUsername(), $this->getPostedPassword());

                    
                    if(isset($_POST["stayLoggedIn"]))
                    {
                        $this->autoLogin->autoLoginCookie($this->getPostedUsername(), $this->model->retriveToken($this->getPostedUsername()));
                        $this->messages->save("You are logged in");
                        header('Location: index.php');
                        exit;
                    }

                    $this->messages->save("Logged in");
                    header('Location: index.php');
                    exit;
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Click to log out");
                }
            }
        }
        
        elseif ($this->view->onClickLogout())
        {
            $this->autoLogin->autoLoginCookieRemove();
            $this->model->doLogout();
            $this->messages->save("signup for full version");
            header('Location: index.php');
            exit;
        }

        return $this->view->showPage();
    }
}