$(document).ready(function () {

	//Таймер
	var time = $('.timer').attr('data-timer');
	$('.timer').countdown({
		until: time,
		layout: '{dn} {dl} {hn}:{mn}:{sn}',
		expiryUrl: '/',
	});

});
