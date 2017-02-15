<?php
require('./_util/DbUtil.php');

$name = filter_input(INPUT_POST, "name");
$submitType = filter_input(INPUT_POST, 'submit');

$user = 'user';
$userPdo = new DbUtil();
$userData = $userPdo->getUserData($user);

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
        <style>
            body{
                background: red;
            }
            #wraper{
                width: 750px;
                margin: 0 auto;
                padding:  20px 20px;
                background: #fff;
                
            }
            h1{
                font-size: 36px;
            }
            .toukou_area{
                border-bottom: 1px solid #ccc;
            } 
            .txt_bold{
                font-size: 20px;
                font-weight: bold;
                margin-top: 0;
            }
            
            .toukousya{
                font-size: 12px;
                margin-bottom: 7px;
            }
            
            .toukoubi {
                margin-bottom: 5px;
                text-align: right;
                font-size: 12px;
            }
            textarea{
                width: 500px;
                height: 200px;
            }
            
            dl{
                width: 500px;
                margin: 0 auto;
            }
            
            dd {
                margin-left: 0px;
                margin-bottom: 15px;
            }
            
            dt {
                margin-bottom: 10px;
            }
            
            .submit02{
                display: block;
                width: 90px;
                height: 40px;
                margin: 0 auto;
            }
            
            [name="delete"]{
                width: 90px;                           
            }
            
            form{
                padding-top: 30px;
            }
            
            .user_table01{
                width: 400px;
                border-collapse: collapse;
            }
            
            .user_table01 th{
                background: #3e3e3e;
                color: #fff;
            }
            
            .user_table01 th,
            .user_table01 td{
                padding: 5px;
                text-align: center;
                border: 1px solid #ccc;
            }       
           
        </style>
    </head>
    <body>
        <div id="wraper">
        <h1>ユーザー管理画面</h1>
        
        <form action="user_edit.php" method="post">
            <h2>新規ユーザー登録</h2>
            <dt class="add_user_name">名前</dt>
            <dd><input type="text" name="name"></dd>
            
            <dt class="add_user_id">ユーザーID</dt>
            <dd><input type="text" name="rogin_id"></dd>
            
            <dt class="add_user_pass">パスワード</dt>
            <dd><input type="text" name="rogin_pass"></dd>
            
            <input type="submit" value="登録" name="submit" class="submit_add_user">
        </from>
        
        <div class="user_list">
                    <div class="user_box clearfix">
                        <h2>ユーザー一覧</h2>
                        <form action="user_edit.php" method="post">
                            <table class="user_table01">
                                <tr><th>ID</th><th>名前</th><th>編集</th></tr>
                               <?php 
                                    foreach ($userData as $row):
                                        if(!empty($row)):
                                        ?>
                                <tr><td><?= $row['id'] ?></td><td><span class="user_list_name"><?= $row['name'] ?></span></td><td><input type="button" value="編集" class="edit_user"></td></tr>
                                        <?php
                                        endif;
                                    endforeach;
                                ?>
                            </table>
                        </form>
                        
                    </div>
                </div>
        </div>
        </div>
    </body>
</html>
