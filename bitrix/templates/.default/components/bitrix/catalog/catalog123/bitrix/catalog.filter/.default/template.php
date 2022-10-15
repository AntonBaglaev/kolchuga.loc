<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<link href="/css/dropkick.css" rel="stylesheet" />
<script type="text/javascript" src="/js/jquery.ui-slider.js"></script>
<?/*script type="text/javascript" src="/js/jquery.dropkick-1.0.0.js"></script*/?>

<script type="text/javascript">
<?
// тупость но буду искать подстроки, надо переделать на preg_match
//$_input = '<input name="arrFilter_cf[2][LEFT]" size="5" value="100" type="text">&nbsp;по&nbsp;<input name="arrFilter_cf[2][RIGHT]" size="5" value="1000000000" type="text">';
$_input = $arResult["ITEMS"][3]["INPUT"];
$first_name_pos = strpos($_input, 'value="')+7;
if($_input[$first_name_pos] == '"'){
        $min_price = '';
        $first_name_pos_end = $first_name_pos+1;
}else{
        $first_name_pos_end = strpos($_input, '"', $first_name_pos+1);
        $min_price = substr($_input, $first_name_pos, ($first_name_pos_end - $first_name_pos));
}

$first_name_pos = strpos($_input, 'value="', $first_name_pos_end)+7;
if($_input[$first_name_pos] == '"'){
        $max_price = '';
}else{  
        $first_name_pos_end = strpos($_input, '"', $first_name_pos+1);
        $max_price = substr($_input, $first_name_pos, ($first_name_pos_end - $first_name_pos));
		if($max_price == 'type=') $max_price = '';
}

$_input = $arResult["ITEMS"][3]["INPUT"];
$first_name_pos = strpos($_input, 'value="')+7;
if($_input[$first_name_pos] == '"'){
        $good_section_id = 0;
        $first_name_pos_end = $first_name_pos+1;
}else{
        $first_name_pos_end = strpos($_input, '"', $first_name_pos+1);
        $good_section_id = substr($_input, $first_name_pos, ($first_name_pos_end - $first_name_pos));
}

$max_range_price = 0;
if($good_section_id > 0){
	$results = $DB->Query("select MAX(bcp.PRICE) as max_price from b_catalog_price as bcp left join b_iblock_element as ibe on (ibe.ID = bcp.PRODUCT_ID) where (ibe.IBLOCK_SECTION_ID = {$good_section_id});");
	$row = $results->Fetch();
	$max_range_price = (double)$row['max_price'];
}
if($max_range_price < 0.01) $max_range_price = 2000000;

$debug_str = $first_name_pos.'|'.$first_name_pos_end.'|'.$min_price.'|'.$max_price.'|'.$max_range_price;

