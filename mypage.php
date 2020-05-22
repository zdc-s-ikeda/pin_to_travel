<?php

require_once 'include/model/function.php';
require_once 'include/conf/const.php';


//post_places_tableの情報を表示
//db接続
$link = get_db_connect();

//post_places_tableの値を$itemsに格納
$items = get_post_places($link);
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


//db切断
close_db_connect($link);



include_once 'include/view/mypage_view.php';