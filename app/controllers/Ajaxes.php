<?php

class Ajaxes extends Controller{

    public function __construct()
    {
        $this->ajaxModel = $this->model('Ajax');
    }

    public function tests()
    {
        $lesson = $this->ajaxModel->getLessonByLessonID($_POST['lessonID']);
        $questions = $this->ajaxModel->getTestsByLessonID($_POST['lessonID'], $_POST['type']);
        
        for($i = 0; $i < count($questions); $i++){
            $questions[$i]['Choices'] = $this->ajaxModel->getTestChoicesByTestID($questions[$i]['TestID']);
        }

        $data['tests'] = $questions;
        shuffle($data['tests']);

        $data['lessonNo'] = $lesson['LessonNo'];
        $data['lessonID'] = $lesson['LessonID'];
        $data['type'] = $_POST['type'];

        $this->view('ajaxes/tests', $data);
    }

    public function submitTests()
    {
        $answers = $_POST['answers'];
        $score = 0;
        $date = date('Y-m-d H:i:s');

        foreach($answers as $answer){
            $this->ajaxModel->setUserAnswers($_SESSION['USER_ID'], $answer['test-id'], $answer['answer-id'], $date);

            $testAnswer = $this->ajaxModel->getTestAnswerByTestID($answer['test-id']);
            if($testAnswer['Answer'] == $answer['answer-id']){
                $score++;
            }
        }
        
        $this->ajaxModel->setUserScore($_SESSION['USER_ID'], $_POST['lessonID'], $score, $_POST['type']);

        //set achievement
        $achievement = $this->ajaxModel->getAchievement($_POST['lessonID'], $_POST['type']);
        if(isset($achievement['AchieveID'])){
            if($_POST['lessonID'] == 1 && $_POST['type'] == "pre"){
                if($score >= 5){
                    $this->ajaxModel->setUserAchievement($_SESSION['USER_ID'], $achievement['AchieveID']);
                }
            }

            if($score >= 8){
                $this->ajaxModel->setUserAchievement($_SESSION['USER_ID'], $achievement['AchieveID']);
            }
        }
    }

    public function testResult()
    {
        $lesson = $this->ajaxModel->getLessonByLessonID($_POST['lesson-id']);

        $userScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $_POST['lesson-id'], $_POST['type']);
        $userAnswers = $this->ajaxModel->getUserAnswers($_SESSION['USER_ID'], $_POST['lesson-id'], $_POST['type'], intval($_POST['total-items']));
        for($i = 0; $i < count($userAnswers); $i++){
            $testAnswers[$i] = $this->ajaxModel->getTestAnswer($userAnswers[$i]['TestID']);
        }

        $data['lessonNo'] = $lesson['LessonNo'];
        $data['items'] = $_POST['total-items'];
        $data['score'] = $userScore['Score'];
        $data['type'] = $_POST['type'];

        $data['userAnswers'] = $userAnswers;
        $data['testAnswers'] = $testAnswers;

        $this->view('ajaxes/testResult', $data);
    }
    
    public function crosswordAnswers()
    {
        echo json_encode($this->ajaxModel->getCrosswordAnswers());
    }
}