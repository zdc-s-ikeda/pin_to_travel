<?php

//ユーザーidからルートidを持ってくる
$sql = "
        SELECT
            route_id
        FROM
            route_table
        WHERE
            user_id = '{$user_id}'
        ";
        
$route_id_array = get_as_array($link, $sql);


//複数のルートidからplace情報を持ってくる
foreach ($route_id_array as $route_id) {
    
    $sql = "
             SELECT
                place_name, img, comment, url
            FROM
                route_table
            JOIN
                place_list_table
            ON
                route_table.route_id = place_list_table.route_id
            JOIN
                post_place_table
            ON
                place_list_table.place_id = post_place_table.place_id
            WHERE
                route_table.route_id = '{$route_id}'
            "
    $place_info_items = get_as_array($link, $sql);
}