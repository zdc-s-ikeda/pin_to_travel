<?php

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