<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>user_page</title>
    <style type="text/css">
        h1 {
            border-bottom: solid;
        }
        h2 {
            font-size: 20px;
        }
        #user_info {
            width: 800px;
            height: 100px;
            border: solid 1px;
        }
        #list {
            width: 800px;
            height: 500px;
            border: solid 1px;
        }
        #map {
            width: 800px;
            height: 300px;
            border: solid 1px;
        }
        img {
            width: 200px;
        }
        
    </style>
</head>
<body>
    <h1>Pinto Travel</h1>
    <div id="user_info">
        <p>ユーザー情報</p>
        
    </div>
    <div id="place">
    <h2>マイプレイス</h2>
        <div id="map">map</div>
        <div id="list">
        <?php foreach ($places as $place) { ?>
            <p><?php print h($place['place_name']); ?></p>
            <img src="<?php print './image/.' . h($place['img']); ?>">
        <?php } ?>
        </div>
    </div>
    <div id="route">
    <h2>ルート</h2>
        <?php foreach ($route_list as $route) { ?>
            <ul>
                <li><a href="route.php?id=<?=$route['route_id']?>"><?php print h($route['route_name']); ?></li>
            </ul>
        <?php } ?>
    </div>
</body>
</html>