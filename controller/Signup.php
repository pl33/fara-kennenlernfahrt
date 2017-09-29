<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

