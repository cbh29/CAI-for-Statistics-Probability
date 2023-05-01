<?php include APPROOT . '/views/includes/head.php'?>

<link rel="stylesheet" href="<?php echo URLROOT?>/public/css/users/signup.css?v<?php echo time()?>">

<form action="<?php echo URLROOT?>/users/signup" method="POST" id="formSignUp" enctype="multipart/form-data"></form>

<div class="content">
    <a href="<?php echo URLROOT?>/pages/" class="btn-to-home"><i class="fas fa-long-arrow-alt-left pe-1"></i> Back to home</a>

    <div class="signup-content">
        <h4>Signup</h4>
        
        <div class="img-container">
            <img src="<?php echo URLROOT?>/public/img/profile-placeholder.png" id="imgProfile" width="100%" height="100%">
            <i class="fas fa-camera" id="camera"></i>
            <input type="file" class="d-none" name="inputFile" id="inputFile" form="formSignUp" onchange="document.getElementById('imgProfile').src = window.URL.createObjectURL(this.files[0])">
        </div>
        <span class="text-danger text-center d-block"><?php echo $data['error-img']?></span>
        
        <div class="input-container mt-4">
            <div class="input-ic">
                <i class="far fa-id-card mx-2"></i>
            </div>
            <input type="text" placeholder="Firstname" name="fName" form="formSignUp" value="<?php echo $data['fName']?>">
        </div>
        <span class="text-danger ms-3"><?php echo $data['error-fName']?></span>
        
        <div class="input-container mt-3">
            <div class="input-ic">
                <i class="far fa-id-card mx-2"></i>
            </div>
            <input type="text" placeholder="Lastname" name="lName" form="formSignUp" value="<?php echo $data['lName']?>">
        </div>
        <span class="text-danger ms-3"><?php echo $data['error-lName']?></span>
        
        <div class="input-container mt-3">
            <div class="input-ic">
                <i class="fas fa-at mx-2"></i>
            </div>
            <input type="text" placeholder="Username" name="uName" form="formSignUp" value="<?php echo $data['uName']?>">
        </div>
        <span class="text-danger ms-3"><?php echo $data['error-uName']?></span>
        
        <div class="input-container mt-3">
            <div class="input-ic">
                <i class="fas fa-key mx-2"></i>
            </div>
            <input type="password" placeholder="Password" name="pass" form="formSignUp">
        </div>
        <span class="text-danger ms-3"><?php echo $data['error-pass']?></span>
        
        <div class="input-container mt-3">
            <div class="input-ic">
                <i class="fas fa-key mx-2"></i>
            </div>
            <input type="password" placeholder="Password Confirmation" name="passConfirm" form="formSignUp">
        </div>

        <button class="cai-button mt-4" form="formSignUp">Create my account</button>

        <p class="mt-4">Already have an account? <a href="<?php echo URLROOT?>/users/login">Sign in</a></p>
    </div>
</div>

<script src="<?php echo URLROOT?>/public/js/users/signup.js?<?php echo time()?>"></script>

<?php include APPROOT . '/views/includes/foot.php'?>