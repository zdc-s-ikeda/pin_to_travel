<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <style>
      #map_box {
        width: 600px;
        height: 600px;
        text-align: center;
      }
      .side_img {
        width: 100px;
        height: 100px;
      }
      p {
        word-wrap: break-word;
      }
      #header {
        width: 100%;
      }
      #main {
        display: flex;
      }
      #center {
        flex: 1;
      }
      #add {
        width: 200px;
      }
      #sidebar {
        background-color: gray;
        width: 300px;
      }
    </style>
</head>
<body>
    <!--<p>-->
    <!--  <label>住所を検索: <input type="text" id="address"></label>-->
    <!--  <button id="search">検索</button>-->
    <!--</p>-->
    <!--<p id="search_result"></p>-->
  
    <section id="header">
      <p>pin_to_travel</p>
      <div>
      <li><a href="../route/route.php">マイルート</a></li>
      <li><a href="">リスト</a></li>
      <li><a href="">お気に入り</a></li>
      <li><a href="">共有</a></li>
      </div>
    </section>
    
    <div id="main">
    <section id="center">
    <div id="map_box"></div>
      
    <div id="message">
      <?php foreach ($errors as $error) { ?>
      <p><?php print h($error); ?></p>
      <?php } ?>
      <?php foreach ($messages as $message) { ?>
      <p><?php print h($message); ?></p>
      <?php } ?>
    </div>
    
    <div id="added">
      <ul>
        <?php foreach ($list_items as $list_item) { ?>
        <li><?php print h($list_item['place_name']); ?></li>
        <?php } ?>
      </ul>
    </div>
    </section>

    <div id="add">
      <?php foreach ($items as $item) { ?>
        <form method="post" action="mypage.php">
          <label><?php print h($item['place_name']) ?><br>
          <label>　順番：<input type="text" name="place_order"></label><br>
          <input type="hidden" name="place_id" value="<?php print h($item['place_id']); ?>">
          <input type="submit" value="リストに追加"><br>
          </label>
        </form>
      <?php } ?>
    </div>
    
    <section id="sidebar">
      
      <p>リスト名：<?php print h($route_table[0]['route_name']); ?></p>
      <form>
      <a href="../user_page.php">投稿者：<?php print h($route_table[0]['user_id']); ?></a>
      <input type="hidden" name="use_id" value="<?php print h($route_table[0]['user_id']); ?>">
      </form>
      
      <div class="side_item">
      <?php foreach ($side_items as $side_item) { ?>
      <p><?php print h($side_item['place_name']); ?></p>
      <img src="../images/<?php print h($side_item['img']); ?>" class="side_img">
      <p>コメント：<?php print h($side_item['comment']); ?></p>
      <label>url：<a href="<?php print h($side_item['url']); ?>"><?php print h($side_item['url']); ?></a></label>
      <?php } ?>
      </div>
      
    </section>
    </div>

    

    <script>
      function init(){
        //$itemsをjs形式で呼び出し
        var items = JSON.parse('<?php echo $items_json; ?>');
        
        //map_box要素を取得
        var map_box = document.getElementById('map_box');
        //mapを表示
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
        
        //マーカーを立てる
        var markers = [];
        for (var item of items) {
              
          //マーカーを立てる
          var added_marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(item["lat"],item["lng"])
          });
          
          //インフォメーションウィンドウの表示
          var added_info_window = new google.maps.InfoWindow({
            content: item['place_name'] + '<br>'
          });
        
        var btn = document.createElement("button");
        btn.innerText = item['place_name'];
        google.maps.event.addDomListener(btn,"click", function(){
          added_info_window.setContent("aiueo")
        });
        
        //ボタンをcontentにセット
        added_info_window.setContent(btn);
        
        //インフォウィンドウを開く
        added_info_window.open(map, added_marker);
        
        //配列にpushして代入
        markers.push(added_marker);
            }
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=init" async defer></script>

</body>
</html>