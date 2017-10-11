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

namespace Model;

class Participant
{
    protected $db;
    
    public $id, $name, $email, $phone, $faculty, $role, $paymethod, $remarks, $signup_timestamp, $admitted, $paid, $resinged, $refunded, $lang, $fee;
    
    function __construct()
    {
        $this->db = \openDB();
        $this->createTable($this->db);
    }
    
    static public function createTable($db = null)
    {
        if ($db == null)
        {
            $db = \openDB();
        }
        
        $query = "CREATE TABLE IF NOT EXISTS participants ("
                    ."id INTEGER PRIMARY KEY AUTOINCREMENT,"
                    ."name VARCHAR(255),"
                    ."email VARCHAR(255),"
                    ."phone VARCHAR(255),"
                    ."faculty VARCHAR(16),"
                    ."role VARCHAR(16),"
                    ."paymethod VARCHAR(16),"
                    ."remarks TEXT,"
                    ."signup_timestamp TEXT,"
                    ."admitted INTEGER DEFAULT 0,"
                    ."paid INTEGER DEFAULT 0,"
                    ."resigned TEXT DEFAULT (''),"
                    ."refunded INTEGER DEFAULT 0,"
                    ."lang VARCHAR(16),"
                    ."fee REAL"
                .")";
        
        $db->query($query);
    }
    
    static public function add($name, $email, $phone, $faculty, $role, $paymethod, $remarks, $lang, $fee)
    {
        Participant::createTable();
        
        $db = \openDB();
        
        if (!in_array($faculty, \config()["FaRas"]))
        {
            throw \Exception();
        }
        if (!in_array($role, array("freshman", "mentor", "fara")))
        {
            throw \Exception();
        }
        if (!in_array($paymethod, array("bank", "cash")))
        {
            throw \Exception();
        }
        
        $query = "INSERT INTO participants ("
                    ."name,"
                    ."email,"
                    ."phone,"
                    ."faculty,"
                    ."role,"
                    ."paymethod,"
                    ."remarks,"
                    ."signup_timestamp,"
                    ."lang,"
                    ."fee"
                .") VALUES ("
                    .$db->quote($name).", "
                    .$db->quote($email).", "
                    .$db->quote($phone).", "
                    .$db->quote($faculty).", "
                    .$db->quote($role).", "
                    .$db->quote($paymethod).", "
                    .$db->quote($remarks).", "
                    ."datetime('now', 'localtime'),"
                    .$db->quote($lang).", "
                    .$db->quote($fee)
                .")";
        
        $db->query($query);
        
        return Participant::find($db->lastInsertId());
    }
    
    static protected function scanRow($participant, $row)
    {
        $participant->id = $row['id'];
        $participant->name = $row['name'];
        $participant->email = $row['email'];
        $participant->phone = $row['phone'];
        $participant->faculty = $row['faculty'];
        $participant->role = $row['role'];
        $participant->paymethod = $row['paymethod'];
        $participant->remarks = $row['remarks'];
        $participant->signup_timestamp = $row['signup_timestamp'];
        $participant->admitted = $row['admitted'];
        $participant->paid = $row['paid'];
        $participant->resigned = $row['resigned'];
        $participant->refunded = $row['refunded'];
        $participant->lang = $row['lang'];
        $participant->fee = $row['fee'];
    }


    static public function find($id)
    {
        $participant = new Participant();
        
        $rows = $participant->db->query("SELECT * FROM participants WHERE id = ".$participant->db->quote($id));
        foreach ($rows as $entry)
        {
            $row = $entry;
        }
        
        if (!isset($row))
        {
            return false;
        }
        
        Participant::scanRow($participant, $row);

        return $participant;
    }
    
