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
      #sidebar {
        background-color: blue;
      }
      .side_img {
        width: 100px;
        height: 100px;
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
    <li><a href="../route/route.php">マイルート</a></li>
    <li><a href="">リスト</a></li>
    <li><a href="">お気に入り</a></li>
    <li><a href="">共有</a></li>
    </navigation>
    
    <section id="main">
    <div id="message">
      <?php foreach ($errors as $error) { ?>
      <p><?php print h($error); ?></p>
      <?php } ?>
      <?php foreach ($messages as $message) { ?>
      <p><?php print h($message); ?></p>
      <?php } ?>
    </div>
    
    <div id="add">
      <?php foreach ($items as $item) { ?>
        <form method="post" action="mypage.php">
          <li>
          <label><?php print h($item['place_name']) ?>
          <label>　順番：<input type="text" name="place_order"></label>
          <input type="hidden" name="place_id" value="<?php print h($item['place_id']); ?>">
          <input type="submit" value="リストに追加">
          </label>
          </li>
        </form>
      <?php } ?>
    </div>
    
    <div id="added">
      <ul>
        <?php foreach ($list_items as $list_item) { ?>
        <li><?php print h($list_item['place_name']); ?></li>
        <?php } ?>
      </ul>
    </div>
    
    <section id="sidebar">
      
      <p>リスト名：<?php print h($route_name['route_name']); ?></p>
      
      <div class="side_item">
      <?php foreach ($side_items as $side_item) { ?>
      <p><?php print h($side_item['place_name']); ?></p>
      <img src="../images/<?php print h($side_item['img']); ?>" class="side_img">
      <p>コメント：<?php print h($side_item['comment']); ?></p>
      <p>url：<?php print h($side_item['url']); ?></p>
      <?php } ?>
      </div>
      
    </section>
    </section>

    

    <script>
      function init(){
                      //$itemsをjs形式で呼び出し
        var items = JSON.parse('<?php echo $items_json; ?>');

        var map_box = document.getElementById('map_box');
        var map = new google.maps.Map(
          map_box,
          {
            center: new google.maps.LatLng(items[0]["lat"],items[0]["lng"]),
            zoom: 12,

            disableDefaultUI: true,
            zoomControl: true,
            clickableIcons: false,
          }
        )
        
    
        
        // // ジオコーダーの生成
        // var geocoder = new google.maps.Geocoder();
        // document.getElementById('search')
        // .addEventListener(
        // 'click',
        // function(){
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
        //           //スクロールする
        //           map.panTo(results[0].geometry.location);
                  
        //         //formatted_address 書式が整えられた住所の情報
        //           document.getElementById('search_result').innerHTML = results[0].formatted_address;
        //         }
        //       );
        //     }
        //   );
          
          
        //   // クリック位置をリバースジオコーディング
        //     map.addListener('click', function(e){
        //       geocoder.geocode({
        //         location: e.latLng
        //       }, function(results, status){
        //         if(status !== 'OK'){
        //           alert('リバースジオコーディングに失敗しました。結果: ' + status);
        //           return;
        //         }
            
        //         // console.log(results);
        //         if(!results[0]){
        //           alert('結果が取得できませんでした。');
        //           return;
        //         }
            
        //         // クリックした位置にマーカーを立てる
        //         var added_marker = new google.maps.Marker({
        //           position: e.latLng, // クリックした箇所
        //           map: map,
        //           animation: google.maps.Animation.DROP,
        //           title: results[0].formatted_address
        //         });
        //         // マーカーに情報ウィンドウを紐付け、
        //         // リバースジオコーディングで取得した住所を表示する。
               
        //         var infoWindow = new google.maps.InfoWindow({
        //           content: 'ここに情報を表示'
        //         });
                
        //         infoWindow.open(map, added_marker);
                
        //         //document.getElementById('searched_address').value = results[0].formated...
        //       })
        //     });

            var markers = [];
            //for (var i = 0; i < items.length; i++) {
              //var item = items[i];
            for (var item of items) {
              
              var added_marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(item["lat"],item["lng"])
              });
              var added_info_window = new google.maps.InfoWindow({
                content: item['place_name'] + '<br>' + item['comment'] + '<br>' + item['url'] + '<br>' + '<img src="../images/' + item['img'] + '"　width=75 height=75>'
              });
              
              added_info_window.open(map, added_marker);
              
              markers.push(added_marker);
            }
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

</body>
</html>