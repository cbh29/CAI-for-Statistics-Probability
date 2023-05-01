<?php
    $lessons = $data['lessons'];
    $profile = $data['profile'];
?>

<style class="nav-style"></style>

<link rel="stylesheet" href="<?php echo URLROOT ?>/public/css/account-nav.css?v=<?php echo time()?>">

<nav>
    <div class="btn-menu">
        <i class="fas fa-bars"></i>
    </div>

    <div class="profile-container">
        <i class="fas fa-user"></i>
        <img src="<?php echo URLROOT?>/uploads/<?php echo $profile['Image']?>" class="rounded-circle" width="35px" height="35px">
    </div>
</nav>

<div class="aside-shadow">
</div>

<aside class="px-4 py-3">
    <img src="<?php echo URLROOT?>/public/img/img_logo.jpg" width="80px" class="mx-auto d-block img-thumbnail">

    <label>Menu</label>
    <div class="menu">
        <ul>
            <li>
                <a class="<?php echo ($data['page'] == "dashboard") ? "active": ""?>" href="<?php echo URLROOT?>/accounts/dashboard"><i class="far fa-chart-bar"></i>Dashboard</a>
            </li>
            <li>
                <a class="<?php echo ($data['page'] == "finals") ? "active" : ""?>" href="<?php echo URLROOT?>/accounts/finals"><i class="fas fa-scroll"></i>Final Test</a>
            </li>
        </ul>
    </div>
    
    <label>Drills</label>
    <div class="menu">
        <ul>
            <li>
                <a class="<?php echo ($data['page'] == "drills") ? "active": ""?>" href="<?php echo URLROOT?>/accounts/drills"><i class="fas fa-puzzle-piece"></i>Crossword</a>
            </li>
            <li>
                <a class="<?php echo ($data['page'] == "secondDrills") ? "active": ""?>" href="<?php echo URLROOT?>/accounts/secondDrills"><i class="fas fa-puzzle-piece"></i>4 Pics 1 Word</a>
            </li>
        </ul>
    </div>

    <label>Lessons</label>
    <div class="lesson">
        <ul>
            <?php for($i = 0; $i < count($lessons); $i++): ?>
                <li>
                    <a class="<?php echo ($data['page'] == $lessons[$i]['LessonID']) ? "active" : ""?> <?php echo (isset($lessons[$i]['Status'])) ? "disabled" : ""?>"
                        href="<?php echo URLROOT?>/accounts/lessons/<?php echo $lessons[$i]['LessonID']?>">
                        <?php echo (isset($lessons[$i]['Status'])) ? '<i class="fas fa-lock"></i>' : ""?>
                        <?php echo $lessons[$i]['LessonNo']?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</aside>

<div class="profile">
    <div class="inner-profile">
        <div class="img-container">
            <img src="<?php echo URLROOT?>/uploads/<?php echo $profile['Image']?>" width="100%" height="100%">
        </div>
        <h4 class="text-center text-light mt-1"><?php echo $profile['Firstname'] . " " . $profile['Lastname']?></h4>

        <?php if($data['is-passed']): ?>
            <div class="certificate rounded-2">
                <img src="<?php echo URLROOT?>/img/img_logo.jpg" width="50px" class="mx-auto d-block rounded-2">
                <h6 class="text-center">Certificate of Completion</h6>
                
                <p class="text-center mb-0" style="font-size: 12px;">This certifies that</p>
                <h5 class="text-center mb-0"><?php echo $profile['Firstname'] . " " . $profile['Lastname']?></h5>
                <p class="text-center mb-2" style="font-size: 10px;">Has successfully completed the online learning program, entitled: </p>
                
                <h6 class="text-center m-0" style="font-size: 14px;">Computer Aided Instruction</h6>
                <h6 class="text-center m-0" style="font-size: 14px;">(Statistics and Probability)</h6>
            </div>
            
            <div class="text-center">
                <a href="" id="btnDownloadCert" class="btn btn-link">download certificate here</a>
            </div>
        <?php endif ?>
        
        <form action="<?php echo URLROOT?>/accounts/logout">
            <button class="cai-button">Logout</button>
        </form>
    </div>
</div>

<div class="cert-paper" id="passerCert">
    <img src="<?php echo URLROOT?>/img/img_logo.jpg" width="120px" class="mt-5 mx-auto d-block rounded-2">
    
    <h1 class="text-center mt-4" style="font-size: 52px;">Certificate of Completion</h1>
            
    <p class="text-center mb-0 mt-4" style="font-size: 24px;">This certifies that</p>
    <h1 class="text-center m-0" style="font-size: 52px;"><?php echo $profile['Firstname'] . " " . $profile['Lastname']?></h1>
    <p class="text-center mb-2" style="font-size: 20px;">Has successfully completed the online learning program, entitled: </p>
    
    <h6 class="text-center m-0" style="font-size: 30px;">Computer Aided Instruction</h6>
    <h6 class="text-center m-0" style="font-size: 26px;">(Statistics and Probability)</h6>
</div>

<script src="<?php echo URLROOT?>/public/js/account-nav.js?v=<?php echo time()?>"></script>