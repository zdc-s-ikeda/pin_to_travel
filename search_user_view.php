<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>検索</title>
    <style type="text/css">
        img {
            width: 20px;
        }
    </style>
</head>
<body>
    <form action="search_user.php" method="post">
        <div>
        <img src="search_icon.png">
        <input type="text" name="user_name" placeholder="ユーザー名">
        <input type="submit" value="search">
        </div>
    
<?php foreach ($searched_user as $user) { ?>
        <ul>
            <li>
            <a href="user_page.php?id=<?=$user['user_id']?>"><?php print h($user['user_name']); ?></a>
            </li>
        </ul>
<?php }?>
    </form>
</body>
</html>