<?php
require('./_util/DbUtil.php');
require('./_util/SessionUtil.php');
require('./_util/template.php');

session_start();
if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
    $errorMessage =  $_SESSION['error'];
}
session_destroy();
$name = filter_input(INPUT_POST, "name");
$submitType = filter_input(INPUT_POST, 'submit');

$user = 'user';
$userPdo = new DbUtil();
$userData = $userPdo->getUserData($user);

template::get_the_header();
?>

    <body>
        <div id="wraper">
        <h1>ログイン画面</h1>
            <div class="login_inner inner">
            <form action="_util/user_login.php" method="post" class="login_from">
                <dl>
                    <dt class="login_user_id">ユーザーID</dt>
                    <dd><input type="text" name="rogin_id"></dd>

                    <dt class="login_user_pass">パスワード</dt>
                    <dd><input type="text" name="rogin_pass"></dd>
                </dl>
                <input type="submit" value="ログイン" name="login" class="submit_login_user">
            </form>
            
            <p><a href="thread.php">TOPに戻る</a></p>
            </div>
            
        </div>
        <?php if(!empty($errorMessage)) :?>
        <p class="errorMsg"><?= $errorMessage ?></p>
        <?php endif ;?>
    </body>
</html>
