$(document).ready(function(){
	$('.js-filter-pict').on('ifChanged', function(e){
		var _i = $(this);

		if(!_i.is(':checked')) 
			$('<input name="NOT_PICTURE_ONLY" value="1" type="hidden" class="js-filter-pict-hid">').insertAfter(_i);
		else
			_i.parents('form').find('.js-filter-pict-hid').remove();	
	});

	$('.js-sort-sel').on('selectric-change', function(){
		$('input[name="sort_order"]').val($(this).find('option:selected').data('order'));
	});
    

  jQuery("#filter .b-filter__title").click(function(e){
  e.preventDefault();
    
      var filter = jQuery(this).closest("#filter");
    
      if (!filter.hasClass("active"))
      {
        filter.find(".b-ffr").stop().slideDown(300, function(){
          
          if (!filter.hasClass("active"))
          {
            filter.addClass("active");
          }
          
        });
      }
      else
      {
         filter.find(".b-ffr").stop().slideUp(300, function(){ 
           
          if (filter.hasClass("active"))
          {
            filter.removeClass("active");
          } 
           
         });
      }
    
  });
  
});