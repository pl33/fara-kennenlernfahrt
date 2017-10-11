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

class SignupConfirm
{
    static public function printView($variables, $request, $lang = "de")
    {
        $html = \Layout\Master::header(array("de"=>"Best&auml;tigung", "en"=>"Confirmation"), $request, array("Home" => "/"), $lang);
        
        if (isset($variables["check"]))
        {
            if ($lang == "de")
            {
                $html .= <<<HTML
                    <p>Bitte prüfe deine Daten.</p>
HTML;
            }
            else if ($lang == "en")
            {
                $html .= <<<HTML
                    <p>Please check your data.</p>
HTML;
            }
        }
        else if (isset($variables["confirm"]))
        {
            if ($lang == "de")
            {
                if ($variables["admitted"])
                {
                    $admittance_notice = "Du steht auf der Teilnehmerliste.";
                }
                else
                {
                    $admittance_notice = "Du stehst gerade auf der Warteliste. Sobald ein Platz f&uuml;r dich frei wird, melden wir uns.";
                }
                $html .= <<<HTML
                    <p>Deine Anmeldung war erfolgreich. <strong>{$admittance_notice}</strong> Wir werden dich per
                        E-Mail &uuml;ber Neuigkeiten informaieren.</p>
                    <p>Falls du dich abmelden m&ouml;chtest, schicke uns bitte
                        eine E-Mail.</p>
HTML;
                    
                if ($variables["admitted"])
                {
                    $html .= "<p><strong>Vergiss bitte nicht, die Teilnahmegeb&uuml;hr zu bezahlen. :-)</strong></p>";
                }
            }
            else if ($lang == "en")
            {
                if ($variables["admitted"])
                {
                    $admittance_notice = "Your sign-up was automatically confirmed.";
                }
                else
                {
                    $admittance_notice = "You are currently on the waiting list. We'll let you, if there a spare place for you.";
                }
                $html .= <<<HTML
                    <p>You are successfully signed-up. <strong>{$admittance_notice}</strong>  We will contact you
                        via e-mail if there are any news.</p>
                    <p>If you want to withdraw you enrollment, please send
                        us an e-mail.</p> 
HTML;
                    
                if ($variables["admitted"])
                {
                    $html .= "<p><strong>Please don't forget to pay the fee. :-)</strong></p>";
                }
            }
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
                "confirm" => "Best&auml;tigen",
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
                "confirm" => "Confirm",
                "fee" => "Fee"
            )
        );
        
        $role = $formLabels[$lang]["role_".$request['role']];
        $paymethod = $formLabels[$lang]["paymethod_".$request['paymethod']];
        
        $html .= <<<HTML
    <div class="form">
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['name']}</dt>
            <dd class="form_input">{$request['name']}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['email']}</dt>
            <dd class="form_input">{$request['email']}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['phone']}</dt>
            <dd class="form_input">{$request['phone']}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['fara']}</dt>
            <dd class="form_input">{$request['fara']}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['role']}</dt>
            <dd class="form_input">{$role}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['paymethod']}</dt>
            <dd class="form_input">{$paymethod}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['remarks']}</dt>
            <dd class="form_input">{$request['remarks']}</dd>
        </dl>
        <dl class="form_row">
            <dt class="form_label">{$formLabels[$lang]['fee']}</dt>
            <dd class="form_input">{$variables["fee"]} €</dd>
        </dl>
    </div>
HTML;
                
        if (isset($variables["check"]))
        {
            $form = new \Layout\Form();
            
            $html .= <<<HTML
    <div class="form">
            {$form->open("/dosignup", $request)}
HTML;
            
            $html .= $form->hidden("name", $request['name']);
            $html .= $form->hidden("email", $request['email']);
            $html .= $form->hidden("phone", $request['phone']);
            $html .= $form->hidden("fara", $request['fara']);
            $html .= $form->hidden("role", $request['role']);
            $html .= $form->hidden("paymethod", $request['paymethod']);
            $html .= $form->hidden("remarks", $request['remarks']);
            
            $html .= <<<HTML
        <dl class="form_row">
            <dd class="form_input">{$form->submit($formLabels[$lang]['confirm'])}</dd>
        </dl>
                    {$form->close()}
    </div>
HTML;
        }
        
        
        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

