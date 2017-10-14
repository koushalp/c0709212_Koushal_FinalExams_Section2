<?php

namespace view;

require_once("src/view/MessageView.php");

class LoginView {
    private $model;
    private $messages;

    public function __construct(\model\LoginModel $model)
    {
        $this->model = $model;
        $this->messages = new \view\MessageView();
    }

    public function onClickLogin() {
        if(isset($_POST["loginButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function onClickLogout() {
        if(isset($_GET['logout']))
        {
          return true;
        }
        else
        {
            return false;
        }
    }

    public function getTime() {
        setlocale(LC_ALL,"sv_SE.UTF8");
        return strftime(" you have been loged in ");
    }

    public function sessionCheck() {
        if ($_SESSION["httpAgent"] != $_SERVER["HTTP_USER_AGENT"])
        {
            return false;
        }

        return true;
    }

    public function showPage() {

        if($this->model->getLoginStatus() === false || $this->sessionCheck() === false)
        {
            $username = isset($_POST["username"]) ? $_POST["username"] : "";
            return "
            <h1>PHPLogin</h1>
            <h3>login first to proceed</h3>
            <form action='?login' method='post' name='loginForm'>
                <fieldset>
                    <legend>Login - please enter username and password </legend><p>"
                    . $this->messages->load() . "</p>
                    <label><strong>Username: </strong></label>
                    <input type='text' name='username' value='$username' />
                    <label><strong>Password: </strong></label>
                    <input type='password' name='password' value='' /><br><br>
                    <label><strong>want to remain logged in: </strong></label>
                    <input type='checkbox' name='stayLoggedIn' /><br><br>
                    <input type='submit' value='sign in' name='loginButton' />
                 </fieldset>
            </form>

            <p>" . $this->getTime() . "</p>";
        }
        else
        {
            return "<h1>hello!</h1>
                    <h3>" . $this->model->retriveUsername() . "  logged in</h3>
                    <p>" . $this->messages->load() . "</p>
                    <a href='?logout'>Log out</a>
                    <p>" . $this->getTime() . "</p>";
        }
    }
}