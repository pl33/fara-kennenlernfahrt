<?php

namespace Controller;

include_once("model/participant.php");

class AdminOverview
{
    static public function getAdmitted($faculties)
    {
        /* Participant List */
        $participants_list = array();
        foreach ($faculties as $faculty)
        {
            $participants = \Model\Participant::getAdmitted($faculty);
            $participants_list[$faculty] = $participants;
        }
        
        return $participants_list;
    }
    
    static public function getWaiting($faculties)
    {
        /* Participant List */
        $participants_list = array();
        foreach ($faculties as $faculty)
        {
            $participants = \Model\Participant::getWaiting($faculty);
            $participants_list[$faculty] = $participants;
        }
        
        return $participants_list;
    }
    
    static public function getResigned($faculties)
    {
        /* Participant List */
        $participants_list = array();
        foreach ($faculties as $faculty)
        {
            $participants = \Model\Participant::getResigned($faculty);
            $participants_list[$faculty] = $participants;
        }
        
        return $participants_list;
    }
    
    static public function index($request)
    {
        if (\Login::isLoggedIn())
        {
            $faculties = \config()["FaRas"];

            $variables = array();

            /* Participant List */
            $variables["admitted"] = AdminOverview::getAdmitted($faculties);
            $variables["waiting"] = AdminOverview::getWaiting($faculties);
            $variables["resigned"] = AdminOverview::getResigned($faculties);

            return \View("AdminOverview", $variables, $request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function login($request)
    {
        if (\Login::login($request["email"], $request["password"]))
        {
            return \Controller\AdminOverview::index(array());
        }
        else
        {
            return \View("Login", array("error"=>true), $request);
        }
    }
    
    static public function logout($request)
    {
        \Login::logout();
        
        return \View("Login", array(), $request);
    }
}
