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
            if (isset($request["faculty"]))
            {
                $faculties = array($request["faculty"]);
            }

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
    
    static public function paid($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->paid = 1;
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function admitted($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->admitted = 1;
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function towaiting($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->admitted = 0;
                $participant->resigned = '';
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function resign($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->resigned = date('Y-m-d H:i:s');
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function refunded($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->refunded = 1;
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
        }
        else
        {
            return \View("Login", array(), $request);
        }
    }
    
    static public function paymentreset($request)
    {
        if (\Login::isLoggedIn())
        {
            $participant = \Model\Participant::find($request["id"]);
            
            if ($participant != false)
            {
                $participant->paid = 0;
                $participant->refunded = 0;
                $participant->save();
            }

            return \Controller\AdminOverview::index($request);
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
