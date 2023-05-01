<?php

class User{

    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function setUser($data)
    {
        $imgName = uniqid() . $data['imgName'];

        $this->db->query('INSERT INTO `users`(`Firstname`, `Lastname`, `Username`, `Password`, `Image`) VALUES (:fName, :lName, :uName, :pass, :img)');
        $this->db->bind(':fName', $data['fName']);
        $this->db->bind(':lName', $data['lName']);
        $this->db->bind(':uName', $data['uName']);
        $this->db->bind(':pass', $data['pass']);
        $this->db->bind(':img', $imgName);

        if($this->db->execute()){
            move_uploaded_file($data['imgTmpName'], PUBLIC_ROOT . '/uploads/' . $imgName);
            return true;
        }
        else{
            false;
        }
    }

    public function getUser($data)
    {
        $this->db->query('SELECT * FROM `users` WHERE Username = :uName AND Password = :pass');
        $this->db->bind(':uName', $data['uName']);
        $this->db->bind(':pass', $data['pass']);

        if($this->db->fetch()){
            return $this->db->fetch();
        }
        else{
            return false;
        }
    }
}