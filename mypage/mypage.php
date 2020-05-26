<?php

require_once '../model/function.php';
require_once '../conf/const.php';

//変数の定義
$route_id = 1;
$errors = [];
$messages = [];


//post_places_tableの情報を表示
//db接続
$link = get_db_connect();

//post_places_tableの値を$itemsに格納
$items = get_post_places($link);
//$itemsをjs形式に変換(itemsには、name, comment, imgが一つずつ入っている)
$items_json = json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

//リストに格納されたアイテムの表示
$list_items = get_list($link);

//db切断
close_db_connect($link);


//postされてきた値をリストに追加
if (is_post() === TRUE) {
    
    //値を受け取り
    $place_id = get_post('place_id');
    $place_order = get_post('place_order');
    var_dump($_POST);
    //db接続
    $link = get_db_connect();
    
    //ルートリストに場所を追加
    $result = insert_to_place_list_table($link, $place_id, $place_order, $route_id);
    
    if ($result === FALSE) {
        $errors[] = 'リストに追加失敗';
    } else {
        $messages[] = 'リストに追加成功';
    }
    
    
    //db切断
    close_db_connect($link);
}


include_once '../view/mypage_view.php';