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

class Signup
{
    static public function printView($variables, $request, $lang = "de")
    {
        $html = \Layout\Master::header(array("de"=>"Anmeldung", "en"=>"Signup"), $request, array("Home" => "/"), $lang);
        
        if ($lang == "de")
        {
            $html .= <<<HTML
                <p>Wir freuen uns, dass du bei der Kennenlernfahrt teilnehmen m&ouml;chtest.
                    Bitte f&uuml;lle dieses Formular aus, um dich zu registrieren.</p>
                <p>Vergiss danach nicht, den Unkostenbeitrag schnellstm&ouml;glich zu bezahlen,
                    damit deine Anmeldung nicht verf&auml;llt.</p>
HTML;
        }
        else if ($lang == "en")
        {
            $html .= <<<HTML
                <p>We're glad, that want to join our freshmen's journey.
                    Please fill out this form to sign up.</p>
                <p>Don't forget to pay the fee as fast as possible. Otherwise,
                    your enrollment might expire.</p>
HTML;
        }
        
        $form = new \Layout\Form();
        
        $faras = "";
        foreach (\config()["FaRas"] as $fara)
        {
            $faras .= $form->radio("fara", $fara, $fara)."<br />";
        }
        
        $formLabels = array(
            "de" => array(
                "name" => "Name:",
                "email" => "E-Mail:",
                "phone" => "Mobil-Telefon:",
                "fara" => "Fakult&auml;t:",
                "role" => "Gruppe:",
                "role_freshman" => "Ersti",
                "role_mentor" => "Mentor",
                "role_fara" => "FaRa",
                "paymethod" => "Zahlungsart:",
                "paymethod_bank" => "&Uuml;berweisung",
                "paymethod_cash" => "Bar",
                "remarks" => "Anmerkungen:",
                "signup" => "Anmelden",
                "fee" => "Preis"
            ),
            "en" => array(
                "name" => "Name:",
                "email" => "E-mail:",
                "phone" => "Cell phone:",
                "fara" => "Faculty:",
                "role" => "Group:",
                "role_freshman" => "Freshman",
                "role_mentor" => "Mentor",
                "role_fara" => "FaRa",
                "paymethod" => "Payment method:",
                "paymethod_bank" => "Bank transfer",
                "paymethod_cash" => "Cash",
                "remarks" => "Remarks:",
                "signup" => "Sign up",
                "fee" => "Fee"
            )
        );
        
        $html .= <<<HTML
    <div class="form">
        {$form->open("/signup", $request)}
        <dl class="form_row">
            <dt class="form_label">{$form->label('name', $formLabels[$lang]['name'])}</dt>
            <dd class="form_input">{$form->text('name')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('email', $formLabels[$lang]['email'])}</dt>
            <dd class="form_input">{$form->text('email')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('phone', $formLabels[$lang]['phone'])}</dt>
            <dd class="form_input">{$form->text('phone')}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('fara', $formLabels[$lang]['fara'])}</dt>
            <dd class="form_input">{$faras}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('role', $formLabels[$lang]['role'])}</dt>
            <dd class="form_input">{$form->radio("role", "freshman", $formLabels[$lang]['role_freshman'])}<br />
                {$form->radio("role", "mentor", $formLabels[$lang]['role_mentor'])}<br />
                {$form->radio("role", "fara", $formLabels[$lang]['role_fara'])}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('paymethod', $formLabels[$lang]['paymethod'])}</dt>
            <dd class="form_input">{$form->radio("paymethod", "bank", $formLabels[$lang]['paymethod_bank'])}<br />
                {$form->radio("paymethod", "cash", $formLabels[$lang]['paymethod_cash'])}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$form->label('remarks', $formLabels[$lang]['remarks'])}</dt>
            <dd class="form_input">{$form->textarea("remarks")}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['fee']}</dt>
            <dd class="form_input">{$variables["fee"]}</dd>
        </dl>
        <dl class="form_row">
            <dd class="form_input">{$form->submit($formLabels[$lang]['signup'])}</dd>
        </dl>
        {$form->close()}
    </div>
HTML;

        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

?>

