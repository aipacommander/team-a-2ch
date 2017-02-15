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
                <h2>管理画面TOP</h2>
            </div>
            
            <div class="container clearfix">
        
                <?php  
                    template::get_the_side();
                ;?>

                <div class="main topmain">
                        <p class="dashCaption">SimosatoCMSへようこそ</p>
                </div>
        </div>
        
        <?php  
               template::get_the_footer();
        ;?>
        
    </div>        
    </body>
</html>
