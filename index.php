<?php

require_once './DbManager.php';
require_once './encode.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="inner">
        <div class="marquee">
            <p>一言掲示板です！<br> 入力してね！</p>
        </div><!-- /.marquee -->
        <h1 class="head">一言掲示板</h1><!-- /.head -->
        <div class="form-wrap">
            <h2 class="form-head">投稿フォーム</h2><!-- /.form-head -->
            <form action="./insert.php" method="post">
                <div class="">
                    <label for="name" >名前</label>
                    <input type="text" name="name" id="name" value="" class="label-name"/>
                </div><!-- /. -->
                <div class="">
                    <label for="message" >メッセージ</label>
                    <input type="text" name="message" class="label-msg" id="message" maxlength="100" value="" >
                </div><!-- /. -->
                <button type="submit" value="書き込む" class="btn">送信する</button>
            </form>

        </div><!-- /.from-wrap -->
        <div class="table-wrap">
            <h2 class="table-head">今までの投稿一覧</h2><!-- /.table-head -->
            <table border="1">
                <tr>
                    <th>名前</th>
                    <th>投稿内容</th>
                    <th>消す</th>
                </tr>
                <?php
                try{
            $db = getDb();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $stt = $db->prepare('SELECT * FROM chat ORDER BY id DESC');
                $stt->execute();
                while($row = $stt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?= e($row['name']);?></td>
                        <td><?= e($row['message']);?></td>
                        <td><a href="delete.php?id=<?= ($row['id']);?>">削除</a></td>
                    </tr>
                    <?php
        
                }
            }catch(PDOException $th){
            print "エラーメッセージ{$th->getMessage()}";
        
            }
        ?>        
            </table>
            
        </div><!-- /.table-wrap -->
    </div><!-- /.inner -->
</body>
</html>