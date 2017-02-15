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
//$threadsId = filter_input(INPUT_GET, 'id');
$threadsId = 1;
//SQLでidパラメータと対応するスレッドテーブルのidを取得
if(!empty($threadsId) ) {
    
    $threadPdo = new DbUtil();
    $threadsData = $threadPdo->getThredsData($threadsId);
//    $commentsData = $threadPdo->getCommentsData($threadsId);  
    
   
      foreach ($threadsData as $row) {
            $id = $row['threads_id'];
            $threadsName = $row['threads_name'];
//            $deleteKey = $row['delete_key'];
//            $created = $row['created'];
//            $modified = $row['modified'];
        }

}
template::get_the_header();

?>

    <body>
        <?php if(!empty($userSession)) :?>
        <div class="account"><p>ようこそ<?= $userSession['name'] ?>さん<span class="btn_logout"><a href="login.php">ログアウト</a></span></p></div>
        <?php else :?>
        <div class="account"><span class="btn_login"><a href="login.php">ログイン</a></span></p></div>
        <?php endif ;?>
        <div class="wraper cf">
            <div id="main_contents">
                <h1><?php echo $threadsName; ?></h1>
                <form action="comment.php" method="post" class="thread_comment_form">
            <?php 
                $num = 1;            
                foreach ($threadsData as $row2) :   
                    if(!empty($row2['comment'])):
             ?>
            
                    <?php if($row2['dear_name'] == $userSession['name'] ) :?>
                    <div class="toukou_area your_message">
                    <?php else :?>
                    <div class="toukou_area">
                    <?php endif ;?>

                        <p class="toukousya">No<?= $num ?>&nbsp;&nbsp;<span class="icon_from">From</span><span class="thread_name"><?= $row2['from_name'] ?></span> &nbsp;&nbsp;<span class="icon_to">To</span><span class="thread_name"><?= $row2['dear_name'] ?></span> &nbsp;&nbsp; 投稿日：<?= $row2['created'] ?></p>
                        <p class="txt_bold"><?= nl2br($row2['comment']); ?></p>
                        
                    <?php if($row2['from_name'] == $userSession['name'] ) :?>
                    <input type="submit" value="削除" name="submit" class="toukou_delete">
                    <?php endif ;?>
                    </div>
                    
                
            <?php $num++;
              endif;                
              endforeach;
            ?>
             </form>


            <?php if(!empty($userSession)) :?>
            <form action="comment.php" method="post">
                <div class="message_select">                          
                     <input type="hidden" value="<?= $userSession['name'] ?>" name="from">
                     <input type="hidden" value="<?= $userSession['id'] ?>" name="from_id">                    
                <dl>                
                    <dt><select name="dear" class="dear_name">
                         <?php foreach ($userData as $row):if(!empty($row)): ?>
                            <?php if($row['name'] !== $userSession['name']) :?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endif;?>
                         <?php endif;endforeach;?>
                    </select>
                    <p>へ</p></dt>
                    <dd><textarea name="comment"></textarea></dd>
                    <!-- dt>削除キー</dt>
                    <dd><input type="text" name="delete_key" ></dd -->
                </dl>
                </div>
                <input type="hidden" value="<?php echo $threadsId ?>" name="threads_id">
                <input type="hidden" value="<?php echo $threadsId ?>" name="created">
                <input type="hidden" value="1" name="to_point">
                <input type="hidden" value="1" name="from_point">
                <input type="hidden" value="<?php echo $createDate ?>" name="create_date">
                <input type="submit" value="投稿" name="submit" class="submit02">
            </from>
            <?php endif ;?>
            
            </div>
            
            <?php 
                template::get_the_side();
            ;?>
            
        </div>
        </div>
    </body>
</html>
