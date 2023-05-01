<?php
    include APPROOT . '/views/includes/head.php';
    
    $partI = $data['final-test']['I'];
    $partII = $data['final-test']['II'];
    $partIII = $data['final-test']['III'];
?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/accounts/finals-result.css?v=<?php echo time()?>">

<div class="container py-4">
    <h1 class="text-center" style="color: #4f4f4f;">Final Test Result</h1>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-container">
                <div class="header">
                    <label>Part I</label>
                </div>
                <div class="chart-container">
                    <canvas data-part="I"></canvas>
                    
                    <div class="text-container">
                        <label>100/100</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-container">
                <div class="header">
                    <label>Part II</label>
                </div>
                <div class="chart-container">
                    <canvas data-part="II"></canvas>
                    
                    <div class="text-container">
                        <label>100/100</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card-container">
                <div class="header">
                    <label>Part III</label>
                </div>
                <div class="chart-container">
                    <canvas data-part="III"></canvas>
                    
                    <div class="text-container">
                        <label>100/100</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="test-results mt-5">
        <p class="m-0">Time Taken: <b><?php echo $data['time-taken']?></b></p>
    </div>
    
    <div class="test-results mt-5">
        <h6 class="mb-3">I. IDENTIFICATION</h6>
        
        <?php foreach($partI as $key => $part): ?>
            <?php if($key != "instruct"): ?>
                <?php foreach($part as $n => $p): ?>
                    <?php if($n != "instruct"): ?>
                        
                        <?php $testAnswer = $data['test-answers']['I'][$n] ?>
                        <?php $userAnswer = getAnswerByPartAndNumber($data['user-answers'], "I", $n)?>
                        
                        <div class="d-flex align-items-baseline gap-2 mx-3">
                            <span><?php echo $n?>,</span>
                            <p class="p-0"><?php echo $p['question']?></p>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mx-5">
                            <h6>Answer:</h6>
                            <p class="m-0 <?php echo (strcasecmp($testAnswer, $userAnswer) == 0)? "text-success": "text-danger"?>" ><?php echo $userAnswer?></p>
                        </div>
                        <hr>
                        
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif?>
        <?php endforeach ?>
    </div>
    
    <div class="test-results mt-5">
        <h6 class="mb-3">II. MULTIPLE CHOICE</h6>
        <?php foreach($partII as $key => $question): ?>
            <?php if($key != "instruct"): ?>
                
                <?php $testAnswer = $data['test-answers']['II'][$key] ?>
                <?php $userAnswer = getAnswerByPartAndNumber($data['user-answers'], "II", $key)?>
                
                <div class="d-flex align-items-baseline gap-2 mx-3">
                    <span><?php echo $key?>,</span>
                    <p class="m-0"><?php echo $question['question']?></p>
                </div>
                <?php foreach($question['choices'] as $choice): ?>
                    <div class="input-group mx-auto mt-1" style="max-width: 700px;">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" <?php echo ($userAnswer == $choice) ? "checked" : ""?> disabled>
                        </div>
                        <input type="text" class="form-control <?php echo ($testAnswer == $userAnswer && $userAnswer == $choice) ? "text-success": ""?><?php echo ($testAnswer != $userAnswer && $userAnswer == $choice) ? "text-danger": ""?>" value="<?php echo $choice?>" readonly>
                    </div>
                <?php endforeach ?>
                <hr>
            <?php endif ?>
        <?php endforeach ?>
    </div>
    
    <div class="test-results mt-5">
        <h6 class="mb-3">III. PROBLEM SOLVING</h6>
        
        <h6>Problem 1</h6>
        <p><?php echo $partIII['Problem1']['Problem']?></p>
        
        <?php for($i = 1; $i < count($partIII['Problem1']); $i++): ?>
            <?php $testAnswer = $data['test-answers']['III'][$i] ?>
            <?php $userAnswer = getAnswerByPartAndNumber($data['user-answers'], "III", $i)?>
            
            <div class="d-flex align-items-baseline gap-2 mx-3">
                <span><?php echo $i?>,</span>
                <p class="m-0"><?php echo $partIII['Problem1'][$i]['question']?></p>
            </div>
            <div class="d-flex align-items-baseline gap-2 mx-5">
                <h6>Answer:</h6>
                <p class="m-0 <?php echo (strcasecmp($testAnswer, $userAnswer) == 0)? "text-success": "text-danger"?>"><?php echo $userAnswer?></p>
            </div>
            <hr>
        <?php endfor ?>
        
        <h6>Problem 2</h6>
        <p><?php echo $partIII['Problem2']['Problem']?></p>
        
        <?php for($i = 11; $i <= 20; $i++): ?>
            <?php $testAnswer = $data['test-answers']['III'][$i] ?>
            <?php $userAnswer = getAnswerByPartAndNumber($data['user-answers'], "III", $i)?>
            
            <div class="d-flex align-items-baseline gap-2 mx-3">
                <span><?php echo $i?>,</span>
                <p class="m-0"><?php echo $partIII['Problem2'][$i]['question']?></p>
            </div>
            <div class="d-flex align-items-baseline gap-2 mx-5">
                <h6>Answer:</h6>
                <p class="m-0 <?php echo (strcasecmp($testAnswer, $userAnswer) == 0)? "text-success": "text-danger"?>"><?php echo $userAnswer?></p>
            </div>
            <hr>
        <?php endfor ?>
    </div>
    
    <div class="text-center mt-5">
        <button class="cai-button" style="max-width: 250px" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Dashboard</button>
    </div>
</div>

<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<input type="hidden" value='<?php echo json_encode($data['score'])?>' id="userScores">
<script src="<?php echo URLROOT?>/js/accounts/final-result.js?v=<?php echo time()?>"></script>
<?php
    include APPROOT . '/views/includes/foot.php';
?>