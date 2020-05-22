<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

function is_post(){
    return $_SERVER['REQUEST_METHOD'] === TRUE;
}

//DBハンドル取得
function get_db_connect() {
 
    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
 
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
 
    return $link;
}

//直前のクエリで生成したIDを取得
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

//queryの実行
function result_query($link, $sql){
    return mysqli_query($link, $sql);
}

//クエリを実行しその結果を配列で取得する
function get_as_array($link, $sql){
    // 返却用配列
    $data = [];
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
        // １件ずつ取り出す
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    return $data;
}

//クエリを実行しその結果を配列(1行)で取得する
function get_as_row($link, $sql){
    if($result = mysqli_query($link, $sql)){
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row;
    }
    return [];
}

//変数確認
function dd($var){
  var_dump($var);
  exit();
}

//route_table select
function select_route($mylist_id,$link){
    $sql = "SELECT
                lat,
                lng,
                route_order
            FROM
                route_table
            WHERE
                mylist_id = '{$mylist_id}'
            ORDER BY 
                route_order";
    return get_as_array($link, $sql);
    
}

//place_list_table select
function select_place_list($mylist_id, $link){
    $sql = "SELECT
                place_name,
                comment,
                img,
                status,
                lat,
                lng,
                url,
                mylist_name,
                place_list_table.post_places_id,
                place_order,
                mylist_table.mylist_id
            FROM
                place_list_table
            JOIN
                post_places_table
            ON
                place_list_table.post_places_id = post_places_table.post_places_id
            JOIN
                mylist_table
            ON
                place_list_table.mylist_id = mylist_table.mylist_id
            WHERE
                place_list_table.mylist_id = '{$mylist_id}'
            ORDER BY
                place_order";
    return get_as_array($link, $sql);
}

function delete_place($post_place_id, $link){
    $sql = "DELETE FROM
                mylist_table
            WHERE
                post_place_id = {$post_place_id}";
    return result_query($link, $sql);
}

function update_place($post_place_id, $place_order, $link){
    $sql = "UPDATE
                place_list_table
            SET
                place_order = '{$place_order}'
            WEHRE
                post_place_id = '{$post_place_id}'";
    return result_query($link, $sql);
}

function is_post(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_blank($value){
    return $value === '';
}

function get_post($name){
    if (isset($_POST[$name]) === TRUE){
        return trim($_POST[$name]);
    }
    return '';
}