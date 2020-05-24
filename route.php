<?php
require_once 'include/conf/const.php';
require_once 'include/model/route_func.php';

$route_id = 1;
$place_list = [];
$post_place_list = [];
$link = get_db_connect();
$errors = [];

// $place_list = select_route($route_id, $link);
// if(empty($place_list) === TRUE){
//     $errors[] = 'route_table取得失敗';
// }
$post_place_list = select_place_list($route_id, $link);
if(empty($post_place_list) === TRUE){
    $errors[] = 'place_list_table取得失敗';
}

$place_list_json = json_encode($post_place_list, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);


include_once 'include/view/route_view.php';