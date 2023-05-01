<?php include APPROOT . '/views/includes/head.php'?>

<link rel="stylesheet" href="<?php echo URLROOT?>/public/css/users/login.css">

<form action="<?php echo URLROOT?>/users/login" method="POST" id="inputLogin"></form>

<div class="content">
    <a href="<?php echo URLROOT?>/pages/" class="btn-to-home"><i class="fas fa-long-arrow-alt-left pe-1"></i> Back to home</a>

    <div class="login-content">
        <h2>Sign in</h2>
        <span class="text-center d-block text-danger"><?php echo $data['error-login'];?></span>

        <div class="input-container mt-4">
            <div class="input-ic">
                <i class="fas fa-at mx-2"></i>
            </div>
            <input type="text" placeholder="Username" form="inputLogin" name="uName">
        </div>

        <div class="input-container mt-3">
            <div class="input-ic">
                <i class="fas fa-key mx-2"></i>
            </div>
            <input type="password" placeholder="Password" form="inputLogin" name="pass">
        </div>

        <button class="cai-button mt-4" form="inputLogin">Login</button>

        <p class="mt-4">Doesn't have an account yet? <a href="<?php echo URLROOT?>/users/signup">Sign up</a></p>
    </div>
</div>

<?php include APPROOT . '/views/includes/foot.php' ?>