<?php
    require 'DbUtil.php';
    $categoryName = filter_input(INPUT_POST,'category_name');
    $postTitle = filter_input(INPUT_POST,'post_title');
    $postContent = filter_input(INPUT_POST,'post_content');
    $postSubmit = filter_input(INPUT_POST,'submit');
    
    if($postSubmit == '投稿'){
        $postPdo = new DbUtil();
        $postPdo->insertPost($categoryName,$postTitle,$postContent);
        $uri = $_SERVER['HTTP_REFERER'];
        header("Location: ".$uri, true, 303);
    }else{
        $uri = $_SERVER['HTTP_REFERER'];
        header("Location: ".$uri, true, 303);
    }
    
;?>