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

namespace Controller;

include_once("model/participant.php");

class Signup
{
    static public function index($request)
    {
        if (isset($request["lang"]))
        {
            $fee = \config()["FeeDescription"][$request["lang"]];
        }
        else
        {
            $fee = \config()["FeeDescription"]["de"];
        }
        return \View("Signup", array("fee"=>$fee), $request);
    }
    
    static public function check($request)
    {
        return \View("SignupConfirm", array("check"=>true,"fee"=>\Price::currentPrice($request['role'])), $request);
    }
    
    static public function signup($request)
    {
        $participant = \Model\Participant::add($request['name'], $request['email'], $request['phone'], $request['fara'], $request['role'],$request['paymethod'], $request['remarks'], $request['lang'], \Price::currentPrice($request['role']));
        
        $auto_admission = false;
            
        if ($participant->role == "freshman")
        {
            $admitted = \Model\Participant::getAdmitted($participant->faculty, $participant->role);
            $newer = \Model\Participant::getNewerThan($participant->signup_timestamp, $participant->faculty, $participant->role);
            
            if ((count($admitted) == count($newer)) &&
                    (count($admitted) < \config()["FreshmanQuota"][$participant->faculty]))
            {
                /* Auto admission */
                $auto_admission = true;
                
                $participant->admitted = 1;
                $participant->save();

                /* Send email */
                \sendMail(\mailTemplates()["SignupAdmitted"], $participant, $participant->lang);
            }
            else
            {
                /* Send email */
                \sendMail(\mailTemplates()["SignupWaiting"], $participant, $participant->lang);
            }
        }
        else
        {
            /* Send email */
            \sendMail(\mailTemplates()["SignupMentor"], $participant, $participant->lang);
        }
        
        return \View("SignupConfirm", array("confirm"=>true, "admitted"=>$auto_admission, "fee"=>$participant->fee), $request);
    }
}

