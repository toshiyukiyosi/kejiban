<?php
require_once './h.php';

if(isset($_POST['submit'])){
    $password = $_POST['password'];
    $options = array('cost' => 10);

    $hash = password_hash($password,PASSWORD_DEFAULT,$options);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($hash)){
        echo 'なまパスワード' . h($password) . '<br>';
        echo 'ハッシュパスワード' . h($hash) . '<br>';
    }

    // パスワードがハッシュにマッチするか調べる
    // $password -> ユーザーのパスワード
    $auth = password_verify($password,$hash);

    if($auth){
        echo "パスワードマッチしてるよ";
    }else{
        echo "パスワードマッチしてないよ";
    }
    ?>
    <hr>
    <form action="hash_once.php">
        <label for="password">ハッシュしよ</label>
        <input type="text" name="password" id="password" value="">
        <input type="submit" name="submit" value="ハッシュか">
    </form>
</body>
</html>