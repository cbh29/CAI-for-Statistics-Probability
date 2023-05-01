<?php

class Account{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUser($userID)
    {
        $this->db->query('SELECT * FROM users WHERE UserID = :id');
        $this->db->bind(':id', $userID);
        return $this->db->fetch();
    }

    public function getLessons()
    {
        $this->db->query('SELECT * FROM lessons');
        return $this->db->fetchAll();
    }

    public function getLessonByID($lessonID)
    {
        $this->db->query('SELECT * FROM lessons WHERE LessonID = :id');
        $this->db->bind(':id', $lessonID);
        return $this->db->fetch();
    }

    public function getTopicsByLessonID($lessonID)
    {
        $this->db->query('SELECT * FROM topics WHERE LessonID = :id');
        $this->db->bind(':id', $lessonID);
        return $this->db->fetchAll();
    }

    public function getTopicImagesByTopicID($topicID)
    {
        $this->db->query('SELECT * FROM topic_images WHERE TopicID = :id');
        $this->db->bind(':id', $topicID);
        return $this->db->fetchAll();
    }

    public function getTakenLessonsCount($userID, $type)
    {
        $this->db->query('SELECT * FROM `user_scores` WHERE UserID = :userID AND TestType = :type AND Score >= 8 GROUP BY LessonID');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':type', $type);

        return $this->db->rowCount();
    }

    public function getUserAchievements($userID)
    {
        $this->db->query('SELECT user_achievements.AchievementID, Title, Description, CreatedAt FROM `user_achievements` INNER JOIN achievements ON achievements.AchieveID = user_achievements.AchieveID WHERE UserID = :userID');
        $this->db->bind(':userID', $userID);

        return $this->db->fetchAll();
    }

    public function getAchievementCount()
    {
        $this->db->query('SELECT * FROM achievements');
        
        return $this->db->rowCount();
    }
    
    //Drills
    public function getDrillQuestions($orientation)
    {
        $this->db->query('SELECT crossword_questions.QuestionID, Question, Number FROM `crossword_questions` INNER JOIN crossword_answers ON crossword_answers.QuestionID = crossword_questions.QuestionID WHERE Orientation = :orientation');
        $this->db->bind(':orientation', $orientation);
        
        return $this->db->fetchAll();
    }
    
    public function getDrillAnswer()
    {
        $this->db->query('SELECT crossword_answers.QuestionID, Answer, Orientation, PlaceY, PlaceX, Number FROM `crossword_answers` INNER JOIN crossword_questions ON crossword_questions.QuestionID = crossword_answers.QuestionID');
        return $this->db->fetchAll();
    }
    
    public function setUserFinalAnswer($userID, $part, $num, $answer, $dateAnswered)
    {
        $this->db->query('INSERT INTO `user_final_test_answers`(`UserID`, `TestPart`, `TestNumber`, `Answer`, `CreatedAt`) VALUES (:userID, :part, :num, :ans, :date)');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':part', $part);
        $this->db->bind(':num', $num);
        $this->db->bind(':ans', $answer);
        $this->db->bind(':date', $dateAnswered);
        return $this->db->execute();
    }
    
    public function setUserFinalsScore($userID, $score, $timeTaken, $createdAt)
    {
        $this->db->query('INSERT INTO `user_finals_score`(`UserID`, `Score`, `TimeTaken`, `CreatedAt`) VALUES (:userID, :score, :timeTaken, :createdAt)');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':score', $score);
        $this->db->bind(':timeTaken', $timeTaken);
        $this->db->bind(':createdAt', $createdAt);
        
        return $this->db->execute();
    }
    
    public function getUserFinalsAnswers($userID, $createdAt)
    {
        $this->db->query('SELECT * FROM `user_final_test_answers` WHERE UserID = :userID AND CreatedAt = :date');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':date', $createdAt);
        
        return $this->db->fetchAll();
    }
    
    public function getUserFinalScore($userID)
    {
        $this->db->query('SELECT * FROM `user_finals_score` WHERE UserID = :userID ORDER BY ScoreID DESC LIMIT 1');
        $this->db->bind(':userID', $userID);
        
        return $this->db->fetch();
    }
    
    public function getFinalTestAttempts($userID)
    {
        $this->db->query('SELECT * FROM `user_finals_score` WHERE UserID = :userID');
        $this->db->bind(':userID', $userID);
        
        return $this->db->fetchAll();
    }
    
    public function getSecondDrillCount()
    {
        $this->db->query('SELECT * FROM `second_drill_answer`');
        return $this->db->rowCount();
    }
    
    public function getSecondDrillAnswers()
    {
        $this->db->query('SELECT * FROM `second_drill_answer`');
        return $this->db->fetchAll();
    }
    
    public function getSecondDrillImages($drillID)
    {
        $this->db->query('SELECT Image FROM `second_drill_img` WHERE DrillID = :drillID');
        $this->db->bind(':drillID', $drillID);
        return $this->db->fetchAll();
    }
}