<?php
    require 'DbUtil.php';
    $categorySubmit = filter_input(INPUT_POST,'submit');
    $categoryNameEdit = filter_input(INPUT_POST,'user_name_edit');
    $categoryId = filter_input(INPUT_POST,'category_id');
    
    if($categorySubmit == '追加'){
        $categoryPdo = new DbUtil();
        $categoryPdo->insertCategry($categoryName);
        $uri = $_SERVER['HTTP_REFERER'];
        header("Location: ".$uri, true, 303);
    }
    
    if($categorySubmit == '保存'){        
        $categoryPdo = new DbUtil();
        $categoryPdo->editCategory($categoryId,$categoryNameEdit);
        $uri = $_SERVER['HTTP_REFERER'];
        header("Location: ".$uri, true, 303);
    }
    
;?>