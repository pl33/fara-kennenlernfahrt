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

namespace Layout;

class Master
{
    static public function header($subtitle, $request, $menu=array(), $lang = "de", $style="narrow")
    {
        $title = array("de" => "Kennenlernfahrt", "en" => "Freshmen tour");
        
        $args = array();
        foreach ($request as $key => $value)
        {
            if ($key != "lang")
            {
                array_push($args, $key."=".$value);
            }
        }
        $args = implode("&", $args);
        
        $navigation = "<ul>";
        foreach ($menu as $text => $route)
        {
            $navigation .= "<li><a href=\"?p=".$route."\">".$text."</a></li>";
        }
        $navigation .= "</ul>";
        
        return <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$title[$lang]} {$subtitle[$lang]}</title>
        <link rel="stylesheet" type="text/css" href="view/layout/master.css" />
    </head>
    <body>
        <header>
            <h1>{$title[$lang]}</h1>
            <h2>{$subtitle[$lang]}</h2>
            <p class="lang"><a href="?lang=de&{$args}">Deutsch</a> | <a href="?lang=en&{$args}">English</a></p>
            <div class="menu">{$navigation}</div>
        </header>
        <div class="content_{$style}">
HTML;
    }
    
    static public function footer($request, $lang = "de")
    {
        $impress = \config()["Impress"];
        
        return <<<HTML
        </div>
        <footer>
            <p class="references"><a href="{$impress}" target="_new">Impressum</a> | <a href="?p=/admin">Admin</a></p>
        </footer>
    </body>
</html>
HTML;
    }
}

class Form
{
    static public function open($path, $request)
    {
        $html = <<<HTML
            <form method="POST" action="">
            <input type="hidden" name="p" value="{$path}">
HTML;
        if (isset($request['lang']))
        {
            $html .= Form::hidden('lang', $request['lang']);
        }
        else
        {
            $html .= Form::hidden('lang', "de");
        }
        
        return $html;
    }
    
    static public function hidden($name, $value)
    {
        return <<<HTML
            <input type="hidden" name="{$name}" value="{$value}" />
HTML;
    }
    
    static public function label($name, $title)
    {
        return <<<HTML
            <label for="{$name}">{$title}</label>
HTML;
    }
    
    static public function text($name)
    {
        return <<<HTML
            <input type="text" name="{$name}" />
HTML;
    }
    
    static public function password($name)
    {
        return <<<HTML
            <input type="password" name="{$name}" />
HTML;
    }
    
    static public function submit($title)
    {
        return <<<HTML
            <input type="submit" value="{$title}" />
HTML;
    }
    
    static public function radio($name, $value, $title)
    {
        return <<<HTML
            <input type="radio" name="{$name}" value="{$value}">{$title}</input>
HTML;
    }
    
    static public function textarea($name)
    {
        return <<<HTML
            <textarea name="{$name}"></textarea>
HTML;
    }
    
    static public function close()
    {
        return "</form>";
    }
}

?>

