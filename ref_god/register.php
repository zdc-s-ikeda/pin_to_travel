<?php
require_once 'conf/const.php';
require_once 'model/ec_func.php';

$errors = [];
$success = '';
$user_name = '';
$password = '';
$request_method = get_request_method();
$log = set_time();
if($request_method === 'POST'){
    $user_name = get_post_data('user_name');
    if(is_blank($user_name) === true){
        $errors[] = 'ユーザー名を入力してください';
    }else if(is_match($user_name, 6) !== true){
        $errors[] = 'ユーザー名は6字以上の半角英数字で入力してください';
    }
    $password = get_post_data('password');
    if(is_blank($password) === true){
        $errors[] = 'パスワードを入力してください';
    }else if(is_match($password, 6) !== true){
        $errors[] = 'パスワードは6字以上の半角英数字で入力してください';
    }
    $link = get_db_connect();
    if(count($errors) === 0){
        //同名アカウント存在確認
        if(check_name($user_name, $link) === []){
            //ecuser_table追加
            if(insert_user($user_name, $password, $log, $link) === FALSE){
                $errors[] = 'ecuser_table追加失敗';
            }else{
                $success = '新規登録しました';
            }
        }else{
            $errors[] = '登録失敗しました。同名アカウントが存在しています。';
        }
    }
    close_db_connect($link);
}

include_once 'view/register_view.php';