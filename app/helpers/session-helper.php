<?php

session_start();

function isLoggedIn()
{
    if(isset($_SESSION['USER_ID'])){
        return true;
    }
    else{
        return false;
    }
}