
<?
CJSCore::Init(array("jquery"));
$module_id = 'star.comingsoon'; 

$date_today = date("d.m.Y");
$sites_list = array();
$sites_arr = CSite::GetList($by="def", $order="desc", array("ACTIVE"=>"Y"));
while ($site = $sites_arr->Fetch())
{
	$sites_list[] = array($site["LID"] => $site["NAME"]);
}
?>

<?
global $MESS;

IncludeModuleLangFile(__FILE__);

CModule::IncludeModule($module_id);
$MOD_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($MOD_RIGHT>="R"):
    $arAllOptions = array();
    for($i=0;$i<count($sites_list);$i++){
        $keys = array_keys($sites_list[$i]);
        $arAllOptions[$i] = array(
            Array("STAR_COMINGSOON_checkbox_".$keys[0], GetMessage("STAR_COMINGSOON_CHECKBOX"), "N", Array("checkbox", "Y")),
            
			Array("selectbox_theme_".$keys[0], GetMessage("STAR_COMINGSOON_THEME"), "blue", Array("selectbox", array('dark'=>GetMessage("STAR_COMINGSOON_THEME_DARK"), 'white'=>GetMessage("STAR_COMINGSOON_THEME_WHITE"), 'blue'=>GetMessage("STAR_COMINGSOON_THEME_BLUE"), 'pink'=>GetMessage("STAR_COMINGSOON_THEME_PINK")))),
            Array("STAR_COMINGSOON_header_".$keys[0], GetMessage("STAR_COMINGSOON_HEADER"), GetMessage("STAR_COMINGSOON_HEADER_EX"), Array("text", "")),
            Array("STAR_COMINGSOON_logo_".$keys[0], GetMessage("STAR_COMINGSOON_LOGO"), "/bitrix/themes/.default/".$module_id."/simple/images/logo.jpg", Array("text", "")),
            Array("STAR_COMINGSOON_text_".$keys[0], GetMessage("STAR_COMINGSOON_TEXT"), GetMessage("STAR_COMINGSOON_TEXT_EX"), Array("textarea", "4","40")),
            Array("STAR_COMINGSOON_title_".$keys[0], GetMessage("STAR_COMINGSOON_TITLE"), GetMessage("STAR_COMINGSOON_TITLE_EX"), Array("textarea", "4","40")),
			Array("STAR_COMINGSOON_phone_".$keys[0], GetMessage("STAR_COMINGSOON_PHONE"), GetMessage("STAR_COMINGSOON_PHONE_EX"), Array("text", "")),
			Array("STAR_COMINGSOON_phone2_".$keys[0], GetMessage("STAR_COMINGSOON_PHONE2"), GetMessage("STAR_COMINGSOON_PHONE_EX"), Array("text", "")),
			Array("STAR_COMINGSOON_email_".$keys[0], GetMessage("STAR_COMINGSOON_EMAIL"), GetMessage("STAR_COMINGSOON_EMAIL_EX"), Array("text", "")),
           Array("STAR_COMINGSOON_date_".$keys[0], GetMessage("STAR_COMINGSOON_DATE"), $date_today, Array("text", "")),

            Array("STAR_COMINGSOON_VK_".$keys[0], GetMessage("STAR_COMINGSOON_VK"), '', Array("text", "")),
            Array("STAR_COMINGSOON_FB_".$keys[0], GetMessage("STAR_COMINGSOON_FB"), '', Array("text", "")),
            Array("STAR_COMINGSOON_INSTA_".$keys[0], GetMessage("STAR_COMINGSOON_INSTA"), '', Array("text", "")),
            Array("STAR_COMINGSOON_TELE_".$keys[0], GetMessage("STAR_COMINGSOON_TELE"), '', Array("text", "")),
        );
		
		$arAllOptions_part1[$i] = array(
            Array("STAR_COMINGSOON_checkbox_".$keys[0], GetMessage("STAR_COMINGSOON_CHECKBOX"), "N", Array("checkbox", "Y")),
            
			Array("selectbox_theme_".$keys[0], GetMessage("STAR_COMINGSOON_THEME"), "page1", 
				Array("selectbox", array(
					'page1'=>GetMessage("STAR_COMINGSOON_THEME_PAGE1"), 
					'page2'=>GetMessage("STAR_COMINGSOON_THEME_PAGE2"), 
					'page3'=>GetMessage("STAR_COMINGSOON_THEME_PAGE3"), 
					'page4'=>GetMessage("STAR_COMINGSOON_THEME_PAGE4"),
					'page5'=>GetMessage("STAR_COMINGSOON_THEME_PAGE5"),
					'page6'=>GetMessage("STAR_COMINGSOON_THEME_PAGE6"),

				))),
            Array("STAR_COMINGSOON_header_".$keys[0], GetMessage("STAR_COMINGSOON_HEADER"), GetMessage("STAR_COMINGSOON_HEADER_EX"), Array("text", "")),
		);
		$arAllOptions_part2[$i] = array(
			Array("STAR_COMINGSOON_text_".$keys[0], GetMessage("STAR_COMINGSOON_TEXT"), GetMessage("STAR_COMINGSOON_TEXT_EX"), Array("textarea", "4","40")),
			Array("STAR_COMINGSOON_title_".$keys[0], GetMessage("STAR_COMINGSOON_TITLE"), GetMessage("STAR_COMINGSOON_TITLE_EX"), Array("textarea", "4","40")),
			Array("STAR_COMINGSOON_phone_".$keys[0], GetMessage("STAR_COMINGSOON_PHONE"), GetMessage("STAR_COMINGSOON_PHONE_EX"), Array("text", "")),
			Array("STAR_COMINGSOON_phone2_".$keys[0], GetMessage("STAR_COMINGSOON_PHONE2"), GetMessage("STAR_COMINGSOON_PHONE_EX"), Array("text", "")),
			Array("STAR_COMINGSOON_email_".$keys[0], GetMessage("STAR_COMINGSOON_EMAIL"), GetMessage("STAR_COMINGSOON_EMAIL_EX"), Array("text", "")),

			Array("STAR_COMINGSOON_VK_".$keys[0], GetMessage("STAR_COMINGSOON_VK"), '', Array("text", "")),
            Array("STAR_COMINGSOON_FB_".$keys[0], GetMessage("STAR_COMINGSOON_FB"), '', Array("text", "")),
            Array("STAR_COMINGSOON_INSTA_".$keys[0], GetMessage("STAR_COMINGSOON_INSTA"), '', Array("text", "")),
            Array("STAR_COMINGSOON_TELE_".$keys[0], GetMessage("STAR_COMINGSOON_TELE"), '', Array("text", "")),
		);
		
    }
    if($MOD_RIGHT>="W"):
        if ($REQUEST_METHOD=="GET" && strlen($RestoreDefaults)>0)
        {
			COption::RemoveOption($module_id);
            reset($arGROUPS);
            while(list(,$value)=each($arGROUPS))
                $APPLICATION->DelGroupRight($module_id, array($value["ID"]));
			?>
			<?
			 for($i=0;$i<1;$i++){
				$keys = array_keys($sites_list[$i]);?>
				<script>
				$(document).ready(function() {
					$('#STAR_COMINGSOON_checkbox_<?=$keys[0]?>').attr('checked', 'checked').prop('checked', 'checked');
				});
				</script>
				<?
			 }
			?>
			<script>
				$('form[name="siteclose"]').ready(function() {
					$('form[name="siteclose"]').submit();
					
				});
			</script>
			<?
        }
		
        if($REQUEST_METHOD=="POST" && strlen($Update)>0)
        {
			if(count($_FILES) > 0) {
				foreach($_FILES as $in_name=>$arFile) {
					$error_im = 1;
					if($arFile['type'] != '') {
						$error_im = 0;
						$parts=explode("/", $arFile['type']);
						$type = $parts[0];
						if ($type != "image"){$arError = GetMessage("STAR_COMINGSOON_FILE_ERROR"); $error_im = 1;}
						if(!$arError){
							$arFile_name_1 = explode('.',$arFile['name']);
							$img_type = $arFile_name_1[count($arFile_name_1)-1];
							unset($arFile_name_1[count($arFile_name_1)-1]);
							$File_name_1 = implode('.',$arFile_name_1);
							$arParams = array("replace_space"=>"_","replace_other"=>"-");
							$file_name = Cutil::translit($File_name_1, "ru", $arParams);
							$file_name = $file_name.'.'.$img_type;
							$uploadfile = $_SERVER['DOCUMENT_ROOT']."/bitrix/themes/.default/".$module_id."/".$file_name;
							move_uploaded_file($arFile['tmp_name'], $uploadfile);
						}
					}
					if($error_im != 1)
						$_POST[str_replace('file_', '', $in_name)] = "/bitrix/themes/.default/".$module_id."/".$file_name;
					else
						$_POST[$in_name] = '';
				}
			}
            foreach($arAllOptions as $key=>$option){

            	$loggi = "STAR_COMINGSOON_logo_".$keys[0];
				$$loggi = $_POST["STAR_COMINGSOON_logo_".$keys[0]];
				
                for($i=0; $i<count($option); $i++) {
                    $name=$option[$i][0];
                    $val=$$name;

                    COption::SetOptionString($module_id, $name, $val, $option[$i][1]);
                }
            }
        }
    endif; ?>
