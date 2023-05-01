<?php

class Json{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findScore($lessonID, $userID)
    {
        $this->db->query('SELECT * FROM `user_scores` WHERE LessonID = :lessonID AND UserID = :userID ORDER BY ScoreID DESC LIMIT 1');
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':userID', $userID);
        
        return $this->db->rowCount();
    }
    
    public function getSecondDrillImages($drillID)
    {
        $this->db->query("SELECT * FROM `second_drill_img` WHERE DrillID = :drillID");
        $this->db->bind(':drillID', $drillID);
        
        return $this->db->fetchAll();
    }
    
    public function getSecondDrillAnswer($drillID)
    {
        $this->db->query("SELECT Answer FROM `second_drill_answer` WHERE DrillID = :drillID");
        $this->db->bind(':drillID', $drillID);
        
        return $this->db->fetch();
    }

}