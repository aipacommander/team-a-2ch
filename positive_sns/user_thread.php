<?php
require('./_util/DbUtil.php');
require('./_util/SessionUtil.php');
require('./_util/template.php');

$sessionUtil = new SessionUtil();
$userSession =  $sessionUtil->getSessionData('user');

$id;
$threadsName;
$deleteKey;
$created;
$modified;
$createDate = date('Y');
$createDate .= date('m');  
//ユーザーデータを取得
$user = 'user';
$userPdo = new DbUtil();
$userData = $userPdo->getUserData($user);

//受け取ったidパラメータを取得
$userId = filter_input(INPUT_GET, 'user_id');

//SQLでidパラメータと対応するスレッドテーブルのidを取得
if(!empty($userId) ) {
    
    $userCommentPdo = new DbUtil();
    $userCommentData = $userCommentPdo->getCommentData($userId);    
  
    
      foreach ($userCommentData as $row) {
            $uesrid = $row['to_id']; 
            $to_name = $row['dear_name']; 
        }
        
        

}
template::get_the_header();

?>

<body class="under">
        <?php if(!empty($userSession)) :?>
        <div class="account"><p>ようこそ<?= $userSession['name'] ?>さん<span class="btn_logout"><a href="login.php">ログアウト</a></span></p></div>
        <?php else :?>
        <div class="account"><span class="btn_login"><a href="login.php">ログイン</a></span></p></div>
        <?php endif ;?>
        <div class="wraper cf">
            <div id="main_contents">
                <?php if(!empty($userCommentData)) :?>
                    <h1><?php echo $to_name; ?>さんへのコメント一覧</h1>
                <?php else :?>
                <p>メッセージはまだありません</p>
                <?php endif ;?>
            <?php 
                $num = 1;            
                foreach ($userCommentData as $row2) :   
                    if(!empty($row2['comment'])):
             ?>
            <form action="comment.php" method="post" class="thread_comment_form">
                    <?php if($row2['dear_name'] == $userSession['name'] ) :?>
                    <div class="toukou_area your_message">
                    <?php else :?>
                    <div class="toukou_area">
                    <?php endif ;?>

                        <p class="toukousya">No<?= $num ?>&nbsp;&nbsp;<span class="icon_from">From</span><span class="thread_name"><?= $row2['from_name'] ?></span> &nbsp;&nbsp;<span class="icon_to">To</span><span class="thread_name"><?= $row2['dear_name'] ?></span> &nbsp;&nbsp; 投稿日：<?= $row2['created'] ?></p>
                        <p class="txt_bold"><?= nl2br($row2['comment']); ?></p>
                    </div>
                    
                </form>
            
            <?php $num++;
              endif;                
              endforeach;
            ?>
                        
            </div>
            
            <?php 
                template::get_the_side();
            ;?>
            
        </div>
        </div>
    </body>
</html>
