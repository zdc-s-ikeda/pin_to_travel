<?php
require_once 'include/conf/const.php';
require_once 'include/model/route_func.php';



if(is_post() === true){

    $post_place_id = get_post('post_place_id');
    $mylist_id = get_post('mylist_id');

    if($post_place_id !== ''){
        $link = get_db_connect();
        if(delete_place($post_place_id, $mylist_id, $link) === false){
            close_db_connect($link);
            exit('場所の削除に失敗しました。');
        }
        close_db_connect($link);
    }
}


redirect_to('route.php');