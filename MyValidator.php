<?php
require_once 'DbManager.php';

class MyValidater {
    // エラーメッセージを格納するための変数
    private $_errors;
    // コンストラクタ
    public function __construct(string $encoding = 'UTF-8')
    {
        // プライベート変数$_errorsを初期化
        $_errors = [];
        // 内部文字コードを設定
        mb_internal_encoding($encoding);

        // $_GET,$_POST,$_COOKIEの文字エンコーディングをチェック
        $this->checkEncoding($_GET);
        $this->checkEncoding($_POST);
        $this->checkEncoding($_COOKIE);
        // $_GET,$_POST,$_COOKIEのnullバイトをチェック
        $this->checkNull($_GET);
        $this->checkNull($_POST);
        $this->checkNull($_COOKIE);
    }
    // 配列要素に含まれる文字コーディングをチェック
    private function checkEncoding(array $data)
    {
        # code...
        foreach ($data as $key=>$value){
            if(!mb_check_encoding($value)){
                $this->_errors[] = "{$key}は不正な文字コードです";
            }
        }
    }

    // 配列要素に含まれるnullバイトをチェック
    private function checkNull(array $data)
    {
        # code...
        foreach ($data as $key => $value){
            if(preg_match('/\0/',$value)){
                $this->_errors[] = "{$key}は不正な文字を含んでいます";
            }
        }
    }

    // 必須検証
    public function requiredCheck(string $value,string $name)
    {
        # code...
        if(trim($value) === ''){
            $this->_errors[] = "{$name}は必須入力です";
        }
    }

    // $len以内の入力であるか
    public function lengthCheck(string $value,string $name,int $len)
    {
        # code...
        if(trim($value) !== ''){
            if(mb_strlen($value) > $len){
                $this->_errors[] = "{$name}は{$len}以内で入力してください";
            }
        }
    }

    // 整数型検証
    public function intTypeCheck(string $value,string $name)
    {
        # code...
        if(trim($value) !== ''){
            if(!ctype_digit($value)){
                $this->_erros[] = "{$name}は数値で指定してください";
            }
        }
    }

    // 数値範囲$min ~ $max の間にあるか
    public function rangeCheck(string $value,string $name,float $max, float $min)
    {
        # code...
        if(trim($value) !== ''){
            if($value > $max || $value < $min){
                $this->_errors[] = "{$name}は{$min}~{$max}の間で指定してください";
            }
        }
    }

    // 日付型検証
    public function dateTyoeCheck(string $value,string $name)
    {
        # code...
        if(trim($value) !== ''){
            $res = preg_split('|([/\-])|',$value);
            if(count($res) !== 3 || !@checkdate($res[1],$res[2],$res[0])){
                $this->_errors[] = "{name}は日付形式で入力してください";
            }
        }
    }

    // 正規表現パターン検証
    public function regexCheck(string $value,string $name, string $patten)
    {
        # code...
        if(trim($value) !== ''){
            if(preg_match($patten,$value)){
                $this->_errors[] = "{$name}は正しい形式で入力してください";
            }
        }
    }

    // 配列要素検証（配列$optsのいずれかどうかを検証する）
    public function inArrayCheck(string $value,string $name,array $opts)
    {
        # code...
        if(trim($value) !== ''){
            if(!in_array($value,$opts)){
                $tmp = implode(',',$opts);
                $this->_errors[] = "{$name}は{$tmp}の中から選択してください";
            }
        }
    }

    // 重複検証
    public function duplicateCheck(string $value, string $name,string $sql)
    {
        # code...
        try {
            $db = getDb();
            $stt = $db->prepare($sql);
            $stt->bindValue(':value',$value);
            $stt->execute();
            if(($row = $stt->fetch()) !== false){
                $this->_errors[] = "{$name}は重複しています";
            }
        } catch (PDOException $e) {
            $this->_errors[] = $e->getMessage();
        }
    }

    // プライベート変数_errorにエラーが格納されていないかをチェック

    public function __invoke()
    {
        # code...
        if(count($this->_errors) > 0){
            print '<ul style="color:red">';
            foreach($this->_errors as $err){
                print "<li>{$err}</li>";
            }
            print '</ul>';
            echo '<a href="./index.php">投稿画面へ</a>';
            die();
        }
    }
}
