<?php
require_once '../conf/const.php';
require_once '../model/function_user_page.php';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザーページ</title>
    <style>
      #map_box {
        width: 500px;
        height: 300px;
      }
    </style>
</head>
<body>
    <div id="map_box"></div>

    <!-- 上で設定した（入力した）API_KEYをここで出力し、init（イニシャライズ：何かの立ち上げに使われる）関数を実行 -->
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

    <script>
      function init(){
        // $list_itemsを呼び出し
        var list_items = JSON.parse('<?php echo $list_items_json; ?>');
        
        // map_boxで上のdivを受け取る
        var map_box = document.getElementById('map_box');
        // var mapにマップを表示させる
        var map = new google.maps.Map(
          map_box, // 第１引数はマップ表示対象の要素。
          {
            // 第２引数で各種オプションを設定
            center: new google.maps.LatLng(list_items[0]["lat"], list_items[0]["lng"]), // 地図の中心
            zoom: 10, // 拡大のレベルを15に。（1 - 18くらい）
            disableDefaultUI: true, // 各種UIをOFFに
            zoomControl: true, // 拡大縮小だけできるように
            clickableIcons: false, // クリック関連の機能をoffに。
          }
        )
         
        var markers = [];
        for (var list_item of list_items) {
            var marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(list_item["lat"], list_item["lng"])
            });
        }
        
        markers.push(marker);
      }
    </script>
</body>
</html>