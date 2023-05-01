<?php

class Accounts extends Controller{

    public function __construct()
    {
        $this->accModel = $this->model('Account');
        $this->ajaxModel = $this->model('Ajax');
        $this->profile = $this->accModel->getUser($_SESSION['USER_ID']);
        $this->finalsScore = $this->accModel->getUserFinalScore($_SESSION['USER_ID'])['Score'] ?? 0;

        if(!isLoggedIn()){
            header('location: ' . URLROOT . '/users/login');
        }
    }
    
    public function dashboard()
    {
        $data['page'] = "dashboard";
        $data['profile'] = $this->profile;
        $data['lessons'] = $this->lockLesson();
        $data['is-passed'] = $this->finalsScore >= 30;

        $data['noLessonsTaken'] = $this->accModel->getTakenLessonsCount($_SESSION['USER_ID'], "post");
        $data['achievements'] = $this->accModel->getUserAchievements($_SESSION['USER_ID']);
        
        $data['final-test-score'] = $this->accModel->getUserFinalScore($_SESSION['USER_ID'])['Score'] ?? 0;
        $data['final-test-attempts'] = $this->accModel->getFinalTestAttempts($_SESSION['USER_ID']);

        $this->view('accounts/dashboard', $data);
    }

    public function lessons($id)
    {
        $data['page'] = $id;
        $data['profile'] = $this->profile;
        $data['lessons'] = $this->lockLesson();
        $data['is-passed'] = $this->finalsScore >= 30;

        $lesson = $this->accModel->getLessonByID($id);
        $postTestScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $lesson['LessonID'], "post");

        $data['lesson'] = $lesson;
        $data['topics'] = $this->accModel->getTopicsByLessonID($id);
        $data['score'] = $postTestScore['Score'] ?? 0;
        
        for($i = 0; $i < count($data['topics']); $i++){
            $data['images'][$i] = $this->accModel->getTopicImagesByTopicID($data['topics'][$i]['TopicID']);
        }

