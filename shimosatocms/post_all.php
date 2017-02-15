<?php
    $categoryName = 1;
    require('./_util/template.php');
    require('./_util/DbUtil.php');
    $category = 'category';
    $post = 'post';
    $allPostPdo = new DbUtil();
    $categoryData = $allPostPdo->getcategoryData($category);
    $allPostData = $allPostPdo->getAllPostData($post);
    template::get_the_header();
?>

    <body>
        <div class="wraper">
            <div class="haeder">
                <h1>ShimosatoCMS</h1>
                <h2>投稿一覧</h2>
            </div>
            
            <div class="container clearfix">
        
                <?php  
                    template::get_the_side();
                ;?>

                <div class="main">
                    <div class="post_box">
                        <table class="all_post_table">
                            <tr><th>ID</th><th>記事タイトル</th><th>カテゴリー</th><th>編集</th></tr>
                            <?php 
                                foreach ($allPostData as $row):
                                    if(!empty($row)):
                                    ?>                                       
                            <tr><td><?= $row['id'] ?></td><td><?= $row['title'] ?></td><td><?= $row['category'] ?></td><td><form action="post_edit.php" method="get"><input type="hidden" name="post_id" value="<?= $row['id'] ?>"><input type="submit" name="submit" value="編集" class="edit"></form></td></tr>
                                    <?php
                                    endif;
                                endforeach;
                            ?>
                        </table>
                    </div>
                </div>
        </div>
        
        <?php  
               template::get_the_footer();
        ;?>
        
    </div>        
    </body>
</html>
