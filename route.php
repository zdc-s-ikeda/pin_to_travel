<?php
require_once 'include/conf/const.php';
require_once 'include/model/route_func.php';

$mylist_id = 1;
$place_list = [];

$link = get_db_connect();

$place_list = select_route($mylist_id, $link);
if(empty($item_list) === TRUE){
    $errors[] = 'route_table取得失敗';
}
$place_list_json = json_encode($place_list, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

close_db_connect($link);


include_once 'include/view/route_view.php';