<?php

class Jsons extends Controller{
    
    public function __construct()
    {
        $this->jsonModel = $this->model('Json');
    }

    public function scoreRowCount($lessonID)
    {
        echo $this->jsonModel->findScore($lessonID, $_SESSION['USER_ID']);
    }
    
    public function secondDrillQuestion($drillID = 1){
        $imgData = $this->jsonModel->getSecondDrillImages($drillID);
        
        $answer = $this->jsonModel->getSecondDrillAnswer($drillID)['Answer'];
        $imgData['Answer'] = explode(" ", $answer);
        
        echo json_encode($imgData);
    }

}