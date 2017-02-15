<?php
require('./DbUtil.php');
$postPage = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$dbu = new DbUtil();
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST) && !empty($_POST)) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["rogin_id"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["rogin_pass"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["rogin_pass"]) && empty($_POST["rogin_id"])) {
        $errorMessage = 'ユーザーID・パスワードが未入力です。';
    }

    //どっちも値がある場合
    if (!(empty($_POST["rogin_id"]) || empty($_POST["rogin_pass"]))) {
        // 入力された値を格納
        $userId = filter_input(INPUT_POST, "rogin_id");
        $userPass = filter_input(INPUT_POST, "rogin_pass");
        $userData = $dbu->searchLogin($userId, $userPass);

        if (empty($userData) || 2 <= count($userData)) {
            $errorMessage = 'ユーザーID・パスワードが違います。';
        } else {
            $_SESSION['user'] = $userData[0];
            $name = $_SESSION['user']['name'];
            header("LOCATION: ../thread.php");
            exit();
        }
    }
}

if (empty($errorMessage)) {
    $errorMessage = 'ハッカーかお前は';
}
$_SESSION['error'] = $errorMessage;
header("LOCATION: $postPage");
