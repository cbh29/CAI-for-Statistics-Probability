<div class="modal-header">
    <h5><?php echo ucfirst($data['type'])?> - Test Result</h5>
</div>

<div class="modal-body">
    <?php
        $score = $data['score'];
        $items = $data['items'];
        $passing = ceil($items / 2);
    ?>

    <h5>Score</h5>
    <div class="chart-container">
        <canvas id="myChart"></canvas>

        <div class="text-container">
            <span><?php echo $data['score'] . "/" . $data['items']?></span>
        </div>
    </div>

    <?php if($passing > $score && $data['type'] == "post"): ?>
        <p class="small text-danger">It seems that you failed your <?php echo $data['lessonNo']?>'s Post test.
        Kindly pass this post test to access the next lesson. You can always review the lesson and retake this test.</p>
    <?php endif ?>

    <h5 class="mt-3">Result</h5>
    <div class="result-container">
        <?php $userAnswers = $data['userAnswers']?>
        <?php for($i = 0; $i < count($userAnswers); $i++): ?>
            <div class="question">
                <p class="m-0"><?php echo $userAnswers[$i]['Question']?></p>

                <?php if(strlen($userAnswers[$i]['Image']) > 0): ?>
                    <img src="<?php echo URLROOT?>/public/uploads/<?php echo $userAnswers[$i]['Image']?>" width="100%">
                <?php endif ?>
            </div>
            <div class="d-flex justify-content mb-4">
                <div class="answer">
                    <label>Answer</label>
                    <label class="<?php echo ($userAnswers[$i]['ChoiceID'] == $data['testAnswers'][$i]['Answer']) ? "text-success" : "text-danger"?>">
                        <?php echo $userAnswers[$i]['Choice']?>
                    </label>
                </div>
                <div class="answer">
                    <label>Correct Answer</label>
                    <label><?php echo $data['testAnswers'][$i]['Choice']?></label>
                </div>
            </div>
        <?php endfor?>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" id="btnProceedToLesson">
        <?php if($data['type'] == "post"): ?>
            Okay
        <?php else: ?>
            Proceed to Lesson
        <?php endif ?>
    </button>
</div>

<input type="hidden" value="<?php echo $data['items']?>" id="items">
<input type="hidden" value="<?php echo $data['score']?>" id="score">
<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">

<script>
    $.getScript($('#urlroot').val() + '/public/js/ajaxes/testResult.js');
</script>