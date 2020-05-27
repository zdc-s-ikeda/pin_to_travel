<?php

require_once '../model/function_user_page.php';
require_once '../conf/const.php';


session_start();
if(isset($_SESSION['user_id']) === false){
    redirect_to('login.php');
}
$user_id = $_SESSION['user_id'];

// JOINでつなげたテーブルの情報を表示
// db接続
$link = get_db_connect();

$list_items = get_list($link);
// js形式に変換
$list_items_json = json_encode($list_items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
//var_dump($list_items);

//db切断
close_db_connect($link);

include_once '../view/user_page_view.php';