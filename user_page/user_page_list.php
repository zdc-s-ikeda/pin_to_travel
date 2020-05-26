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

//ユーザーIDでルートIDを持ってくる
$route_id_array = get_route_id($link, $user_id);

//これまでポストしたデータをルートごとに取得
foreach ($route_id_array as $route_id) {
    $places = get_route_place($link, $route_id);
}

$places_json = json_encode($places, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);

include_once 'user_page_list_view.php';