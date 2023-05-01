<?php

class Test{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function setTest($lessonID, $question, $image, $type)
    {
        if($image['error'] == 0){
            $imgName = uniqid() . $image['name'];
        }
        else{
            $imgName = "";
        }

        $this->db->query('INSERT INTO `tests`(`LessonID`, `Question`, `Image`, `Type`) VALUES (:lessonID, :question, :imgName, :type);');
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':question', $question);
        $this->db->bind(':imgName', $imgName);
        $this->db->bind(':type', $type);

        if($this->db->execute() && ($image['error'] == 0)){
            move_uploaded_file($image['tmp_name'], PUBLIC_ROOT . '/uploads/' . $imgName);
        }
    }
    
    public function getTestID($question, $lessonID, $type)
    {
        $this->db->query('SELECT * FROM `tests` WHERE Question = :question AND LessonID = :lessonID AND Type = :type');
        $this->db->bind(':question', $question);
        $this->db->bind(':lessonID', $lessonID);
        $this->db->bind(':type', $type);

        return $this->db->fetch();
    }

    public function setChoices($testID, $choice)
    {
        $this->db->query('INSERT INTO `test_choices`(`TestID`, `Choice`) VALUES (:testID, :choice)');
        $this->db->bind(':testID', $testID);
        $this->db->bind(':choice', $choice);

        return $this->db->execute();
    }

    public function getChoiceID($testID, $answer)
    {
        $this->db->query('SELECT * FROM `test_choices` WHERE TestID = :testID AND Choice = :choice');
        $this->db->bind(':testID', $testID);
        $this->db->bind(':choice', $answer);

        return $this->db->fetch();
    }

    public function setAnswer($testID, $choiceID)
    {
        $this->db->query('INSERT INTO `test_answers`(`TestID`, `Answer`) VALUES (:testID, :answer)');
        $this->db->bind(':testID', $testID);
        $this->db->bind(':answer', $choiceID);

        return $this->db->execute();
    }
}