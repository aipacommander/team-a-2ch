<?php
//ユーザーデータを取得
$user = 'user';
$userPdo = new DbUtil();
$userData = $userPdo->getUserData($user);
;?>
    <div class="side">
        <div class="side_inner">
            <div class="member">
                <dl>
                    <dt>メンバー</dt>
                    <dd>
                        <ul class="membaer_list">
                        <?php foreach ($userData as $row):if(!empty($row)): ?>                            
                           <li><a href="user_thread.php?user_id=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>                            
                        <?php endif;endforeach;?>
                        </ul>
                    </dd>
                </dl>
            </div>
            <div class="ranking">
                <dl>
                    <dt>ランキング</dt>
                    <dd>
                        <ul class="rnking_list">                                           
                           <li><a href="">今月ランキング</a></li>
                           <li><a href="">月別ランキング</a></li>
                        </ul>
                    </dd>
                </dl>
            </div>
        </div>
    </div>


