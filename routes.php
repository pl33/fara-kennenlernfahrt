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

function getRoutes()
{
    $routes = array(
        "get" => array(
            "/" => array("Controller" => "Signup", "Function" => "index"),
            "/signup" => array("Controller" => "Signup", "Function" => "index"),
            "/dosignup" => array("Controller" => "Signup", "Function" => "index"),
            "/admin" => array("Controller" => "AdminOverview", "Function" => "index"),
            "/logout" => array("Controller" => "AdminOverview", "Function" => "logout")
        ),
        "post" => array(
            //"/signup" => array("Controller" => "Signup", "Function" => "check"),
            "/" => array("Controller" => "Signup", "Function" => "signup"),
            "/dosignup" => array("Controller" => "Signup", "Function" => "signup"),
            "/admin" => array("Controller" => "AdminOverview", "Function" => "login")
        )
    );
    
    return $routes;
}

?>

