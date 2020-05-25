<?php

require_once './DbManager.php';
require_once './encode.php';
require_once './MyValidator.php';
$v = new MyValidater();

$v->requiredCheck($_POST['name'],'名前');
$v->requiredCheck($_POST['message'],'投稿内容');
$v->lengthCheck($_POST['message'],'メッセージ',100);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入力エラー</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="inner">
        <div class="error-wrap">
            <?php $v();?>
        </div><!-- /.error-wrap -->
    </div><!-- /.inner -->
</body>
</html>
<?php

try {
    $db = getDb();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   
        $stt = $db->prepare('INSERT INTO chat(name,message)values(:name,:message)');

        $stt->bindValue(':name',$_POST['name']);
        $stt->bindValue(':message',$_POST['message']);
        $stt->execute();
    
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php');


} catch (PDOException $th) {
    //throw $th;
    print "エラーメッセージ{$th->getMessage()}";
}

?>