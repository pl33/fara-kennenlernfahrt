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

namespace View;

class Login
{
    static public function printView($variables, $request, $lang = "de")
    {
        $html = \Layout\Master::header(array("de"=>"Login", "en"=>"Login"), $request, array("Home" => "/admin"), $lang);
        
        if (isset($variables["error"]))
        {
            $html .= "<p class=\"error\">Login fehlgeschlagen!</p>";
        }
        
        $form = new \Layout\Form();
        
        $html .= <<<HTML
    <div class="form">
        {$form->open("/admin", $request)}
        <dl class="form_row">
            <dt class="form_label">E-Mail:</dt>
            <dd class="form_input">{$form->text('email')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">Passwort:</dt>
            <dd class="form_input">{$form->password('password')}</dd>
        </dl>
        <dl class="form_row">
            <dd class="form_input">{$form->submit("Login")}</dd>
        </dl>
        {$form->close()}
    </div>
HTML;

        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

?>

