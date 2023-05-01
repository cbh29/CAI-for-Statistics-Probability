<?php
    include APPROOT . '/views/includes/head.php';
    include APPROOT . '/views/includes/account-nav.php';

    $lesson = $data['lesson'];
    $topics = $data['topics'];
    $images = $data['images'] ?? [];
?>

<link rel="stylesheet" href="<?php echo URLROOT?>/public/css/accounts/lessons.css?v=<?php echo time()?>">

<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<input type="hidden" value="<?php echo $data['page']?>" id="lessonID">

<div class="container">
    <h2 class="title"><?php echo $lesson['LessonNo']?></h2>
    <h6 class="sub-title"><?php echo $lesson['Title']?></h6>

    <?php for($i = 0; $i < count($topics); $i++): ?>
        <div class="lesson-content">
            <?php echo $topics[$i]['Content']?>

            <?php for($j = 0; $j < count($images[$i]); $j++): ?>
                <?php if(isset($images[$i])): ?>
                    <div class="img-content">
                        <img src="<?php echo URLROOT?>/uploads/<?php echo $images[$i][$j]['Image']?>" class="img-thumbnail">
                    </div>
                <?php endif ?>
            <?php endfor; ?>
        </div>
    <?php endfor ?>
    
    <div class="text-end mx-auto" style="max-width:800px;">
        <a href="<?php echo $lesson['Link']?>" target="_blank">Example Video Click here</a>
    </div>
    
    <?php if(empty($data['score'])): ?>
        <button class="cai-button mt-4" id="btnTakePostTest" data-bs-toggle="modal" data-bs-target="#modalPostTestMessage">  
            Take Post Test
        </button>
    <?php elseif($data['score'] < 8): ?>
        <button class="cai-button mt-4" id="btnTakePostTest" data-bs-toggle="modal" data-bs-target="#modalPostTestMessage">  
            Retake Post Test
        </button>
    <?php else:?>
        <p class="text-center mt-5 text-success">Congratulations! You passed the <?php echo $lesson['LessonNo']?>'s 
        Post test. You can now proceed to the next lesson. You can see your test results in the dashboard</p>
    <?php endif;?>
</div>

<!-- Modals -->
<div class="lighthouse">
    <div class="inner-lighthouse mx-sm-auto">
        <i class="fas fa-times"></i>
        <img src="<?php echo URLROOT?>/public/uploads/lesson4-topic1.png" width="100%" class="img-thumbnail">
    </div>
</div>

<div class="modal fade" id="modalMessage" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Welcome to <?php echo $lesson['LessonNo']?></h5>
            </div>
            
            <div class="modal-body">
                <p class="p-0">Welcome to <?php echo $lesson['LessonNo']?> these are the topics that you will expect:</p>
                
                <?php if($lesson['LessonNo'] == "Lesson 1"): ?>
                    <ul>
                        <li>Random Variable</li>
                        <li>The 2 types of random variable</li>
                        <li>Properties of probability distribution</li>
                    </ul>
                <?php elseif($lesson['LessonNo'] == "Lesson 2"): ?>
                    <ul>
                        <li>Mean</li>
                        <li>Variance and Standard Deviation of a Discrete Random Variable</li>
                    </ul>
                <?php elseif($lesson['LessonNo'] == "Lesson 3"): ?>
                    <ul>
                        <li>T Distribution</li>
                    </ul>
                <?php elseif($lesson['LessonNo'] == "Lesson 4"): ?>
                    <ul>
                        <li>The sample size</li>
                    </ul>
                <?php elseif($lesson['LessonNo'] == "Lesson 5"): ?>
                    <ul>
                        <li>Confidence interval</li>
                    </ul>
                <?php endif;?>

                <p>But first, you have to take the pre test for your preparation</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.replace('<?php echo URLROOT?>/accounts/dashboard')">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnContinuePreTests">Continue</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTests" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modalPostTestMessage" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Ready on your post test?</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to take your <?php echo $lesson['LessonNo']?> post test? As soon as you click the start button, the test will begin immediately</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="btnStartPostTest">Start</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTestResults" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>

<script src="<?php echo URLROOT?>/public/js/accounts/lessons.js?v=<?php echo time()?>"></script>
<?php include APPROOT . '/views/includes/foot.php'?>