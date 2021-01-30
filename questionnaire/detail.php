<?php

require('function.php');

debug('>>>>>>>>>>>>>>>>>>>>>>>>回答詳細画面処理開始');

debugLogStart();

$answerID = $_GET['id'];

if($answerID > 0){

    $dbAnswerDate = getContentDetail($answerID);

}else{
    $err_msg['common'] = MSG05;
}

debug('>>>>>>>>>>>>>>>>>>>>>>>>回答詳細画面処理終了');
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>回答の一覧ページ</title>
        <link rel="stylesheet" type="text/css" href="./css/reset.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>

        <div class="detail_area">
            <?php
                foreach($dbAnswerDate as $key => $value){
            ?>

                <div class="detail_area_question">Q.氏名を教えてください。</div>
                <div class="detail_area_respondent">→<?php echo $value['name'] ?></div>

                <div class="detail_area_question">Q.年齢を教えてください。</div>
                <div class="detail_area_respondent">→<?php echo $value['age'] ?></div>

                <div class="detail_area_question">Q.性別を教えてください。</div>
                <div class="detail_area_respondent">→<?php echo $value['sex'] ?></div>

                <div class="detail_area_question">Q.希望物件種別を教えてください。</div>
                <div class="detail_area_respondent">→<?php echo $value['type'] ?></div>

                <div class="detail_area_question">Q.その他ご要望をご入力ください。</div>
                <div class="detail_area_respondent">→<?php echo $value['hope'] ?></div>

            <?php
                }
            ?>
        </div>

        <div class="detail_list_back"><a href="list.php">〜一覧へ戻る〜</a></div>

    </body>
</html>