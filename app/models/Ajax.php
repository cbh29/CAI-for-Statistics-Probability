<?php

class Ajax{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getLessonByLessonID($lessonID)
    {
        $this->db->query('SELECT * FROM lessons WHERE LessonID = :id');
        $this->db->bind(':id', $lessonID);
        
        return $this->db->fetch();
    }

    public function getTestsByLessonID($lessonID, $type)
    {
        $this->db->query('SELECT * FROM tests WHERE LessonID = :id AND Type = :type');
        $this->db->bind(':id', $lessonID);
        $this->db->bind(':type', $type);

        return $this->db->fetchAll();
    }

    public function getTestChoicesByTestID($testID)
    {
        $this->db->query('SELECT * FROM test_choices WHERE TestID = :id');
        $this->db->bind(':id', $testID);

        return $this->db->fetchAll();
    }

    public function getTestAnswerByTestID($testID)
    {
        $this->db->query('SELECT * FROM test_answers WHERE TestID = :id');
        $this->db->bind(':id', $testID);

        return $this->db->fetch();
    }

    public function getUserScore($userID, $lessonID, $type)
    {
        $this->db->query('SELECT * FROM `user_scores` WHERE UserID = :userID AND LessonID = :lessonID AND TestType = :type ORDER BY CreatedAt DESC LIMIT 1');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':type', $type);

        return $this->db->fetch();
    }

    public function getUserAnswers($userID, $lessonID, $type, $items)
    {
        $this->db->query('SELECT user_answers.ChoiceID, test_choices.Choice, tests.TestID, tests.Question, tests.Image FROM `user_answers` INNER JOIN tests ON tests.TestID = user_answers.TestID INNER JOIN test_choices ON test_choices.ChoiceID = user_answers.ChoiceID WHERE UserID = :userID AND LessonID = :lessonID AND Type = :type ORDER BY user_answers.CreatedAt DESC LIMIT :items');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':type', $type);
        $this->db->bind(':items', $items);

        return $this->db->fetchAll();
    }

    public function getTestAnswer($testID)
    {
        $this->db->query('SELECT test_answers.Answer, test_choices.Choice FROM `test_answers` INNER JOIN test_choices ON test_choices.ChoiceID = test_answers.Answer WHERE test_answers.TestID = :testID');
        $this->db->bind(':testID', $testID);
        
        return $this->db->fetch();
    }

    public function getAchievement($lessonID, $type)
    {
        $this->db->query('SELECT * FROM `achievements` WHERE LessonID = :lessonID AND TestType = :type');
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':type', $type);
        
        return $this->db->fetch();
    }

    public function setUserAnswers($userID, $testID, $choiceID, $date)
    {
        $this->db->query('INSERT INTO `user_answers`(`UserID`, `TestID`, `ChoiceID`, `CreatedAt`) VALUES (:userID, :testID, :choiceID, :createdAt)');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':testID', $testID);
        $this->db->bind(':choiceID', $choiceID);
        $this->db->bind(':createdAt', $date);

        return $this->db->execute();
    }

    public function setUserScore($userID, $lessonID, $score, $testType)
    {
        $this->db->query('INSERT INTO `user_scores`(`UserID`, `LessonID`, `Score`, `TestType`) VALUES (:userID, :lessonID, :score, :type)');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':score', $score);
        $this->db->bind(':type', $testType);

        return $this->db->execute();
    }

    public function setUserAchievement($userID, $achieveID)
    {
        $this->db->query('INSERT INTO `user_achievements`(`UserID`, `AchieveID`) VALUES (:userID, :achieveID)');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':achieveID', $achieveID);

        return $this->db->execute();
    }
    
    public function getUserAchievement($userID, $achieveID){
        $this->db->query('SELECT * FROM `user_achievements` WHERE UserID = :userID AND AchieveID = :achieveID');
        $this->db->bind(':userID', $userID);
        $this->db->bind(':achieveID', $achieveID);
        
        return $this->db->rowCount();
    }
}