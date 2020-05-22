<?php
//db系
 //db接続
function get_db_connect() {
     if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
         die('error: '. mysqli_connect_error());
     }
     //文字コードセット
     mysqli_set_charset($link, DB_CHARACTER_SET);
     return $link;
 }
 
 //db接続解除
 //データベース接続を解除する
 function close_db_connect($link) {
     mysqli_close($link);
 }
 
 //クエリの実行、結果を配列で取得
 function get_as_array($link, $sql) {
     //返却用配列
     $messages = [];
     //クエリを実行する
     if ($result = mysqli_query($link, $sql)) {
         if (mysqli_num_rows($result) > 0) {
             //1件ずつ取り出す
             while ($row = mysqli_fetch_assoc($result)) {
                 $messages[] =$row;
             }
         }
         mysqli_free_result($result);
     }
     return $messages;
 }
 
 //クエリの実行、結果を行で取得
 function get_as_row($link, $sql) {
     $result = do_query($link, $sql);
     if ($result !== FALSE) {
         $row = mysqli_fetch_assoc($result);
         mysqli_free_result($result);
         return $row;
     }
 }
 
 //クエリ実行
 function do_query($link, $sql) {
     $result = mysqli_query($link, $sql);
     if ($result === FALSE) {
         var_dump('sql失敗' . $sql);
     }
     return $result;
 }

//
//mypage.php
//

//post_places_tableを表示
function get_post_places($link, $sql) {
    $sql = "
        SELECT
            *
        FROM
            post_places_table
        ";
    return get_as_array($link, $sql);
}