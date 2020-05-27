<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>pin_to_travel top</title>
        <style>
            img {
                width: 100px;
                height: 100px;
            }
        </style>
    </head>
    <body>
        <!--ヘッダー-->
        <section id="header">
            <h1>pin_to_travel</h1>
            <ul>
                <li>マイページ</li>
                <li>検索</li>
                <li>ルート作成</li>
                <li>投稿</li>
            </ul>
        </section>
        
        <section id="main">
                <?php 
                $i = 0;
                foreach ($items as $item) { ?>
                    <!--<div style="background-image url:('../images/'<?php print h($imgs[$i]['img']); ?>)">-->
                    <tr>
                    <th>
                    <h1>おすすめルート</h1>
                    <form>
                        <p>リスト名：<?php print h($item['route_name']); ?></p>
                        <input type="hidden" name="route_id" value="<?php print h($item['route_id']); ?>">
                        <input type="submit" value="ルートを表示">
                    </form>
                     <form>
                        <p>ユーザー名：<?php print h($item['user_name']); ?></p>
                        <input type="hidden" name="user_id" value="<?php print h($item['user_id']); ?>">
                        <input type="submit" value="ユーザーページを表示">
                    </form>
                    </th>
                    </tr>
                    
                    <tr>
                    <td>
                        <img src="../images/<?php print h($imgs[$i]['img']); ?>">
                    </td>
                    </tr>
                    </div>
                <?php 
                $i ++; } ?>
                
                
            </table>
        </section>
        
        
    </body>
</html>