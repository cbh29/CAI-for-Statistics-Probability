<?php
    include APPROOT . '/views/includes/head.php';
    include APPROOT . '/views/includes/account-nav.php';
    
    $cWordsAnswers = $data['drill-answers'];
    $drillStatus = $data['drill-status'][$_SESSION['USER_ID']] ?? [];
    
    $vertQuestions = $data['vert-question'];
    $horiQuestions = $data['hori-question'];
?>
<link rel="stylesheet" href="<?php echo URLROOT ?>/css/accounts/drills.css?v=<?php echo time()?>">

<div class="table-container">
    <table></table>
</div>

<div class="container questions">
    <div class="vertical w-100">
        <h3>Vertical</h3>
        <ul>
            <?php for($i = 0; $i < count($vertQuestions); $i++): ?>
                <?php $isCorrect = array_search($vertQuestions[$i]['Number'], array_column($drillStatus, "Number"))?>
                
                <li>
                    <?php echo $vertQuestions[$i]['Number']?>,
                    <input type="checkbox" onclick="return false" <?php echo ($isCorrect !== false) ? "checked": ""?>>
                    <?php echo $vertQuestions[$i]['Question']?>
                </li>
            <?php endfor ?>
        </ul>
    </div>
    <div class="horizontal mt-4 mt-lg-0 w-100">
        <h3>Horizontal</h3>
        <ul>
            <?php for($i = 0; $i < count($horiQuestions); $i++): ?>
                <?php $isCorrect = array_search($horiQuestions[$i]['Number'], array_column($drillStatus, "Number"))?>
                
                <li>
                    <?php echo $horiQuestions[$i]['Number']?>,
                    <input type="checkbox" onclick="return false" <?php echo ($isCorrect !== false) ? "checked": ""?>>
                    <?php echo $horiQuestions[$i]['Question']?>
                </li>
            <?php endfor ?>
        </ul>
    </div>
</div>

<div class="check">
    <button class="cai-button" id="btnCheck">Check</button>
</div>

<input type="hidden" value='<?php echo json_encode($drillStatus)?>' id="drillStatus">
<input type="hidden" value='<?php echo json_encode($cWordsAnswers, JSON_NUMERIC_CHECK)?>' id="cWordsAnswers">
<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<script src="<?php echo URLROOT?>/js/accounts/drills.js?v=<?php echo time()?>"></script>
<?php
    include APPROOT . '/views/includes/foot.php';
?>