<?if($arError):?>
	<div class="adm-info-message-wrap adm-info-message-red">
	<div class="adm-info-message">
		<div class="adm-info-message-title"><?=GetMessage("STAR_COMINGSOON_ERROR")?></div>
			<?=$arError?>
		<div class="adm-info-message-icon"></div>
	</div>
</div>
<?endif;?>
	
<?
   $aTabs = array();
   foreach($sites_list as $site_arr){
      foreach($site_arr as $site_id=>$site_name){
          $aTabs[] = array('DIV' => 'set'.$site_id, 'TAB' => $site_name, 'ICON' => 'STAR_COMINGSOON_settings', 'TITLE' => GetMessage('STAR_COMINGSOON_MAIN_TITLE').' '.$site_name);
      }
   }

   $tabControl = new CAdminTabControl('tabControl', $aTabs);
   $tabControl->Begin();
?>
<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialchars($mid)?>&lang=<?echo LANG?>" enctype="multipart/form-data" name="siteclose">
	<?for($i=0;$i<count($aTabs);$i++):?>
		<?$keys = array_keys($sites_list[$i]);?>
		<?$tabControl->BeginNextTab();?>
		
		<?__AdmSettingsDrawList($module_id, $arAllOptions_part1[$i]);?>
		<tr>
			<td><?=GetMessage("STAR_COMINGSOON_LOGO")?></td>
			<td>
				<?if(COption::GetOptionString($module_id, "STAR_COMINGSOON_logo_".$keys[0], '', $keys[0]) != ''):?> 
					<input type="text" name="STAR_COMINGSOON_logo_<?=$keys[0]?>" value="<?echo COption::GetOptionString($module_id, "STAR_COMINGSOON_logo_".$keys[0], '', $keys[0])?>">
				<?endif;?>
				<input type="file" name="STAR_COMINGSOON_logo_file_<?=$keys[0]?>" value="<?//echo COption::GetOptionString($module_id, "STAR_COMINGSOON_logo_".$keys[0], '', $keys[0])?>">
			</td>
		</tr>
		<?__AdmSettingsDrawList($module_id, $arAllOptions_part2[$i]);?>
		<tr>
			<td><?=GetMessage("STAR_COMINGSOON_DATE")?></td>
			<td>
			<?$APPLICATION->IncludeComponent(
			   "bitrix:main.calendar",
			   "",
			   Array(
				  "SHOW_INPUT" => "Y",
				  "FORM_NAME" => "siteclose",               
				  "INPUT_NAME" => "STAR_COMINGSOON_date_".$keys[0],					
				  "INPUT_VALUE" => COption::GetOptionString($module_id, "STAR_COMINGSOON_date_".$keys[0]),                      
				  "SHOW_TIME" => "Y",                       
				  "HIDE_TIMEBAR" => "N"                     
			   ),
			false
			);?>
			</td>
		<tr>
	<?endfor;?>
	
    <?$tabControl->Buttons();?>
    <script type="text/javascript">
        function RestoreDefaults()
        {
            //if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANG?>&mid=<?echo urlencode($mid)?>";
        }
    </script>
    <input type="submit" name="Update" <?if ($MOD_RIGHT<'W') echo "disabled" ?> value="<?echo GetMessage('MAIN_SAVE')?>" class="adm-btn-save">
    <input type="hidden" name="Update" value="Y">
    <?=bitrix_sessid_post();?>
    <input type="button" <?if ($MOD_RIGHT<'W') echo "disabled" ?> title="<?echo GetMessage('MAIN_HINT_RESTORE_DEFAULTS')?>" OnClick="RestoreDefaults();" value="<?echo GetMessage('MAIN_RESTORE_DEFAULTS')?>">

    <?$tabControl->End();?>

</form>
<?endif;?>