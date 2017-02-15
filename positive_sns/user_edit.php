<?php
require('./_util/DbUtil.php');

$name = filter_input(INPUT_POST, "name");
$roginId = filter_input(INPUT_POST, "rogin_id");
$roginPass = filter_input(INPUT_POST, "rogin_pass");
$submitType = filter_input(INPUT_POST, 'submit');
$postPage = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$user = 'user';
$userPdo = new DbUtil();
$userData = $userPdo->getUserData($user);
$userNameEdit = filter_input(INPUT_POST,'user_name_edit');
$userId = filter_input(INPUT_POST,'user_id_edit');

$dbu = new DbUtil();
if ($dbu === false) {
    die('不具合が発生しました');
}

if ($submitType === '登録') {
    $dbu->insertUser($name,$roginId,$roginPass);
    header("LOCATION: $postPage");
}

if ($submitType === '削除') {
    $keyData = $dbu->deleteComment($threadsId, $commentsId, $deleteKey);
    header("LOCATION: $postPage");
}

if($submitType == '保存'){        
    $dbu->editUser($userId,$userNameEdit);
    $uri = $_SERVER['HTTP_REFERER'];
    header("Location: ".$uri, true, 303);
    }
?>
