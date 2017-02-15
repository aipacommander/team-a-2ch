<?php
    $categoryName = 1;
    require('./_util/template.php');
    require('./_util/DbUtil.php');
    $category = 'category';
    $categoryPdo = new DbUtil();
    $categoryData = $categoryPdo->getcategoryData($category);

    template::get_the_header();
?>

    <body>
        <div class="wraper">
            <div class="haeder">
                <h1>ShimosatoCMS</h1>
                <h2>カテゴリーページ</h2>
            </div>
            
            <div class="container clearfix">
        
                <?php  
                    template::get_the_side();
                ;?>

                <div class="main">
                    <div class="category_box clearfix">
                        <h3>■カテゴリー一覧</h3>
                        <form action="_util/category_db.php" method="post">
                            <table class="category_table01">
                                <tr><th>ID</th><th>カテゴリー名</th><th>編集</th></tr>
                               <?php 
                                    foreach ($categoryData as $row):
                                        if(!empty($row)):
                                        ?>
                                <tr><td><?= $row['id'] ?></td><td><span class="category_list_name"><?= $row['category_name'] ?></span></td><td><input type="button" value="編集" class="edit_category"></td></tr>
                                        <?php
                                        endif;
                                    endforeach;
                                ?>
                            </table>
                        </form>
                        <form action="_util/category_db.php" method="post">
                            <h3>■新規カテゴリーを追加</h3>
                            <table class="category_table02">
                                <tr><th>カテゴリー名</th>
                                <td>
                                    <input type="text" name="category_name">
                                    <input type="hidden" name="category_add" value="add">
                                </td>
                                <td><input type="submit" value="追加" name="submit"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
        </div>
        
        <?php  
               template::get_the_footer();
        ;?>
        
    </div>        
    </body>
</html>
