<?php
/*
 * Copyright (C) 2017 Philipp Le
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once("model/user.php");

class Login
{
    function __construct()
    {
        
    }
    
    static function start()
    {
        session_name("AdminLogin");
        session_start();
    }
    
    static public function login($email, $plainPassword)
    {
        $user = \Model\User::findByEmail($email);
        
        if ($user === false)
        {
            return false;
        }
        
        if ($user->verifyPassword($plainPassword))
        {
            $_SESSION["login"] = array("email" => $email);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    static public function isLoggedIn()
    {
        return isset($_SESSION["login"]);
    }
    
    static public function logout()
    {
        unset($_SESSION["login"]);
        
        session_destroy();
    }
    
    static public function email()
    {
        if (isset($_SESSION["login"]))
        {
            return $_SESSION["login"]["email"];
        }
        else
        {
            return false;
        }
    }
}

