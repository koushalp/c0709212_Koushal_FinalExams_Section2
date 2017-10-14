<?php

namespace view;

class CookieStorageView {
    private $cookieUsername = "username";
    private $cookieToken = "token";
    private $cookieCreationDate = "creationDate";
    private $cookieDatesFile = "CookieDates.txt";

    public function getCookieUsername() {
        return $this->cookieUsername;
    }

    public function getCookieToken() {
        return $this->cookieToken;
    }

    public function getCookieCreationDate() {
        return $this->cookieCreationDate;
    }

    
    public function autoLoginCookie($username, $token) {
        $time = time()+60*60*24*30;

        setcookie('username', $username, $time);
        setcookie('token', $token, $time);
        setcookie('creationDate', $time, $time);

        $fp = fopen($this->cookieDatesFile, 'a');
        fwrite($fp, $username . $time . PHP_EOL);
    }

    
    public function autoLoginCookieRemove()
    {
        setcookie("username", "", time()-3600);
        setcookie("token", "", time()-3600);
        setcookie("creationDate", "", time()-3600);
    }

    
    public function autoLoginCreationDate($username, $usersCookieCreationDate) {
        $cookieDates = @file($this->cookieDatesFile);
        if ($cookieDates === FALSE) {
            return false;
        }

        foreach ($cookieDates as $creationDate) {
            $creationDate = trim($creationDate);
            if ($creationDate === $username . $usersCookieCreationDate) {
                return true;
            }
        }
        return false;
    }
}