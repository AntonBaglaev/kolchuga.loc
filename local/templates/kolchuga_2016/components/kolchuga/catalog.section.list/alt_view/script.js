$(function(){
  $('body').on('click', '.alt_section .as_title', function(e){
    var objThis = $(this);
    var objParent = objThis.parent('.alt_section');

    if(objParent.hasClass('as_0')){
      objParent.removeClass('as_0').addClass('as_1');
    }else{
      objParent.removeClass('as_1').addClass('as_0');
    } 
  });
});