?>
	function setCookie (name, value, expires, path, domain, secure) {
		  document.cookie = name + "=" + escape(value) +
			((expires) ? "; expires=" + expires : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
	}
	
	$(document).ready(function(){
		$('#good_filter_form').submit(function(){
			new_value = $('#number_goods').val();
			setCookie('PAGE_ELEMENT_COUNT', new_value, 1000000000, '/');
		});

		$("#slider").slider({
			min: 0,
			max: <?=(int)$max_range_price?>,
			values: [<?=(int)$min_price?>,<?=(int)$max_price?>],
			range: true,
			stop: function(event, ui) {
				$("input#minCost").val($("#slider").slider("values",0));
				$("input#maxCost").val($("#slider").slider("values",1));
				
			},
			slide: function(event, ui){
				$("input#minCost").val($("#slider").slider("values",0));
				$("input#maxCost").val($("#slider").slider("values",1));
			}
		});

		$("input#minCost").change(function(){

			var value1=$("input#minCost").val();
			var value2=$("input#maxCost").val();

			if(parseInt(value1) > parseInt(value2)){
				value1 = value2;
				$("input#minCost").val(value1);
			}
			$("#slider").slider("values",0,value1);	
		});

			
		$("input#maxCost").change(function(){
				
			var value1=$("input#minCost").val();
			var value2=$("input#maxCost").val();
			
			if (value2 > 900000) { value2 = 900000; $("input#maxCost").val(900000)}

			if(parseInt(value1) > parseInt(value2)){
				value2 = value1;
				$("input#maxCost").val(value2);
			}
			$("#slider").slider("values",1,value2);
		});



		// фильтрация ввода в поля
			$('.filter_block .price_td input').keypress(function(event){
				var key, keyChar;
				if(!event) var event = window.event;
				
				if (event.keyCode) key = event.keyCode;
				else if(event.which) key = event.which;
			
				if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
				keyChar=String.fromCharCode(key);
				
				if(!/\d/.test(keyChar))	return false;
			
			});
		$('.ui-slider .ui-slider-handle:first').addClass('first_button');
		/**/
		$(".chzn-select").dropkick();
	});

</script>

<div class="filter_block">
	<div class="filter_block_blue bdr dib">
		<form id="good_filter_form" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">

			<?foreach($arResult["ITEMS"] as $arItem):
				if(array_key_exists("HIDDEN", $arItem)):
					echo $arItem["INPUT"];
				endif;
			endforeach;?>
			
			<table class="filtr_table">
				<thead>
					<tr>
						<th><span class="adventure">Стоимость</span></th>
						<!--th><span class="adventure">Название</span></th>
						<th><span class="adventure">Модель</span></th-->
					<!-- </tr>
					<tr>
						<td>
							<div id="slider"></div>
						</td> -->
						<td>
							<span class="adventure">Показывать</span>
							<select style="width: 26px; display: none;" id="number_goods" class="chzn-select" name="namenumber_goods">
								<option value="9"<?if($_COOKIE['PAGE_ELEMENT_COUNT'] == 9):?> SELECTED<?endif;?>>по 9</option>
								<option value="21"<?if($_COOKIE['PAGE_ELEMENT_COUNT'] == 21):?> SELECTED<?endif;?>>по 21</option>
								<option value="1000000000"<?if($_COOKIE['PAGE_ELEMENT_COUNT'] == 1000000000):?> SELECTED<?endif;?>>все</option>
							</select>
						</td>
						<!--td>
							<input type="text" name="<?=$arResult["ITEMS"][0]["INPUT_NAME"]?>" value="<?=$arResult["ITEMS"][0]["INPUT_VALUE"]?>" class="input_inside" style="width:156px;" />
						</td>
						<td-->
							<!--select name="<?=$arResult["ITEMS"][1]["INPUT_NAME"]?>" class="chzn-select" id="vendor_goods" style="width:110px;" >
								<option value=""<?if($arResult["ITEMS"][1]["INPUT_VALUE"] == ''):?> SELECTED<?endif;?>>Не выбрано</option -->
								
								<!-- здесь найдем список возможных моделей в секции -->
								<?/*
								$model_list = array();
								// найдем все значения свойства Номер модели
								if($good_section_id > 0){
									$results = $DB->Query("select distinct ibep.VALUE from b_iblock_element_property as ibep left join b_iblock_element as ibe on (ibe.ID = ibep.IBLOCK_ELEMENT_ID) where (ibe.IBLOCK_SECTION_ID = {$good_section_id}) AND (ibep.IBLOCK_PROPERTY_ID = 78)");
									while ($row = $results->Fetch()){
										$model_list[] = $row['VALUE'];
									}
								}
								foreach((array)$model_list as $model_number){
										<option value="<?=$model_number?>"<?if($arResult["ITEMS"][1]["INPUT_VALUE"] == $model_number):?> SELECTED<?endif;?>><?=$model_number?></option>
								}*/?>
							<!--/select-->
						<!--/td-->
					</tr>
					<tr>
						<td class="price_td">
							<span>от</span>
							<input type="text" size="5" name="arrFilter_cf[2][LEFT]" class="input_inside" id="minCost" value="<?=$min_price?>" /> 
							<span>до</span>
							<input type="text" size="6" name="arrFilter_cf[2][RIGHT]" class="input_inside" id="maxCost" value="<?=$max_price?>" /> 
							<span>руб.</span>
						</td>
						<td>
							<div class="submit_blue">
								<input type="submit" name="set_filter" value="Найти" /><input type="hidden" name="set_filter" value="Y" />
							</div>  
							<div class="submit_blue">
								<input type="submit" name="del_filter" value="Сброс" />
							</div>
						</td>
					</tr>
				</thead>
				
			</table>
<!--	
			<pre>
			
		
			<?
			//echo print_r($arResult);
			//echo $debug_str;
			?>
			</pre>
			

			<table class="data-table" cellspacing="0" cellpadding="2">
			<tbody>
				<?/*foreach($arResult["ITEMS"] as $akey => $arItem):?>
					<?if(!array_key_exists("HIDDEN", $arItem) && ($akey > 1)):?>
						<tr>
							<td valign="top"><?=$arItem["NAME"]?>:</td>
							<td valign="top"><?=$arItem["INPUT"]?></td>
						</tr>
					<?endif?>
				<?endforeach;*/?>
			</tbody>
			</table>
			
-->			
			
		</form>
	</div>
</div>