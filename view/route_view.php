<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイルート</title>
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
      <h2>一覧</h2>
      <?php if(count($post_place_list) > 0){ ?>
        <table>
            <thead>
                <tr>
                    <th>場所名</th>
                    <th>コメント</th>
                    <th>URL</th>
                    <th>表示</th>
                    <th>順番</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($post_place_list as $place){ ?>
                    <tr>
                        <td><?php echo h($place['place_name']); ?></td>
                        <td><?php echo h($place['comment']); ?></td>
                        <td><a href="<?php echo h($place['url']); ?>"><?php echo h($place['url']); ?></a></td>
                        <td>
                            <button
                                class="display"
                                data-lat="<?php echo h($place['lat']);?>"
                                data-lng="<?php echo h($place['lng']);?>"
                                data-name="<?php echo h($place['place_name']); ?>">
                                表示
                            </button>
                        </td>
                        <td>
                          <form method="post" action="../route/place_order.php">
                            <div>
                              <input type="number" name="place_order" value="<?php echo h($place['place_order']); ?>">
                              <input type="hidden" name="place_id" value="<?php echo h($place['place_id']); ?>">
                              <input type="hidden" name="route_id" value="<?php echo h($place['route_id']); ?>">
                              <input type="submit" value="変更">
                            </div>
                          </form>
                        </td>
                        <td>
                          <form method="post" action="../route/place_list_delete.php">
                            <input type="hidden" name="place_id" value="<?php echo h($place['place_id']); ?>">
                            <input type="hidden" name="route_id" value="<?php echo h($place['route_id']); ?>">
                            <input type="submit" value="削除">
                          </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>登録された場所はありません。</p>
    <?php } ?>
    </form>
    <li><a href="../mypage/mypage.php">マイページ</a></li>
    <li><a href="">リスト</a></li>
    <li><a href="">お気に入り</a></li>
    <li><a href="">共有</a></li>
    

    <script>
      function init(){
        var place_list = JSON.parse('<?php echo $place_list_json; ?>');
        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box,
          {
            center: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
            zoom: 12,
            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        );
        // // ジオコーダーの生成
        // var geocoder = new google.maps.Geocoder();
        // document.getElementById('search')
        //   .addEventListener(
        //     'click',
        //     function(){
        //       geocoder.geocode(
        //         // 第一引数にジオコーディングのオプションを設定
        //         {
        //           address: document.getElementById('address').value
        //         },
        //         // 第二引数に結果取得時の動作を設定
        //         function(results, status){
        //           // 失敗時の処理
        //           if(status !== 'OK'){
        //             alert('ジオコーディングに失敗しました。結果: ' + status);
        //             return;
        //           }
        //           // 成功した場合、resultsの0番目に結果が取得される。
        //           if(!results[0]){
        //             alert('結果が取得できませんでした');
        //             return;
        //           }
        //           // マップの中心を移動
        //           map.panTo(results[0].geometry.location);
        
        //           document.getElementById('search_result').innerHTML = results[0].formatted_address;
        //         }
        //       );
        //     }
        //   );
        
        // // クリック位置をリバースジオコーディング
        // map.addListener('click', function(e){
        //   geocoder.geocode({
        //     location: e.latLng
        //   }, function(results, status){
        //     if(status !== 'OK'){
        //       alert('リバースジオコーディングに失敗しました。結果: ' + status);
        //       return;
        //     }
        
        //     // console.log(results);
        //     if(!results[0]){
        //       alert('結果が取得できませんでした。');
        //       return;
        //     }
        
        //     // クリックした位置にマーカーを立てる
        //     var added_marker = new google.maps.Marker({
        //       position: e.latLng, // クリックした箇所
        //       map: map,
        //       animation: google.maps.Animation.DROP
        //     });
        //     // マーカーに情報ウィンドウを紐付け、
        //     // リバースジオコーディングで取得した住所を表示する。
        //     var infoWindow = new google.maps.InfoWindow({
        //       content: results[0].formatted_address,
        //     });
        //     infoWindow.open(map, added_marker);
        //   })
        // });
        var display_buttons = Array.from(document.getElementsByClassName('display'));
        //各ボタンにイベントを設定
        display_buttons.forEach(
          function(display_button){
            display_button.addEventListener(
              'click',
              function(){
                map.panTo(new google.maps.LatLng(display_button.dataset.lat,display_button.dataset.lng)); // スムーズに移動
              }
            );
          }
        );
       
        if(place_list.length === 1){
          var marker = new google.maps.Marker({
              position: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]), // クリックした箇所
              map: map,
              animation: google.maps.Animation.DROP
            });
        }else if(place_list.length === 2){
          var request = {
            origin: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
            destination: new google.maps.LatLng(place_list[place_list.length - 1]["lat"],place_list[place_list.length - 1]["lng"]),
            travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
          };
          var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
          var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
                  map: map, // 描画先の地図
                  preserveViewport: true, // 描画後に中心点をずらさない
                  })
          d.route(request, function(result, status){
              // OKの場合ルート描画
              if (status == google.maps.DirectionsStatus.OK) {
                  r.setDirections(result);
              }
          }); 
        }else if(place_list.length > 2){
          var waypoints = []
          for(var i = 1; i < (place_list.length - 1); i++){  
            waypoints.push({ location: new google.maps.LatLng(place_list[i]["lat"],place_list[i]["lng"])})
            }
        var request = {
          origin: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
          destination: new google.maps.LatLng(place_list[place_list.length - 1]["lat"],place_list[place_list.length - 1]["lng"]),
          waypoints: waypoints,
          travelMode: google.maps.DirectionsTravelMode.WALKING, // 交通手段(歩行。DRIVINGの場合は車)
          };
          var d = new google.maps.DirectionsService(); // ルート検索オブジェクト
          var r = new google.maps.DirectionsRenderer({ // ルート描画オブジェクト
                  map: map, // 描画先の地図
                  preserveViewport: true, // 描画後に中心点をずらさない
                  })
          d.route(request, function(result, status){
              // OKの場合ルート描画
              if (status == google.maps.DirectionsStatus.OK) {
                  r.setDirections(result);
              }
          });
        }
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>
</body>
</html>
