<?php
	if($USER->IsAdmin()) {
		IncludeModuleLangFile(__FILE__);

		$module_id = 'star.copyright';

		$sites_list = array();
		$sites_arr = CSite::GetList($by="def", $order="desc", array("ACTIVE"=>"Y"));
		while ($site = $sites_arr->Fetch())
		{
			$sites_list[] = array($site["LID"] => $site["NAME"]);
		}
		for($i=0;$i<count($sites_list);$i++){
	        $keys = array_keys($sites_list[$i]);
			$arAllOptions[$i] = Array(
				GetMessage('SETTINGS'),
				Array('ENABLED'.$keys[0], GetMessage('ENABLED'), 'N', Array('checkbox', 'N')),
				Array('TEXT'.$keys[0], GetMessage('TEXT'), GetMessage('TEXT_DEF'), Array('text')),
				
			);
		}

		if($REQUEST_METHOD=='POST' && check_bitrix_sessid()) {

			foreach($arAllOptions as $key=>$option) {
				for($i=0; $i<count($option); $i++) {
                    $name=$option[$i][0];
                    $val=$$name;

                    COption::SetOptionString($module_id, $name, $val, $option[$i][1]);
                }
			}
		}

		$aTabs = array();

		foreach($sites_list as $site_arr){
	      foreach($site_arr as $site_id=>$site_name){
	          $aTabs[] = array('DIV' => 'set'.$site_id, 'TAB' => $site_name, 'TITLE' => GetMessage('MAIN_TAB').' '.$site_name);
	      }
	   }


		$tabControl = new CAdminTabControl('tabControl', $aTabs);
		$tabControl->Begin();

		?>

		<form method="POST" enctype="multipart/form-data" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>" name="garland">
			<?for($i=0;$i<count($aTabs);$i++){?>
				<?$keys = array_keys($sites_list[$i]);?>
				<?$tabControl->BeginNextTab();?>

				<?__AdmSettingsDrawList($module_id, $arAllOptions[$i]);?>

			
			<?}?>
			<?$tabControl->Buttons();?>
			<input type="submit" name="save" value="<?echo GetMessage('SAVE')?>"/>
			<?=bitrix_sessid_post();?>

			<?$tabControl->EndTab();?>
			<?$tabControl->End();?>
		</form>

		
<? } ?>