        $this->view('accounts/lessons', $data);
    }

    public function drills()
    {
        $data['page'] = "drills";
        $data['profile'] = $this->profile;
        $data['lessons'] = $this->lockLesson();
        $data['is-passed'] = $this->finalsScore >= 30;
        
        $data['drill-answers'] = $this->accModel->getDrillAnswer();
        $data['drill-status'] = json_decode(file_get_contents(PUBLIC_ROOT . '/data/drills-status.json'), true);
        
        $data['vert-question'] = $this->accModel->getDrillQuestions('vert');
        $data['hori-question'] = $this->accModel->getDrillQuestions('hori');

        $this->view('accounts/drills', $data);
    }
    
    public function secondDrills()
    {
        $data['page'] = "secondDrills";
        $data['profile'] = $this->profile;
        $data['lessons'] = $this->lockLesson();
        $data['is-passed'] = $this->finalsScore >= 30;
        $data['drill-count'] = $this->accModel->getSecondDrillCount();
        $data['number'] = 0;
        $data['drill-data'] = [];
        
        $jsonData = json_decode(file_get_contents(URLROOT . "/data/second-drill.json"), true);
        if(isset($jsonData) && isset($jsonData[$_SESSION['USER_ID']])){
            $data['number'] = $jsonData[$_SESSION['USER_ID']]['answered'];
            $data['number'] = $data['number'][sizeof($data['number']) - 1];
        }
        
        if($data['number'] == $data['drill-count']){
            $drillAnswer = $this->accModel->getSecondDrillAnswers();
            for($i = 0; $i < count($drillAnswer); $i++){
                $drillAnswer[$i]['Images'] = $this->accModel->getSecondDrillImages($drillAnswer[$i]['DrillID']);
            }
            $data['drill-data'] = $drillAnswer;
        }
        
        $this->view('accounts/secondDrill', $data);
    }
    
    public function secondDrillSubmit()
    {
        $jsonDataInput = json_decode(file_get_contents(URLROOT . "/data/second-drill.json"), true);
        if(isset($jsonDataInput[$_SESSION['USER_ID']]['answered'])){
            array_push($jsonDataInput[$_SESSION['USER_ID']]['answered'], $_POST['number']);
        }
        else{
            $answered = array();
            array_push($answered, $_POST['number']);
            $jsonDataInput[$_SESSION['USER_ID']]['answered'] = $answered;
        }
        $jsonDataInput = json_encode($jsonDataInput);
        
        file_put_contents(PUBLIC_ROOT . "/data/second-drill.json", $jsonDataInput);
    }
    
    public function finals()
    {
        $data['finals-data'] = json_decode(file_get_contents(PUBLIC_ROOT . '/data/final-test.json'), true);
        $data['lesson-five-score'] = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], 5, 'post')['Score'] ?? 0;
        $data['prev-finals-score'] = $this->accModel->getUserFinalScore($_SESSION['USER_ID']);
        
        if(isset($data['prev-finals-score']['Score'])){
            if($data['prev-finals-score']['Score'] >= 30){
                header('location:' . URLROOT . '/accounts/finalsResult');
            }
        }
        
        $this->view('accounts/finals', $data);
    }
    
    public function finalsResult()
    {
        function getAnswerByPartAndNumber($array, $part, $num){
            $indexKey = -1;
            foreach($array as $key => $arr){
                if($arr['TestPart'] == $part && $arr['TestNumber'] == $num){
                    $indexKey = $key;
                    break;
                }
            }
            return $array[$indexKey]['Answer'];
        }
        
        $data['final-test'] = json_decode(file_get_contents(PUBLIC_ROOT . '/data/final-test.json'), true);
        $data['final-score-date'] = $this->accModel->getuserFinalScore($_SESSION['USER_ID'])['CreatedAt'];
        $data['test-answers'] = $data['final-test']['Answers'];
        $data['user-answers'] = $this->accModel->getUserFinalsAnswers($_SESSION['USER_ID'], $data['final-score-date']);
        $data['time-taken'] = $this->accModel->getUserFinalScore($_SESSION['USER_ID'])['TimeTaken'];
        
        //compute scores per part
        foreach($data['test-answers'] as $part => $answers){
            $score = 0;
            
            foreach($answers as $num => $answer){
                $uAnswer = getAnswerByPartAndNumber($data['user-answers'], $part, $num);
                if(strcasecmp($uAnswer, $answer) == 0){
                    $score++;
                }
            }
            
            $data['score'][$part] = array(count($data['test-answers'][$part]) - $score, $score);
        }
        
        $this->view('accounts/finals-result', $data);
    }
    
    public function recordUserFinalTest(){
        $testAnswers = json_decode(file_get_contents(PUBLIC_ROOT . '/data/final-test.json'), true)['Answers'];
        $parts = array_keys($testAnswers);
        $userAnswers = $_POST['answers'];
        $score = 0;
        
        foreach($parts as $part){
            $partUserAnswers = $userAnswers[$part];
            $partTestAnswers = $testAnswers[$part];
            
            for($i = 1; $i <= count($partTestAnswers); $i++){
                if(strcasecmp($partUserAnswers[$i], $partTestAnswers[$i]) == 0){
                    $score++;
                }
                $this->accModel->setUserFinalAnswer($_SESSION['USER_ID'], $part, $i, $partUserAnswers[$i], date('Y-m-d'));
            }
        }
        
        $this->accModel->setUserFinalsScore($_SESSION['USER_ID'], $score, trim($_POST['timeTaken']), date('Y-m-d'));
        
        if($score >= 30){
            $achieveCount = $this->ajaxModel->getUserAchievement($_SESSION['USER_ID'], 8);
            if(!($achieveCount > 0)){
                $this->ajaxModel->setUserAchievement($_SESSION['USER_ID'], 8);
            }
        }
    }
    
    public function setDrillStatus()
    {
        $existingStatus = json_decode(file_get_contents(PUBLIC_ROOT . '/data/drills-status.json'), true);
        $answerStatus = json_decode($_POST['status'], true);
        $drillAnswersCount = count($this->accModel->getDrillAnswer());
        $existingStatus[$_SESSION['USER_ID']] = $answerStatus;
        
        if(count($answerStatus) === $drillAnswersCount){
            $achieveCount = $this->ajaxModel->getUserAchievement($_SESSION['USER_ID'], 7);
            if(!($achieveCount > 0)){
                $this->ajaxModel->setUserAchievement($_SESSION['USER_ID'], 7);
            }
        }
        file_put_contents(PUBLIC_ROOT . '/data/drills-status.json', json_encode($existingStatus));
    }

    //Lessons Post-test Scores Chart
    public function lessonScores()
    {
        $lessons = $this->accModel->getLessons();
        for($i = 0; $i < count($lessons); $i++){
            $postScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $lessons[$i]['LessonID'], "post");
            if(isset($postScore['Score'])){
                $data['postScores'][$i] = $postScore['Score'];
            }
            else{
                $data['postScores'][$i] = 0;
            }

            $preScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $lessons[$i]['LessonID'], "pre");
            if(isset($preScore['Score'])){
                $data['preScores'][$i] = $preScore['Score'];
            }
            else{
                $data['preScores'][$i] = 0;
            }

            $data['lessons'][$i] = $lessons[$i]['LessonNo'];
        }
        
        echo json_encode($data);
    }

    //achievement chart
    public function achievementProgress()
    {
        $userAchieveCount = count($this->accModel->getUserAchievements($_SESSION['USER_ID']));
        $achievementCount = $this->accModel->getAchievementCount();

        $progress = ($userAchieveCount / $achievementCount) * 100;
        
        echo json_encode([ceil($progress), (100 - ceil($progress))]);
    }

    public function lockLesson()
    {
        $lessons = $this->accModel->getLessons();

        for($i = 0; $i < count($lessons); $i++){
            $j = $i + 1;
            if($j == (count($lessons) - 1)){ break; }

            $testScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $lessons[$i]['LessonID'], "post");
            if(!(isset($testScore['Score']) && $testScore['Score'] >= 8)){
                $lessons[$j]['Status'] = "lock";
            }
        }

        $testScore = $this->ajaxModel->getUserScore($_SESSION['USER_ID'], $lessons[count($lessons) - 2]['LessonID'], "post");
        if(!(isset($testScore['Score']) && $testScore['Score'] >= 8)){
            $lessons[$j]['Status'] = "lock";
        }

        return $lessons;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('location: ' . URLROOT . '/users/login');
    }
}