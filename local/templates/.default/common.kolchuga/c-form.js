if (typeof(jQuery) != "undefined")
{
	jQuery(document).ready(function(){

		setTimeout(function(){
			jQuery("form").each(function(){
				if (jQuery(this).find("input[name='WEB_FORM_ID']").length > 0)
				{
					jQuery(this).append('<input type="hidden" name="CS_SESSION_FORM" value="ExSess'+jQuery(this).find("input[name='WEB_FORM_ID']").val()+'"/>');
				}
			});
		}, 1000);
		
	});
}