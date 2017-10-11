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

class ChangePassword
{
    static public function printView($variables, $request, $lang = "de")
    {
        /* Force German */
        $lang = "de";
        
        $menu = array("Home" => "/admin", "Passwort &auml;ndern" => "/changepw", "Logout" => "/logout");
        foreach (\config()["FaRas"] as $fara)
        {
            $menu[$fara] = "/admin&faculty=".$fara;
        }
        
        $html = \Layout\Master::header(array("de"=>"Passwort &auml;ndern", "en"=>"Passwort &auml;ndern"), $request, $menu, $lang, "narrow");
                
        if (isset($variables["error"]))
        {
            $html .= "<p class=\"error\">Fehlgeschlagen!</p>";
        }     
        
        if (isset($variables["success"]))
        {
            $html .= "<p class=\"success\">Passwort erfolgreich ge&auml;ndert!</p>";
        }
        
        $form = new \Layout\Form();
        
        $html .= <<<HTML
    <div class="form">
        {$form->open("/changepw", $request)}
        <dl class="form_row">
            <dt class="form_label">Altes Passwort:</dt>
            <dd class="form_input">{$form->password('pw_old')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">Neues Passwort:</dt>
            <dd class="form_input">{$form->password('pw_new')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">Neues Passwort (Wiederholung):</dt>
            <dd class="form_input">{$form->password('pw_repeat')}</dd>
        </dl>
        <dl class="form_row">
            <dd class="form_input">{$form->submit("Passwort setzen")}</dd>
        </dl>
        {$form->close()}
    </div>
HTML;
        
        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

