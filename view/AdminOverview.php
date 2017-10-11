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

class AdminOverview
{
    static public function checkCondition($participant, $conditions)
    {
        $result = true;
        
        foreach ($conditions as $name => $val)
        {
            if ($participant->$name != $val)
            {
                $result = false;
            }
        }
        
        return $result;
    }
    
    static public function makeList($list, $caption, $request, $actions=array())
    {
        $html = "";
        
        $facultyArg = "";
        if (isset($request["faculty"]))
        {
            $facultyArg = "&faculty=".$request["faculty"];
        }
        
        foreach ($list as $faculty => $sublist)
        {
            $html .= "<h1>".$caption." ".$faculty."</h1>";
            $html .= "<table class=\"participants\">";
            $html .= <<<HTML
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Telefon</th>
                        <th>Gruppe</th>
                        <th>Zahlungsart</th>
                        <th>Anmerkung</th>
                        <th>Zeitstempel</th>
                        <th>Zahlung</th>
                        <th>Aktion</th>
                    </tr>
HTML;
            
            foreach ($sublist as $participant)
            {
                $name = htmlspecialchars($participant->name);
                $email = htmlspecialchars($participant->email);
                $phone = htmlspecialchars($participant->phone);
                $remarks = htmlspecialchars($participant->remarks);
                $signup_timestamp = htmlspecialchars($participant->signup_timestamp);
                
                $roleList = array(
                    "freshman" => "Ersti",
                    "mentor" => "Mentor",
                    "fara" => "FaRa"
                );
                $role = $roleList[$participant->role];
                
                $paymethodList = array(
                    "bank" => "&Uuml;berweisung",
                    "cash" => "Bar"
                );
                $paymethod = $paymethodList[$participant->paymethod];
                
                $paid = "Nein";
                if ($participant->paid == 1)
                {
                    $paid = "Bezahlt";
                }
                if ($participant->refunded == 1)
                {
                    $paid = "Erstattet";
                }
                
                $actionsHtml = "<ul class=\"actions\">";
                foreach ($actions as $action)
                {
                    if (!isset($action["conditions"]) || \View\AdminOverview::checkCondition($participant, $action["conditions"]))
                    {
                        $actionsHtml .= "<li><a href=\"?p=".$action["path"].$facultyArg."&id=".$participant->id."\">".$action["title"]."</a></li>";
                    }
                }
                $actionsHtml .= "</ul>";
                
                $html .= <<<HTML
                    <tr>
                        <td>{$name}</td>
                        <td>{$email}</td>
                        <td>{$phone}</td>
                        <td>{$role}</td>
                        <td>{$paymethod}</td>
                        <td>{$remarks}</td>
                        <td>{$signup_timestamp}</td>
                        <td>{$paid}</td>
                        <td>{$actionsHtml}</td>
                    </tr>
HTML;
            }
            
            $html .= "</table>";
        }
        
        return $html;
    }
    
    static public function printView($variables, $request, $lang = "de")
    {
        /* Force German */
        $lang = "de";
        
        $menu = array("Home" => "/admin", "Passwort &auml;ndern" => "/changepw", "Logout" => "/logout");
        foreach (\config()["FaRas"] as $fara)
        {
            $menu[$fara] = "/admin&faculty=".$fara;
        }
        
        $html = \Layout\Master::header(array("de"=>"&Uuml;bersicht", "en"=>"Overview"), $request, $menu, $lang, "wide");
        
        $html .= <<<HTML
                <p>In der Teilnehmerliste sind alle, die mitfahren werden.
                    Sobald sie die Geb&uuml;hr bezahlen, kannst du dies mit Zahlungseingang markieren.
                    Ein Klick auf R&uuml;cktritt verschiebt den Teilnahmer auf die Liste mit den zur&uuml;ckgetretenen Teilnehmern.
                    Von dort k&ouml;nnen sie wieder auf die Warteliste verschoben werden.
                    Zur&uuml;ckgetretenen Teilnehmern kann ihr Beitrag wieder erstattet werden.</p>
                
                <p><strong>Vergiss nicht die Teilnehmer &uuml;ber die Vorg&auml;nge per E-Mail zu informieren!</strong></p>
HTML;
        
        /* Participant List */
        $html .= AdminOverview::makeList($variables["admitted"], "Teilnehmer", $request, array(
            array("title" => "Zahlungseingang", "path" => "/paid", "conditions" => array("paid" => 0)),
            array("title" => "Zahlung zur&uuml;cksetzen", "path" => "/paymentreset", "conditions" => array("refunded" => 1, "paid" => 1)),
            array("title" => "R&uuml;cktritt", "path" => "/resign")
        ));
        
        /* Waiting List */
        $html .= AdminOverview::makeList($variables["waiting"], "Warteliste", $request, array(
            array("title" => "Zahlungseingang", "path" => "/paid", "conditions" => array("paid" => 0)),
            array("title" => "Zahlung zur&uuml;cksetzen", "path" => "/paymentreset", "conditions" => array("refunded" => 1, "paid" => 1)),
            array("title" => "Auf die Teilnahmeliste", "path" => "/admitted"),
            array("title" => "R&uuml;cktritt", "path" => "/resign")
        ));
        
        /* Resigned */
        $html .= AdminOverview::makeList($variables["resigned"], "R&uuml;cktritt", $request, array(
            array("title" => "Betrag r&uuml;ckerstattet", "path" => "/refunded", "conditions" => array("refunded" => 0, "paid" => 1)),
            array("title" => "Zahlung zur&uuml;cksetzen", "path" => "/paymentreset", "conditions" => array("refunded" => 1, "paid" => 1)),
            array("title" => "Auf die Warteliste", "path" => "/towaiting")
        ));
        
        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

