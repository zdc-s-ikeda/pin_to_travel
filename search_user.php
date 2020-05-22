<?php

require_once 'const.php';
require_once 'functions.php';

$errors = [];
$searched_user = [];
$user_name = '';
$request_method = get_request_method();

if ($request_method === 'POST') {
    $user_name = get_post_data('user_name');
    if (is_blank($user_name) === TRUE) {
        $errors[] = 'ユーザー名未入力';
    }
}
dd($errors);

$link = get_db_connect();
if (count($errors) === 0) {
    $sql = "SELECT 
                user_id,user_name
            FROM
                users_table
            WHERE
                user_name
            LIKE
                '%$user_name%'";
    $result = mysqli_query($link, $sql);
    if ($result !== false) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searched_user[] = $row;
        }
        mysqli_free_result($result);
    }
    close_db_connect($link);
} else {
    $errors[] = '接続失敗';
}
// dd($searched_user);

include_once 'search_user_view.php';
