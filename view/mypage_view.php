<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <style>
      #map_box {
        width: 800px;
        height: 600px;
      }
    </style>
</head>
<body>
    <p>
      <label>住所を検索: <input type="text" id="address"></label>
      <button id="search">検索</button>
    </p>
    <p id="search_result"></p>
    <div id="map_box"></div>
    
    <navigation>
    <li><a href="">プレイス</a></li>
    <li><a href="">リスト</a></li>
    <li><a href="">お気に入り</a></li>
    <li><a href="">共有</a></li>
    </navigation>
    
    <div>
      <?php foreach ($items as $item) { ?>
        <form method="post" action="mypage.php">
          <li>
          <label><?php print h($item['place_name']) ?>
          <input type="submit" value="リストに追加">
          <input type="text" name="place_order">
          <input type="hidden" name="place_id" value="<?php print h($item['place_id']); ?>">
          </label>
          </li>
      <?php } ?>
      </form>
    </div>

    

    <script>
      function init(){
        var yokohama = {
          lat: 35.4657901,
          lng: 139.6201245
        };
        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box,
          {
            center: yokohama,
            zoom: 15,
            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        )
        
    
        
        // ジオコーダーの生成
        var geocoder = new google.maps.Geocoder();
        document.getElementById('search')
        .addEventListener(
        'click',
        function(){
              geocoder.geocode(
                // 第一引数にジオコーディングのオプションを設定
                {
                  address: document.getElementById('address').value
                },
                // 第二引数に結果取得時の動作を設定
                function(results, status){
                  // 失敗時の処理
                  if(status !== 'OK'){
                    alert('ジオコーディングに失敗しました。結果: ' + status);
                    return;
                  }
                  // 成功した場合、resultsの0番目に結果が取得される。
                  if(!results[0]){
                    alert('結果が取得できませんでした');
                    return;
                  }
                  // マップの中心を移動
                  //スクロールする
                  map.panTo(results[0].geometry.location);
                  
                //formatted_address 書式が整えられた住所の情報
                  document.getElementById('search_result').innerHTML = results[0].formatted_address;
                }
              );
            }
          );
          
          
          // クリック位置をリバースジオコーディング
            map.addListener('click', function(e){
              geocoder.geocode({
                location: e.latLng
              }, function(results, status){
                if(status !== 'OK'){
                  alert('リバースジオコーディングに失敗しました。結果: ' + status);
                  return;
                }
            
                // console.log(results);
                if(!results[0]){
                  alert('結果が取得できませんでした。');
                  return;
                }
            
                // クリックした位置にマーカーを立てる
                var added_marker = new google.maps.Marker({
                  position: e.latLng, // クリックした箇所
                  map: map,
                  animation: google.maps.Animation.DROP,
                  title: results[0].formatted_address
                });
                // マーカーに情報ウィンドウを紐付け、
                // リバースジオコーディングで取得した住所を表示する。
               
                var infoWindow = new google.maps.InfoWindow({
                  content: 'ここに情報を表示'
                });
                
                infoWindow.open(map, added_marker);
                
                //document.getElementById('searched_address').value = results[0].formated...
              })
            });
            
              //$itemsをjs形式で呼び出し
            var items = JSON.parse('<?php echo $items_json; ?>');
            var markers = [];
            //for (var i = 0; i < items.length; i++) {
              //var item = items[i];
            for (var item of items) {
              
              var added_marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(item["lat"],item["lng"])
              });
              var added_info_window = new google.maps.InfoWindow({
                content: item['comment'] + '<br>' + item['img']
              });
              
              added_info_window.open(map, added_marker);
              
              markers.push(added_marker);
            }
            
         
          
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
</body>
</html>