<?php

require_once '../model/function.php';
require_once '../conf/const.php';

$log = date('Y-m-d h:i:s');
//post_places_tableの情報を表示
//db接続
$link = get_db_connect();

//post_places_tableの値を$itemsに格納
$items = get_post_places($link);
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);


//db切断
close_db_connect($link);


//postされてきた値をリストに追加
if (isset($_POST['place_id']) === TRUE) {
    
    //値を受け取り
    $place_id = get_post('place_id');
    $place_order = get_post('place_order');
    var_dump($place_id);
    //db接続
    $link = get_db_connect();
    
    //ルートリストに場所を追加
    $result = insert_to_place_list_table($link);
    
    //db切断
    close_db_connect($link);
}


include_once '../view/mypage_view.php';