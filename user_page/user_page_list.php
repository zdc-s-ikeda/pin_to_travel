<?php

require_once 'const.php';
require_once 'functions.php';


//ユーザーID取得
// session_start();
// if (isset($_SESSION['user_id']) === TRUE) {
//     $user_id = $_SESSION['user_id'];
// }
$user_id = 2;
$link = get_db_connect();

//ユーザー情報取得
$user_info = get_user_name($link, $user_id);
//これまでポストしたプレイスデータ取得
$places = get_post_place($link, $user_id);
//ルート名の取得
$route_list = get_route_name($link, $user_id);

$places_json = json_encode($places, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);

include_once 'user_page_list_view.php';