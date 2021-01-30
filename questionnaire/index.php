<?php

use Symfony\Contracts\Service\Attribute\Required;

require('function.php');

debug('>>>>>>>>>>>>>>>>>>>>>>>>アンケートフォーム画面処理開始');

debugLogStart();

if(!empty($_POST)){
    debug('Post送信あり');

    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $type = $_POST['type'];

    if(!empty($_POST['hope'])){
        $hope = $_POST['hope'];
    }else{
        $hope = 'なし';
    }

    required($name, 'name');
    required($sex, 'sex');
    required($age, 'age');
    checkRequired($type, 'type');

    if(empty($err_msg)){

        $type = implode('、', $type);

        try{

            $dbh = dbConnect();
            $sql = 'INSERT INTO content (name, age, sex, type, hope, create_date) VALUES(:name, :age, :sex, :type, :hope, :create_date)';
            $data = array(
                ':name' => $name,
                ':age' => $age,
                ':sex' => $sex,
                ':type' => $type,
                ':hope' => $hope,
                ':create_date' => date('Y-m-d')
            );
            $stmt = queryPost($dbh, $sql, $data);

            header("Location:answer.php");
            exit;

        }catch(Exception $e){

            error_log('エラー発生:'. $e->getMessage());
            $err_msg['common'] = MSG04;

        }
    }
}
debug('>>>>>>>>>>>>>>>>>>>>>>>>アンケートフォーム画面処理終了');
?>


<!-- 表示部分 -->
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>アンケート回答ページ</title>
        <link rel="stylesheet" type="text/css" href="./css/reset.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <div class="question_area">
            <form method="post" action="">

            <!-- 氏名 -->
                <div class="err_msg">
                    <?php
                        if(!empty($err_msg['name'])) echo "氏名".$err_msg['name'];
                    ?>
                </div>

                <div class="question_area_title">
                    <label><span>*</span>氏名を教えてください。</label>
                    <input class="question_name_box" type="text" name="name" value="<?php if (!empty($_POST['name'])) { echo $_POST['name']; } ?>">
                </div>

            <!-- 年齢 -->
                <div class="err_msg">
                    <?php
                        if(!empty($err_msg['age'])) echo "年齢".$err_msg['age'];
                    ?>
                </div>

                <div class="question_area_title">
                    <label><span>*</span>年齢を教えてください。</label>
                        <select class="question_age_box" name="age">
                            <option value="">選択してください</option>
                            <option value="20歳未満">20歳未満</option>
                            <option value="20歳〜39歳">20歳〜39歳</option>
                            <option value="40歳〜59歳">40歳〜59歳</option>
                            <option value="60歳以上">60歳以上</option>
                        </select>
                </div>

            <!-- 性別 -->
                <div class="err_msg">
                    <?php
                        if(!empty($err_msg['sex'])) echo "性別".$err_msg['sex'];
                    ?>
                </div>

                <div class="question_area_title">
                    <label><span>*</span>性別を教えてください。</label>
                    <label for="sex_male"><input class="question_sex_radio" type="radio" name="sex" value="男性" <?php if( !empty($_POST['sex']) && $_POST['sex'] === "男性" ){ echo 'checked'; } ?>>男性</label>
                    <label for="sex_female"><input class="question_sex_radio" type="radio" name="sex" value="女性" <?php if( !empty($_POST['sex']) && $_POST['sex'] === "女性" ){ echo 'checked'; } ?>>女性</label>
                </div>

            <!-- 物件 -->
                <div class="err_msg">
                    <?php
                        if(!empty($err_msg['type'])) echo "希望物件種別".$err_msg['type'];
                    ?>
                </div>

                <div class="question_area_title">
                    <label><span>*</span>希望物件種別を教えてください。</label>
                    <label>
                        <input class="question_type_checkbox" type="checkbox" name="type[]" value="新築一戸建て"　<?php if( !empty($_POST['type']) && $_POST['type'] === "新築一戸建て" ){ echo 'checked'; } ?>>新築一戸建て
                        <input class="question_type_checkbox" type="checkbox" name="type[]" value="中古一戸建て" <?php if( !empty($_POST['type']) && $_POST['type'] === "中古一戸建て" ){ echo 'checked'; } ?>>中古一戸建て
                        <input class="question_type_checkbox" type="checkbox" name="type[]" value="マンション" <?php if( !empty($_POST['type']) && $_POST['type'] === "マンション" ){ echo 'checked'; } ?>>マンション
                        <input class="question_type_checkbox" type="checkbox" name="type[]" value="土地" <?php if( !empty($_POST['type']) && $_POST['type'] === "土地" ){ echo 'checked'; } ?>>土地
                    </label>
                </div>

            <!-- 要望 -->
                <div class="hope_area question_area_title">
                    <label class="hope_area">その他ご要望をご入力ください。</label>
                    <textarea class="question_hope_box" name="hope" value="<?php if (!empty($_POST['hope'])) { echo $_POST['hope']; } ?>"></textarea>
                </div>

                <div class="question_warning">注）<span>＊</span>が付く質問は必ず入力してください。</div>

                <div class="form_btn_area">
                    <input class="form_btn" type="submit" name="btn_submit" value="送信">
                </div>

            </form>
        </div>
    </body>
</html>