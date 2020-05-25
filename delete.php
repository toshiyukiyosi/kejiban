<?php
require_once './DbManager.php';
$id = $_GET['id'];

try {
    $db = getDb();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stt = $db->prepare('DELETE FROM chat WHERE id = :id');
    $stt->bindValue(':id',$id);
    $stt->execute();

} catch (PDOException $th) {
    //throw $th;
    print "エラーメッセージ{$th->getMessage()}";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="inner">
        <div class="delete-head">
            <h2 class="delete-head-ttl">日直ご苦労さま</h2>
            <a href="./index.php">投稿画面へ</a>
        </div><!-- /.delete-head -->
    </div><!-- /.inner -->
</body>
</html>