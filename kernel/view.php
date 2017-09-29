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

include_once("view/layout/master.php");

function view($name, $variables, $request)
{
    include("view/".$name.".php");
    
    $viewClass = "\View\\".$name;
    
    
    $lang = "de";
    if (isset($request["lang"]))
    {
        $lang = $request["lang"];
    }
    
    return call_user_func($viewClass."::printView", $variables, $request, $lang);
}


?>

