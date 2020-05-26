<?php
require_once '../conf/const.php';
require_once '../model/route_func.php';



if(is_post() === true){

    $place_id = get_post('place_id');
    $route_id = get_post('route_id');

    if($place_id !== ''){
        $link = get_db_connect();
        if(delete_place($place_id, $route_id, $link) === false){
            close_db_connect($link);
            exit('場所の削除に失敗しました。');
        }
        close_db_connect($link);
    }
}


redirect_to('route.php');
