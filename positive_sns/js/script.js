$(function(){
    $('.edit_user').click(function(){
        $(this).hide();
        var userName = $(this).parent('td').siblings('td').eq(1).find('.user_list_name');
        var userNameData = userName.html();
        var userId = $(this).parent('td').siblings('td').eq(0).html();
        userName.html('<input type="text" name="user_name_edit" value="' + userNameData + '"><input type="hidden" name="user_id_edit" value="'+ userId +'"><input type="submit" name="submit" value="保存">');
    });
    
    $('.dear_name').change(function(){
        var fromVal = $('.from_name').val();
        var dearVal = $('.dear_name').val();
        if(fromVal == dearVal ){
            alert('自分以外の人を選択してください！');            
        }
    });
    
    
    
});