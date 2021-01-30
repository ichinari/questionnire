<?php

require('function.php');

debug('>>>>>>>>>>>>>>>>>>>>>>>>回答一覧画面処理開始');

debugLogStart();

$dbContentData = getContentList();

debug('>>>>>>>>>>>>>>>>>>>>>>>>回答一覧画面処理終了');

?>

<!-- 表示部分 -->
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>回答の一覧ページ</title>
        <link rel="stylesheet" type="text/css" href="./css/reset.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>

        <div class="list_area">
            <div class="list_area_title">回答の一覧</div>
            <div class="list_area_supplement">氏名/回答日時(年-月-日)</div>

            <?php
                foreach($dbContentData as $key => $value){
            ?>

            <div>
                <div class="list_area_respondent"><a href="detail.php?id=<?php echo $value['id']; ?>"><?php echo $value['name'] ?></a>/(<?php echo $value['create_date'] ?>)</div>
            </div>

            <?php
                }
            ?>
        </div>

        <div class="list_form_back"><a href="index.php">〜回答フォームへ〜</a></div>

    </body>
</html>