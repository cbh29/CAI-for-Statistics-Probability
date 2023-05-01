<?php

class Tests extends Controller{

    public function __construct()
    {
        $this->testModel = $this->model('Test');
    }

    public function tests()
    {
        $type = "pre";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //set test
            $lessonID = $_POST['lessonID'];
            $question = $_POST['question'];
            $imgFile = $_FILES['imgFile'];
            $this->testModel->setTest($lessonID, $question, $imgFile, $type);

            //set choices
            $testID = $this->testModel->getTestID($question, $lessonID, $type)['TestID'];
            $choices = $_POST['choices'];
            foreach($choices as $choice){
                $this->testModel->setChoices($testID, $choice);
            }

            //set answer
            $answer = $_POST['choice'];
            $choiceID = $this->testModel->getChoiceID($testID, $answer)['ChoiceID'];
            $this->testModel->setAnswer($testID, $choiceID);
        }

        $this->view('tests');
    }

}