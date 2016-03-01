<?php
session_start();

function signout() {
    if(session_id() == '') session_start();
    session_unset();
    session_destroy();
}

function checkLogin(){
    if(!isset($_SESSION['UID']) || $_SESSION['UID'] == false){
        header('Location: /SmartClerk/login.php');
        exit();
    }
}