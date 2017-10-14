<?php

namespace view;

class MessageView {
    private $message = "Final Test";

    
    public function save($string) {
        $_SESSION[$this->message] = $string;
    }
	
    public function load() {
        if(isset($_SESSION[$this->message]))
        {
            $ret = $_SESSION[$this->message];

        }
        else
        {
            $ret = "";
        }

        $_SESSION[$this->message] = "";

        return $ret;
    }
}