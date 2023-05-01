<?php
    include APPROOT . '/views/includes/head.php';
    
    $finals = $data['finals-data'];
    $lastLessonScore = $data['lesson-five-score'];
    $prevFinalsScore = $data['prev-finals-score'];
?>
<link rel="stylesheet" href="<?php echo URLROOT . "/css/accounts/finals.css?v=" . time()?>">

<div class="container-fluid">
    <div class="finals-container py-3">
        <p class="text-end m-0" id="timer">
            <span id="minutes">00</span>:<span id="seconds">00</span>
        </p>    
    
        <div class="I">
            <label class="part">I. <?php echo $finals['I']['instruct']?></label>
            <p class="instruction">A. <?php echo $finals['I']['A']['instruct']?></p>
            <ul>
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <li>
                        <div class="question-container">
                            <span><?php echo $i?>, </span>
                            <?php echo $finals['I']['A'][$i]['question'] ?>
                        </div>
                        <div class="input-group input-group-sm mt-1 mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Answer</span>
                            <input type="text" class="form-control" data-part="I" data-num="<?php echo $i?>">
                        </div>
                    </li>
                <?php endfor ?>
            </ul>
            
            <p class="instruction mt-4">B. <?php echo $finals['I']['B']['instruct']?></p>
            <ul>
                <?php for($i = 6; $i <= 10; $i++): ?>
                    <li>
                        <div class="question-container">
                            <span><?php echo $i?>, </span>
                            <?php echo $finals['I']['B'][$i]['question'] ?>
                        </div>
                        <div class="input-group input-group-sm mt-1 mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Answer</span>
                            <input type="text" class="form-control" data-part="I" data-num="<?php echo $i?>">
                        </div>
                    </li>
                <?php endfor ?>
            </ul>
        </div>
        
        <div class="II mt-5">
            <label class="part">I. <?php echo $finals['II']['instruct']?></label>
            <ul class="mt-3">
                <?php for($i = 1; $i < count($finals['II']); $i++): ?>
                    <li class="mt-4">
                        <div class="question-container">
                            <span><?php echo $i?>, </span>
                            <?php echo $finals['II'][$i]['question'] ?>
                        </div>
                        <?php if(isset($finals['II'][$i]['img'])): ?>
                            <img src="<?php echo URLROOT?>/uploads/<?php echo $finals['II'][$i]['img']?>" class="mx-auto d-block">
                        <?php endif ?>
                        <?php for($j = 0; $j < count($finals['II'][$i]['choices']); $j++): ?>
                            <div class="input-group mt-1">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" data-part="II" data-num="<?php echo $i?>" type="radio" name="<?php echo $i?>" value="<?php echo $finals['II'][$i]['choices'][$j]?>">
                                </div>
                                <input type="text" class="form-control" value="<?php echo $finals['II'][$i]['choices'][$j]?>" readonly>
                            </div>
                        <?php endfor ?>
                    </li>
                <?php endfor ?>
            </ul>
        </div>
        
        <div class="III mt-5">
            <label class="part">III. <?php echo $finals['III']['instruct']?></label>
            
            <div class="sticky-top p-2 my-3 border" style="background: blue; border-radius: 10px; background-color: #d37bce; color: #ffffff;">
                <label class="part">Problem 1</label>
                <p class="m-0" style="text-indent: 30px;"><?php echo $finals['III']['Problem1']['Problem']?></p>
            </div>
            
            <ul>
                <?php for($i = 1; $i <= 10; $i++): ?>
                    <li>
                        <div class="question-container">
                            <span><?php echo $i?>, </span>
                            <div>
                                <?php echo $finals['III']['Problem1'][$i]['question'] ?>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mt-1 mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Answer</span>
                            <input type="text" class="form-control" data-part="III" data-num="<?php echo $i?>">
                        </div>
                    </li>
                <?php endfor ?>
            </ul>
            
            <div class="sticky-top p-2 mb-3 mt-5 border" style="background: blue; border-radius: 10px; background-color: #d37bce; color: #ffffff;">
                <label class="part">Problem 2</label>
                <p class="m-0" style="text-indent: 30px;"><?php echo $finals['III']['Problem2']['Problem']?></p>
            </div>
            
            <ul>
                <?php for($i = 11; $i <= 20; $i++): ?>
                    <li>
                        <div class="question-container">
                            <span><?php echo $i - 10?>, </span>
                            <div>
                                <?php echo $finals['III']['Problem2'][$i]['question'] ?>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mt-1 mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Answer</span>
                            <input type="text" class="form-control" data-part="III" data-num="<?php echo $i?>">
                        </div>
                    </li>
                <?php endfor ?>
            </ul>
        </div>

        <div class="opt-button">
            <div class="btn-container">
                <button class="btn-exit" id="btnCancelFinals">Cancel</button>
            </div>
            <div class="btn-container">
                <button class="cai-button" id="btnSubmitFinals">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="message" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reminder</h5>
            </div>
            <div class="modal-body">
                <?php if($lastLessonScore < 8): ?>
                    <p>Before taking the final test, you have to pass the post test of lesson 5</p>
                <?php else:  ?>
                    <?php if(isset($prevFinalsScore['CreatedAt'])): ?>
                        <?php if($prevFinalsScore['CreatedAt'] == date('Y-m-d')): ?>
                            <p class="m-0">You are not allowed to take the final test twice in a day.</p>
                            <p class="m-0">Previous Score: <b><?php echo $prevFinalsScore['Score']?></b></p>
                            <p>Date Taken: <b><?php echo $prevFinalsScore['CreatedAt']?></b></p>
                            
                        <?php elseif($prevFinalsScore['Score'] < 30): ?>
                            <p class="m-0">You can now take the final test<?php $prevFinalsScore['Score']?></p>
                            <p class="m-0">Previous Score: <b><?php echo $prevFinalsScore['Score']?></b></p>
                            <p>Date Taken: <b><?php echo $prevFinalsScore['CreatedAt']?></b></p>
                        <?php endif ?>
                    
                    <?php else: ?>
                        <p>You are about to take the final test which will be devided into 3 parts these are
                        <b>IDENTIFITCATION, MULTIPLE CHOICE, PROBLEM SOLVING</b></p>
                        
                        <p>The system will record the time you have taken while taking the final test</p>
                        
                        <p>The passing score of the final test is <span class="text-success">30 above</span>.
                        If your score did not reach 30 and above, you can retake the final test.</p>
                        
                        <p>You are only allowed to take/retake the final test once a day.</p>
                        
                        <p>If you reach the passing score, you will get a certificate that you have passed the Statistics & Probability course</p>
                        
                        <p class="text-center"><b>Click Start to begin your final test. Good Luck!</b></p>
                        
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <?php if($lastLessonScore < 8): ?>
                    <button class="btn btn-secondary" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Okay</button>
                <?php else:  ?>
                    <?php if(isset($prevFinalsScore['CreatedAt'])): ?>
                        <?php if($prevFinalsScore['CreatedAt'] == date('Y-m-d')): ?>
                            <button class="btn btn-secondary" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Okay</button>
                        <?php elseif($prevFinalsScore['Score'] < 30): ?>
                            <button class="btn btn-secondary" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Cancel</button>
                            <button type="button" id="btnStartTest" class="btn text-light" style="background: #d37bce;">Start</button>
                        <?php endif ?>
                    <?php else: ?>
                        <button class="btn btn-secondary" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Cancel</button>
                        <button type="button" id="btnStartTest" class="btn text-light" style="background: #d37bce;">Start</button>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<script src="<?php echo URLROOT . "/js/accounts/finals.js?v=" . time() ?>"></script>
<?php
    include APPROOT . '/views/includes/foot.php';
?>