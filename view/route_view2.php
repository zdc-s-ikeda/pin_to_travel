<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
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

    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

    <script>
      function init(){
        var place_list = JSON.parse('<?php echo $place_list_json; ?>');
        var shinagawa = {
          lat: 35.6284477,
          lng: 139.7366322
        };
        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box,
          {
            center: new google.maps.LatLng(place_list[0]["lat"],place_list[0]["lng"]),
            zoom: 15,
            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        );
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
                  map.panTo(results[0].geometry.location);
        
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
              animation: google.maps.Animation.DROP
            });
            // マーカーに情報ウィンドウを紐付け、
            // リバースジオコーディングで取得した住所を表示する。
            var infoWindow = new google.maps.InfoWindow({
              content: results[0].formatted_address,
            });
            infoWindow.open(map, added_marker);
          })
        });
        
        
       
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
      console.log('place_list')
    </script>
</body>
</html>