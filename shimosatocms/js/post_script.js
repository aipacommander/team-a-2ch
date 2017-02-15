$(function(){
    $('.edit_category').click(function(){
        $(this).hide();
        var cateName = $(this).parent('td').siblings('td').eq(1).find('.category_list_name');
        var cateNameData = cateName.html();
        var cateId = $(this).parent('td').siblings('td').eq(0).html();
        cateName.html('<input type="text" name="category_name_edit" value="' + cateNameData + '"><input type="hidden" name="category_id" value="'+ cateId +'"><input type="submit" name="submit" value="保存">');
    });
});