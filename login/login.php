<?php
require_once '../conf/const.php';
require_once '../model/ec_func.php';

session_start();
if(isset($_SESSION['user_id']) === TRUE){
    //ログイン済みならトップページへ
    redirect_to('top.php');
}

$errors = [];
if(isset($_SESSION['login_error']) === TRUE){
    $errors[] = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

include_once '../view/login_view.php';