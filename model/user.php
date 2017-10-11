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

class User
{
    protected $db;
    
    protected $id;
    public $email, $pwhash;
    
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
        
        $query = "CREATE TABLE IF NOT EXISTS users ("
                    ."id INTEGER PRIMARY KEY AUTOINCREMENT,"
                    ."email VARCHAR(255) UNIQUE,"
                    ."pwhash VARCHAR(255)"
                .")";
        
        $db->query($query);
    }
    
    static public function add($email, $plainPassword)
    {
        User::createTable();
        
        $db = \openDB();
        
        $pwhash = password_hash($plainPassword, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO users ("
                    ."email,"
                    ."pwhash"
                .") VALUES ("
                    .$db->quote($email).", "
                    .$db->quote($pwhash)
                .")";
        
        $db->query($query);
        
        return User::find($db->lastInsertId());
    }
    
    static protected function scanRow($user, $row)
    {
        $user->id = $row['id'];
        $user->email = $row['email'];
        $user->pwhash = $row['pwhash'];
    }
    
    static public function find($id)
    {
        $user = new User();
        
        $rows = $user->db->query("SELECT * FROM users WHERE id = ".$user->db->quote($id));
        foreach ($rows as $entry)
        {
            $row = $entry;
        }
        
        User::scanRow($user, $row);

        return $user;
    }
    
    public function save()
    {
        $query = "UPDATE users SET "
                    ."email = ".$this->db->quote($this->email).", "
                    ."pwhash = ".$this->db->quote($this->pwhash)
                ." WHERE id = ".$this->id;
        
        $this->db->query($query);
        
        return $this;
    }
    
    static public function findByEmail($email)
    {
        $user = new User();
        
        $rows = $user->db->query("SELECT * FROM users WHERE email = ".$user->db->quote($email));
        foreach ($rows as $entry)
        {
            $row = $entry;
        }
        
        if (!isset($row))
        {
            return false;
        }
        
        User::scanRow($user, $row);

        return $user;
    }
    
    public function setPassword($plainPassword)
    {
        $this->pwhash = password_hash($plainPassword, PASSWORD_BCRYPT);
    }
    
    public function verifyPassword($plainPassword)
    {
        return password_verify($plainPassword, $this->pwhash);
    }
}

?>

