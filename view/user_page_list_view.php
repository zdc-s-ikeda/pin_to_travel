<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>user_page</title>
    <style type="text/css">

        h1 {
            width: 800px;
            border-bottom: solid;
        }
        h2 {
            font-size: 20px;
        }
        
        .header {
            display: flex;
            vertical-align: middle;
        }
        .place {
            display: flex;
        }
        #list {
            width: 800px;
            height: 600px;
            border: solid 1px;
        }
        #map_box {
            width: 800px;
            height: 600px;
        }
        img {
            width: 200px;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <h1 class="header">Pinto Travel</h1>
        <p class="header">ユーザー名：<?php print h($user_info['user_name']); ?></p>
    </div>
    <h2>マイプレイス</h2>
    <div class="place">
        <div id="map_box"></div>
        <div id="list">
            <?php foreach ($places as $place) { ?>
                <p><?php print h($place['place_name']); ?></p>
                <img src="<?php print './image/.' . h($place['img']); ?>">
            <?php } ?>
        </div>
    </div>
    <div class="route">
    <h2>ルート</h2>
        <?php foreach ($route_list as $route) { ?>
            <ul>
                <li><a href="route.php?id=<?=$route['route_id']?>"><?php print h($route['route_name']); ?></li>
            </ul>
        <?php } ?>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
    <script>
      //中心表示
      function init(){
        var shinagawa = {
          lat: 35.6284477,
          lng: 139.7366322
        };
        
        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box, // 第１引数はマップ表示対象の要素。
          {
            // 第２引数で各種オプションを設定
            center: shinagawa, // 地図の中心を品川に
            zoom: 15, // 拡大のレベルを15に。（1 - 18くらい）
            disableDefaultUI: true, // 各種UIをOFFに
            zoomControl: true, // 拡大縮小だけできるように
            clickableIcons: false, // クリック関連の機能をoffに。
          }
        );
      }
    </script>
</body>
</html>