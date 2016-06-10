<?php
/**
 * Created by PhpStorm.
 * User: kazumatamaki
 * Date: 2016/06/10
 * Time: 23:52
 */

require('_util/DbUtil.php');

$threadsName = filter_input(INPUT_GET, 'threads_name');
$deleteKey = filter_input(INPUT_GET, 'delete_key');

// どっちも空っぽだったらリダイレクト
if (empty($threadsName) || empty($deleteKey)) {
    header('Location:' . 'index.php');
}

$dbUtil = new DbUtil();
$threadsId = $dbUtil->insertThread($threadsName, $deleteKey);
if ($threadsId) {
    header('Location: '. 'thread.php?id=' . $threadsId);
} else {
    header('Location:' . 'index.php');
}
