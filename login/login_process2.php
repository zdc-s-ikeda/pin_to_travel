<?php
require_once 'conf/const.php';
require_once 'model/ec_func.php';

if(get_request_method() !== 'POST'){
    redirect_to('login.php');
}
session_start();
$user_name = get_post_data('user_name');
$password = get_post_data('password');

$link = get_db_connect();
$sql = "SELECT
            user_id
        FROM
            ecuser_table
        WHERE
            user_name = '{$user_name}'
        AND
            password = '{$password}'";
$user = [];
$user = get_as_row($link, $sql);
close_db_connect($link);

if(isset($user['user_id']) === true){
    $_SESSION['user_id'] = $user['user_id'];
    if($user_name === 'admin'){
        redirect_to('item_admin.php');
    }
    redirect_to('top.php');
}
$_SESSION['login_error'] = 'ログインに失敗しました';
redirect_to('login.php');