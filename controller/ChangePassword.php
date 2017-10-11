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

namespace Controller;

include_once("model/user.php");

class ChangePassword
{
    
    static public function index($request)
    {
        if (\Login::isLoggedIn())
        {
            return \View("ChangePassword", array(), $request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function change($request)
    {
        if (\Login::isLoggedIn())
        {
            if ($request["pw_new"] == $request["pw_repeat"])
            {
                $user = \Model\User::findByEmail(\Login::email());
                
                if ($user->verifyPassword($request["pw_old"]))
                {
                    $user->setPassword($request["pw_new"]);
                    $user->save();
                    
                    return \View("ChangePassword", array("success"=>true), $request);
                }
                else
                {
                    return \View("ChangePassword", array("error"=>true), $request);
                }
            }
            else
            {
                return \View("ChangePassword", array("error"=>true), $request);
            }
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
}

