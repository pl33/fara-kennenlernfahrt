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

namespace Route;

include_once("routes.php");

class Route
{
    static public function call()
    {
        /* Get method */
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        
        /* Get request */
        $request = array();
        if ($method == "get")
        {
            $request = $_GET;
        }
        else if ($method == "post")
        {
            $request = $_POST;
        }
        
        /* Get path */
        $path = "/";
        if (isset($request["p"]))
        {
            $path = $request["p"];
        }
        
        /* Get routes */
        $routes = \getRoutes();
        
        /* Get controller */
        if (isset($routes[$method][$path]))
        {
            $controller = $routes[$method][$path];
            $function = "\Controller\\".$controller["Controller"]."::".$controller["Function"];

            /* Import controller */
            include_once("controller/".$controller["Controller"].".php");

            /* Call controller */
            return call_user_func($function, $request);
        }
        else
        {
            return "404";
        }
    }
}

?>