    public function save()
    {
        if (!in_array($this->faculty, \config()["FaRas"]))
        {
            throw \Exception();
        }
        if (!in_array($this->role, array("freshman", "mentor", "fara")))
        {
            throw \Exception();
        }
        if (!in_array($this->paymethod, array("bank", "cash")))
        {
            throw \Exception();
        }
        
        $query = "UPDATE participants SET "
                    ."name = ".$this->db->quote($this->name).", "
                    ."email = ".$this->db->quote($this->email).", "
                    ."phone = ".$this->db->quote($this->phone).", "
                    ."faculty = ".$this->db->quote($this->faculty).", "
                    ."role = ".$this->db->quote($this->role).", "
                    ."paymethod = ".$this->db->quote($this->paymethod).", "
                    ."remarks = ".$this->db->quote($this->remarks).", "
                    ."signup_timestamp = ".$this->db->quote($this->signup_timestamp).", "
                    ."admitted = ".$this->db->quote($this->admitted).", "
                    ."paid = ".$this->db->quote($this->paid).", "
                    ."resigned = ".$this->db->quote($this->resigned).", "
                    ."refunded = ".$this->db->quote($this->refunded).", "
                    ."lang = ".$this->db->quote($this->lang).", "
                    ."fee = ".$this->db->quote($this->fee)
                ." WHERE id = ".$this->id;
        
        $this->db->query($query);
        
        return $this;
    }
    
    static public function getAdmitted($faculty = "", $role = "")
    {
        $db = \openDB();
        
        $participant_list = array();
        
        $query = "SELECT * FROM participants WHERE (resigned = '') AND (admitted != 0)";
        if ($faculty != "")
        {
            $query .= " AND (faculty = ".$db->quote($faculty).")";
        }
        if ($role != "")
        {
            $query .= " AND (role = ".$db->quote($role).")";
        }
        $query .= " ORDER BY signup_timestamp";
        
        $rows = $db->query($query);
        foreach ($rows as $entry)
        {
            $participant = new Participant();
            Participant::scanRow($participant, $entry);
            
            array_push($participant_list, $participant);
        }

        return $participant_list; 
    }
    
    static public function getWaiting($faculty = "", $role = "")
    {
        $db = \openDB();
        
        $participant_list = array();
        
        $query = "SELECT * FROM participants WHERE (resigned = '') AND (admitted == 0)";
        if ($faculty != "")
        {
            $query .= " AND (faculty = ".$db->quote($faculty).")";
        }
        if ($role != "")
        {
            $query .= " AND (role = ".$db->quote($role).")";
        }
        $query .= " ORDER BY signup_timestamp";
        
        $rows = $db->query($query);
        foreach ($rows as $entry)
        {
            $participant = new Participant();
            Participant::scanRow($participant, $entry);
            
            array_push($participant_list, $participant);
        }

        return $participant_list; 
    }
    
    static public function getNewerThan($timestamp, $faculty = "", $role = "")
    {
        $db = \openDB();
        
        $participant_list = array();
        
        $query = "SELECT * FROM participants WHERE (resigned = '') AND (signup_timestamp < ".$db->quote($timestamp).")";
        if ($faculty != "")
        {
            $query .= " AND (faculty = ".$db->quote($faculty).")";
        }
        if ($role != "")
        {
            $query .= " AND (role = ".$db->quote($role).")";
        }
        $query .= " ORDER BY signup_timestamp";
        
        $rows = $db->query($query);
        foreach ($rows as $entry)
        {
            $participant = new Participant();
            Participant::scanRow($participant, $entry);
            
            array_push($participant_list, $participant);
        }

        return $participant_list; 
    }
    
    static public function getResigned($faculty = "", $role = "")
    {
        $db = \openDB();
        
        $participant_list = array();
        
        $query = "SELECT * FROM participants WHERE (resigned != '')";
        if ($faculty != "")
        {
            $query .= " AND (faculty = ".$db->quote($faculty).")";
        }
        if ($role != "")
        {
            $query .= " AND (role = ".$db->quote($role).")";
        }
        $query .= " ORDER BY signup_timestamp";
        
        $rows = $db->query($query);
        foreach ($rows as $entry)
        {
            $participant = new Participant();
            Participant::scanRow($participant, $entry);
            
            array_push($participant_list, $participant);
        }

        return $participant_list; 
    }
}

?>
