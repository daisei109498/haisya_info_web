$(function(){
    $('input').keypress(function(e){
        if(e.which == 13) {
            return false;
        }
    });
});