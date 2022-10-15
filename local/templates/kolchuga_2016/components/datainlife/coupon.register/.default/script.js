$(document).on('click', 'div.main__btn a', function () {
	var sesias= $(this).attr('data-sesias');
	$('div.main__btn').load(location.href+'?check='+sesias+'&set=STATUS_CANCEL'); 
	setTimeout(function() {window.location.reload();}, 2000);
	
});