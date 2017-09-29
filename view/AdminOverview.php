<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace View;

class AdminOverview
{
    static public function makeList($list, $caption)
    {
        $html = "";
        
        foreach ($list as $faculty => $sublist)
        {
            $html .= "<h1>".$caption." ".$faculty."</h1>";
            $html .= "<ul class=\"participants\">";
            
            foreach ($sublist as $participant)
            {
                
                $html .= <<<HTML
                    <li>
                        <div class="name">{$participant->name}</div>
                    </li>
HTML;
            }
            
            $html .= "</ul>";
        }
        
        return $html;
    }
    
    static public function printView($variables, $request, $lang = "de")
    {
        /* Force German */
        $lang = "de";
        
        $html = \Layout\Master::header(array("de"=>"&Uuml;bersicht", "en"=>"Overview"), $request, array("Home" => "/admin"), $lang);
        
        /* Participant List */
        $html .= AdminOverview::makeList($variables["admitted"], "Teilnehmer");
        
        /* Waiting List */
        $html .= AdminOverview::makeList($variables["waiting"], "Warteliste");
        
        /* Resigned */
        $html .= AdminOverview::makeList($variables["resigned"], "R&uuml;cktritt");
        
        $html .= \Layout\Master::footer($request, $lang);
        
        return $html;
    }
}

