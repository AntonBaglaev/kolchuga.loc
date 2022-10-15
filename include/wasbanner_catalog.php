

<script src="<?=SITE_TEMPLATE_PATH?>/plugins/arcticmodal/jquery.arcticmodal-0.3r.min.js"></script>
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/plugins/arcticmodal/jquery.arcticmodal-0.3r.css">
<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/plugins/arcticmodal/themes/simple.css?<?=time()?>">

<div style="display: none;">
	<div class="box-modal" id="boxUserFirstInfo">
		<?/* <div class="box-modal_close arcticmodal-close">X</div> */?>
		<br> 
		<h3>Уважаемые клиенты!</h3><br>
		
		<p>Обращаем ваше внимание, на сайте kolchuga.ru используются материалы с возрастным ограничением 18+. Если вам меньше 18 лет просьба покинуть сайт kolchuga.ru. Лицензионная продукция на сайте kolchuga.ru представлена в ознакомительных целях, и не может быть оплачена и приобретена дистанционным способом.</p>
		<div class="knopka text-center">
						<a class="arcticmodal-close mx-auto" href="javascript:void(0);" style="padding: 10px 20px; display: block;color: #ffffff;background: #21385e;max-width: 300px;">Ознакомлен(а)</a>
					</div> 
		
	</div>
</div>

<?$coo='licenz_bancatalog';?>

<script>
(function($) {
$(function() {

	// Проверим, есть ли запись в куках о посещении посетителя
	// Если запись есть - ничего не делаем
	if (!$.cookie('<?=$coo?>')) {

		function getWindow(){
			// Покажем всплывающее окно
			$('#boxUserFirstInfo').arcticmodal({
				closeOnOverlayClick: false,
				closeOnEsc: true,
				
			});
        };
 
        setTimeout (getWindow, 3000);
		

	}

	// Запомним в куках, что посетитель к нам уже заходил
	$.cookie('<?=$coo?>', true, {
		expires: 5,
		path: '/'
	});

})
})(jQuery)
</script>
