<?php
//======================
// ログ
//======================

ini_set('log_errors', 'on');
ini_set('error_log', 'php.log');

//======================
// デバッグ
//======================

$debug_flg = true;

function debug($str){
    global $debug_flg;
    if(!empty($debug_flg)){
        error_log('デバッグ：'.$str);
    }
}

//======================
// デバッグ開始
//======================

function debugLogStart(){
    debug('>>>>>>>>>>>>>>>>>>>>>>>>画面表示処理開始');
}

//======================
// 定数
//======================

define('MSG01','が未入力です');
define('MSG02', '1つだけ選択してください');
define('MSG03','255文字以内で入力してください');
define('MSG04','エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG05','前の画面に戻ってください');

//======================
// グローバル変数
//======================

$err_msg = array();

//======================
// バリデーション
//======================

function required($str, $key){
    if($str == ''){
        global $err_msg;
        $err_msg[$key] = MSG01;
    }
}

function checkRequired($str, $key){
    if(!isset($str) && !is_array($str)){
        global $err_msg;
        $err_msg[$key] = MSG01;
    }
}

function maxLen($str, $key, $max = 255){
    if(mb_strlen($str) > $max){
        global $err_msg;
        $err_msg[$key] = MSG03;
    }
}

function getErrMsg($key){
    global $err_msg;
    if(!empty($err_msg[$key])){
        return $err_msg[$key];
    }
}

//======================
// DB
//======================

function dbConnect(){
    $dsn = 'mysql:dbname=xs687729_questionnaire;host=mysql12013.xserver.jp;charset=utf8';
    $user = 'xs687729_kzys';
    $password = 'KhAaZmUu199529';
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
}

function queryPost($dbh, $sql, $data){
    $stmt = $dbh->prepare($sql);
    if(!$stmt->execute($data)){
        debug('クエリに失敗しました。');
        debug('失敗したSQL：'.print_r($stmt,true));
        $err_msg['common'] = MSG04;
        return 0;
    }
    debug('クエリ成功。');
    return $stmt;
}

function getContentList(){
    $dbh = dbConnect();
    $sql = 'SELECT content.id, content.name, content.age, content.sex, content.type, content.hope, content.create_date FROM content';
    $data = array();
    $stmt = queryPost($dbh, $sql, $data);

    $results = [];

    if($stmt){
        $results = $stmt->fetchAll();
        return $results;
    }else{
        debug('クエリに失敗しました。');
        debug('失敗したSQL：'.print_r($stmt,true));
        return false;
    }
}

function getContentDetail($a_id){
    debug($a_id.'の回答情報を取得します。');
    debug('回答者ID：'.$a_id);

    try{

        $dbh = dbConnect();
        $sql = 'SELECT content.name, content.age, content.sex, content.type, content.hope FROM content WHERE id = :a_id';
        $data = array(':a_id' => $a_id);
        $stmt = queryPost($dbh, $sql, $data);

        if($stmt){
            return $stmt->fetchAll();
        }else{
            return false;
        }

    }catch(Exception $e){

        error_log('エラー発生:'.$e->getMessage());
        $err_msg['common'] = MSG04;

    }
}
