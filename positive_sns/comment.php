<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('./_util/DbUtil.php');

$fromName = filter_input(INPUT_POST, "from");
$dearName = filter_input(INPUT_POST, "dear");
$fromId = filter_input(INPUT_POST, "from_id");
$threadsId = filter_input(INPUT_POST, "threads_id");
$comment = htmlspecialchars(filter_input(INPUT_POST, "comment"));
$deleteKey = 0;
$toPoint = filter_input(INPUT_POST, "to_point");
$fromPoint = filter_input(INPUT_POST, "from_point");
$fromPoint = filter_input(INPUT_POST, "from_point");
$commentsId = filter_input(INPUT_POST, "comments_id");
$created = date("Y/m/d H:i:s");
$submitType = filter_input(INPUT_POST, 'submit');
$postPage = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$createDate = filter_input(INPUT_POST, 'create_date');

$dbu = new DbUtil();
if ($dbu === false) {
    die('不具合が発生しました');
}

if ($submitType === '投稿') {
    $userData = $dbu->selectByUserData($dearName);
    $userName = $userData[0]['name'];   
    $dbu->insertComment($threadsId,$comment,$fromName,$userName,$fromId,$dearName,$deleteKey,$created,$fromPoint,$toPoint,$createDate);
    header("LOCATION: $postPage");
}

if ($submitType === '削除') {
    $keyData = $dbu->deleteComment($threadsId, $commentsId, $deleteKey);
    header("LOCATION: $postPage");
}