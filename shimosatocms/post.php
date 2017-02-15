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
                <h2>投稿ページ</h2>
            </div>
            
            <div class="container clearfix">
        
                <?php  
                    template::get_the_side();
                ;?>

                <div class="main">
                    <div class="post_box clearfix">
                        <form action="_util/post_db.php" method="post">
                            <table class="post_table01">
                                <tr><th>カテゴリー</th>
                                <td>
                                    <select name="category_name">
                                    <?php 
                                        foreach ($categoryData as $row){
                                            if(!empty($row)){
                                                echo '<option value="' .$row["category_name"]. '" >'.$row["category_name"].'</option>';
                                            }
                                        }
                                    ;?>                     
                                    </select>
                                </td>
                                </tr>
                            </table>
                            
                            <dl>
                               <dt>タイトル</dt><dd><input type="text" name="post_title"></dd>
                               <dt>本文<dt><dd><textarea name="post_content" id="article"></textarea></dd>
                            </dl>
                            
                            <div class="submit_box clearfix">
                                <input type="submit" value="プレビュー" name="submit" class="preview fl">
                                <input type="submit" value="投稿" name="submit" class="toukou fr">  
                            </div>
                            
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
