<?php
    include APPROOT . '/views/includes/head.php';
    include APPROOT . '/views/includes/account-nav.php';
?>

<link rel="stylesheet" href="<?php echo URLROOT?>/public/css/accounts/dashboard.css?v=<?php echo time()?>">

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dash-card">
                <h5 class="title">Lessons Taken</h5>
                <div class="content">
                    <h1 class="text-center"><?php echo $data['noLessonsTaken'] . "/" . count($data['lessons'])?></h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dash-card">
                <h5 class="title">Drill Score</h5>
                <div class="content">
                    <h1 class="text-center" id="drillScore">0</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="dash-card">
                <h5 class="title">Final Test Score</h5>
                <div class="content">
                    <h1 class="text-center"><?php echo $data['final-test-score']?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Post test scores chart -->
        <div class="col-12">
            <div class="chart-card">
                <div class="header">
                    <h5 class="title">Pre test and Post test score</h5>
                </div>
                <div class="content">
                    <canvas id="testsChart" class="mx-xl-5"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="chart-card">
                <div class="header">
                    <h5 class="title">Final Test Score Attempts</h5>
                </div>
                <div class="content">
                    <canvas id="finalTestChart" class="mx-lg-5"></canvas>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="col-12 col-xl-8">
            <div class="chart-card">
                <div class="header">
                    <h5 class="title">Acquired Achievements</h5>
                </div>
                <div class="content">
                    <?php $achieves = $data['achievements'] ?>
                    <?php if(isset($achieves[0])):?>
                        <div class="accordion accordion-flush achievements mt-0" id="accordionFlushExample">
                            <?php for($i = 0; $i < count($achieves); $i++): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ach<?php echo $achieves[$i]['AchievementID']?>">
                                            <?php echo $achieves[$i]['Title']?>
                                        </button>
                                    </h2>
                                    <div id="ach<?php echo $achieves[$i]['AchievementID']?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <p class="p-0 m-0" style="font-weight: 400;"><?php echo $achieves[$i]['Description']?></p>
                                            <small class="text-muted">
                                                Date Acquired: <?php echo date("M j, Y, g:i a", strtotime($achieves[$i]['CreatedAt']))?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted p-3 p-sm-0">No achievements available</p>
                    <?php endif?>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="chart-card">
                <div class="header">
                    <h5 class="title">Achievement Progress</h5>
                </div>
                <div class="content p-3" id="achievementProgress">
                    <canvas style="max-height: 200px">
                    </canvas>
                    <div class="text-container">
                        <h1 class="m-0 p-0"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value='<?php echo json_encode($data['final-test-attempts'])?>' id="finalTestAttempts">
<input type="hidden" value="<?php echo $_SESSION['USER_ID']?>" id="userID">
<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<script src="<?php echo URLROOT?>/public/js/accounts/dashboard.js?v=<?php echo time()?>"></script>
<?php include APPROOT . '/views/includes/foot.php'?>