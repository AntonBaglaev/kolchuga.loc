<?
if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="getphpversion")
{
	$res = '';
	if(isset($_REQUEST['path']) && strlen($_REQUEST['path']) > 0)
	{
		$phpPathTmp = $_REQUEST['path'];
		$phpPath = htmlspecialchars($phpPathTmp);
		$arPhpLines = array();
		@exec($phpPath.' -v', $arPhpLines);
		if(is_array($arPhpLines) && isset($arPhpLines[0]) && preg_match('/PHP\s*([\d\.]+)/i', $arPhpLines[0], $m) && !isset($arVersions[$m[1]]))
		{
			$res = $m[1];
		}
	}
	echo $res;
	die();
}

if(!defined('NO_AGENT_CHECK')) define('NO_AGENT_CHECK', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
$moduleId = 'esol.importxml';
CModule::IncludeModule('iblock');
CModule::IncludeModule($moduleId);
IncludeModuleLangFile(__FILE__);

$sess = $_SESSION;
session_write_close();
$_SESSION = $sess;

$suffix = '';
$cronFrame = 'cron_frame.php';
if($_GET['suffix']=='highload') 
{
	$suffix = 'highload';
	$cronFrame = 'cron_frame_highload.php';
}

define("ESOL_IX_PATH2EXPORTS", "/bitrix/php_interface/include/".$moduleId."/");

$cfg_data = "";
$arLines = array();
$isSystem = false;
@exec('crontab -l', $arLines);
if(is_array($arLines))
{
	$cfg_data = implode("\n", $arLines);
	$isSystem = true;
}
if(strlen(trim($cfg_data))==0 && file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg"))
{
	$cfg_data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
}

$needSave = false;
if(preg_match_all("#^.*?".preg_quote(ESOL_IX_PATH2EXPORTS).$cronFrame." +(\d+) *>.*?$#im", $cfg_data, $m))
{
	$arIds = array();
	foreach($m[1] as $pid)
	{
		$arIds[] = (int)$pid + 1;
	}
	$oProfile = new \Bitrix\EsolImportxml\Profile($suffix);
	$arProfiles = $oProfile->GetList(array('ID'=>$arIds));
	foreach($m[1] as $pid)
	{
		if(!array_key_exists((int)$pid, $arProfiles))
		{
			$cfg_data = preg_replace("#^.*?".preg_quote(ESOL_IX_PATH2EXPORTS).$cronFrame." +".$pid." *>.*?$#im", "", $cfg_data);
			$needSave = true;
		}
	}
}
if($_REQUEST["action"]=="deleterecord" && $_REQUEST["key"])
{
	list($time, $pids) = explode('|', $key);
	if(strlen($time) > 0 && strlen($pids) > 0)
	{
		$cfg_data = preg_replace("#^\s*".preg_quote($time)."\s+.*?".preg_quote(ESOL_IX_PATH2EXPORTS).$cronFrame." +".preg_quote($pids)." *>.*?$#im", "", $cfg_data);
		$needSave = true;
	}
}
if($needSave)
{
	$cfg_data = preg_replace("#\n{3,}#im", "\n\n", $cfg_data);
	$cfg_data = trim($cfg_data, "\r\n ")."\n";
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", $cfg_data);
	
	if($isSystem)
	{
		@exec("crontab ".$_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
	}
	if($_REQUEST["action"]=="deleterecord") die();
}

if ($_REQUEST["action"]=="save")
{
	define('PUBLIC_AJAX_MODE', 'Y');
	$strErrorMessage = $strSuccessMessage = '';
	
	if(is_array($PROFILE_ID)) $PROFILE_ID = implode(',', $PROFILE_ID);
	if (strlen($PROFILE_ID) < 1)
	{
		$strErrorMessage .= GetMessage("ESOL_IX_CRON_NOT_PROFILE")."\n";
	}

	if (strlen($strErrorMessage)<=0 && $_REQUEST["subaction"]=='add')
	{
		/*$agent_period = intval($_REQUEST["agent_period"]);
		$agent_hour = Trim($_REQUEST["agent_hour"]);
		$agent_minute = Trim($_REQUEST["agent_minute"]);

		if ($agent_period<=0 && (strlen($agent_hour)<=0 || strlen($agent_minute)<=0))
		{
			$agent_period = 24;
			$agent_hour = "";
			$agent_minute = "";
		}
		elseif ($agent_period>0 && strlen($agent_hour)>0 && strlen($agent_minute)>0)
		{
			$agent_period = 0;
		}*/
		
		$periodType = $_REQUEST["agent_period_type"];
		if($periodType=='daily')
		{
			$strTime = (int)$_REQUEST['agent_period_daily_minutes']." ".(int)$_REQUEST['agent_period_daily_hours']." * * * ";
		}
		elseif($periodType=='hours')
		{
			$strTime = "0 */".max(1, intval($_REQUEST['agent_period_hours']))." * * * ";
		}
		elseif($periodType=='minutes')
		{
			$strTime = "*/".max(1, (strlen($_REQUEST['agent_period_minutes']) > 0 ? intval($_REQUEST['agent_period_minutes']) : 15))." * * * * ";
		}
		elseif($periodType=='expert')
		{
			$strTime = $_REQUEST['agent_period_expert']." ";
		}

		$agent_php_path = Trim($_REQUEST["agent_php_path"]);
		if (strlen($agent_php_path)<=0) $agent_php_path = "/usr/bin/php";

		CheckDirPath($_SERVER["DOCUMENT_ROOT"].ESOL_IX_PATH2EXPORTS."logs/");
		if (strlen($PROFILE_ID) > 0)
		{
			//if ($agent_period>0)
			//{
			//	$strTime = "0 */".$agent_period." * * * ";
			//}
			//else
			//{
			//	$strTime = intval($agent_minute)." ".intval($agent_hour)." * * * ";
			//}

			// add
			$cfg_data = trim($cfg_data, "\r\n ");
			if (strlen($cfg_data)>0) $cfg_data .= "\n";
			$execFile = $_SERVER["DOCUMENT_ROOT"].ESOL_IX_PATH2EXPORTS.$cronFrame;
			$logFile = $_SERVER["DOCUMENT_ROOT"].ESOL_IX_PATH2EXPORTS."logs/".str_replace(',', '_', $PROFILE_ID).".txt";
			if(\Bitrix\EsolImportxml\ClassManager::VersionGeqThen('main', '20.100.0'))
			{
				$phpParams = '-d default_charset='.\Bitrix\EsolImportxml\Utils::getSiteEncoding();
			}
			else
			{
				if(\Bitrix\EsolImportxml\Utils::getSiteEncoding()=='utf-8') $phpParams = '-d mbstring.func_overload=2 -d mbstring.internal_encoding=UTF-8';
				else $phpParams = '-d mbstring.func_overload=0 -d mbstring.internal_encoding=CP1251';
			}
			$phpParams .= ' -d short_open_tag=on -d memory_limit=1024M';
			$cfg_subdata = $strTime.$agent_php_path." ".$phpParams." -f ".$execFile." ".$PROFILE_ID." >".$logFile."\n";
			if(strpos($cfg_data, $cfg_subdata)===false) $cfg_data .= $cfg_subdata;
			$strSuccessMessage .= GetMessage("ESOL_IX_CRON_PANEL_CONFIG")."<br><br><i>".$cfg_subdata.'</i><br><br>';
			$strSuccessMessage .= GetMessage("ESOL_IX_CRON_WHERE_IS")."<br>";
			$strSuccessMessage .= '<i>'.$strTime.'</i> - '.GetMessage("ESOL_IX_CRON_TIME_EXECUTE_COMMENT")."<br>";
			$strSuccessMessage .= '<i>'.$agent_php_path.'</i> - '.GetMessage("ESOL_IX_CRON_PHP_PATH_COMMENT")."<br>";
			$strSuccessMessage .= '<i>'.$execFile.'</i> - '.GetMessage("ESOL_IX_CRON_EXEC_FILE_COMMENT")."<br>";
			$strSuccessMessage .= '<i>'.$PROFILE_ID.'</i> - '.GetMessage("ESOL_IX_CRON_PROFILE_ID_COMMENT")."<br>";
			$strSuccessMessage .= '<i>'.$logFile.'</i> - '.GetMessage("ESOL_IX_CRON_LOG_FILE_COMMENT")."<br>";
		}
		
		if (strlen($strErrorMessage)<=0)
		{
			CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/");
			//$cfg_data = preg_replace("#[\r\n]{2,}#im", "\n", $cfg_data);
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", $cfg_data);

			if ($_REQUEST["auto_cron_tasks"]=="Y")
			{
				@exec("crontab ".$_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
			}
		}
	}
	
	if (strlen($strErrorMessage)<=0 && $_REQUEST["subaction"]=='delete')
	{
		if (true /*file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg")*/)
		{
			/*$cfg_file_size = filesize($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
			$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", "rb");
			$cfg_data = fread($fp, $cfg_file_size);
			fclose($fp);*/

			$cfg_data = preg_replace("#^.*?".preg_quote(ESOL_IX_PATH2EXPORTS).$cronFrame." +".$PROFILE_ID." *>.*?$#im", "", $cfg_data);

			//$cfg_data = preg_replace("#[\r\n]{2,}#im", "\n", $cfg_data);
			$cfg_data = preg_replace("#\n{3,}#im", "\n\n", $cfg_data);
			$cfg_data = trim($cfg_data, "\r\n ")."\n";
			file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", $cfg_data);

			if ($_REQUEST["auto_cron_tasks"]=="Y")
			{
				@exec("crontab ".$_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
			}
		}
	}
	
	$APPLICATION->RestartBuffer();
	if(ob_get_contents()) ob_end_clean();
		
	if($strErrorMessage)
	{
		CAdminMessage::ShowMessage(array(
			'TYPE' => 'ERROR',
			'MESSAGE' => $strErrorMessage,
			'HTML' => true
		));
	}
	else 
	{
		CAdminMessage::ShowMessage(array(
			'TYPE' => 'OK',
			'MESSAGE' => GetMessage("ESOL_IX_CRON_SAVE_SUCCESS"),
			'DETAILS' => $strSuccessMessage,
			'HTML' => true
		));
	}	
	die();
}
/*$obJSPopup = new CJSPopup();
$obJSPopup->ShowTitlebar(GetMessage("ESOL_IX_CRON_TITLE"));*/

/*Define php path*/
$arPaths = array('/usr/bin/php');
$arLines = array();
@exec('crontab -l', $arLines);
if(is_array($arLines))
{
	foreach($arLines as $line)
	{
		$arLineParts = preg_split('/\s+/', $line);
		if(isset($arLineParts[5]) && !in_array($arLineParts[5], $arPaths) && stripos($arLineParts[5], 'php')!==false)
		{
			$arPaths[] = $arLineParts[5];
		}
	}
}
if(count($arPaths)<3)
{
	ob_start();
	phpinfo();
	$phpinfo = ob_get_clean();
	if(preg_match('/\-\-prefix=([\/\w\.\-\_]+)/i', $phpinfo, $m) && strlen($m[1]) > 1)
	{
		$phpPath = rtrim($m[1], '/').'/bin/php';
		if(!in_array($phpPath, $arPaths))
		{
			$arPaths[] = $phpPath;
		}
	}
}	

$arVersions = array();
if(count($arPaths) > 1)
{
	foreach($arPaths as $phpPath)
	{
		/*$arPhpLines = array();
		@exec($phpPath.' -v', $arPhpLines);
		if(is_array($arPhpLines) && isset($arPhpLines[0]) && preg_match('/PHP\s*([\d\.]+)/i', $arPhpLines[0], $m) && !isset($arVersions[$m[1]]))
		{
			$arVersions[$m[1]] = $phpPath;
		}*/
		$arPhpLines = array();
		//@exec($phpPath.' -h', $arPhpLines);
		if(true /*strpos(implode("\r\n", $arPhpLines), '-v')!==false*/)
		{
			$obRequest = \Bitrix\Main\Context::getCurrent()->getRequest();
			$selfLink = ($_SERVER['SERVER_PORT']==443 || ToLower($_SERVER['HTTPS']) == "on" ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$ob = new \Bitrix\Main\Web\HttpClient(array('disableSslVerification'=>true, 'socketTimeout'=>2, 'streamTimeout'=>2));
			$res = trim($ob->post($selfLink, array('action'=>'getphpversion', 'path'=>$phpPath)));
			if(preg_match('/^\d+(\.\d+)+$/', $res))
			{
				$arVersions[$res] = $phpPath;
			}
			elseif(preg_match('/\/(\d+\.\d+)\//', $phpPath, $m))
			{
				$arVersions[$m[1]] = $phpPath;
			}
		}
	}
}
if(!empty($arVersions))
{
	krsort($arVersions);
	reset($arVersions);
	$phpPath = current($arVersions);
}
else
{
	reset($arPaths);
	$phpPath = current($arPaths);
}
/*/Define php path*/

$oProfile = new \Bitrix\EsolImportxml\Profile($suffix);
$arProfiles = $oProfile->GetList();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_popup_admin.php");
?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data" name="field_settings">
	<input type="hidden" name="action" value="save">
	<div id="esol-ix-cron-result"></div>
	<table width="100%">
		<col width="40%">
		<col width="60%">
		<!--<tr class="heading">
			<td colspan="2"><?echo GetMessage("ESOL_IX_CRON_PROFILE_TITLE"); ?></td>
		</tr>-->
		<tr>
			<td class="adm-detail-content-cell-l" width="40%"><?echo GetMessage("ESOL_IX_CRON_CHOOSE_PROFILE");?>:</td>
			<td class="adm-detail-content-cell-r">
				<select name="PROFILE_ID[]" onchange="/*EProfile.Choose(this)*/" class="esol-chosen-multi" style="width: 400px;" size="3" multiple><?
					/*?><option value=""><?echo GetMessage("ESOL_IX_CRON_NO_PROFILE"); ?></option><?*/
					foreach($arProfiles as $k=>$profile)
					{
						?><option value="<?echo $k;?>"><?echo $profile; ?></option><?
					}
				?></select>
			</td>
		</tr>
		<tr>
			<td class="adm-detail-content-cell-l"><? echo GetMessage("ESOL_IX_CRON_PERIOD"); ?></td>
			<td class="adm-detail-content-cell-r">
				<table cellspacing="0" cellpadding="0"><tr>
				<td>
				<select name="agent_period_type" onchange="$(this).closest('table').find('div').hide(); $('#agent_period_'+this.value).show();">
					<option value="daily"><? echo GetMessage("ESOL_IX_CRON_PERIOD_DAILY"); ?></option>
					<option value="hours"><? echo GetMessage("ESOL_IX_CRON_PERIOD_HOURS"); ?></option>
					<option value="minutes"><? echo GetMessage("ESOL_IX_CRON_PERIOD_MINUTES"); ?></option>
					<option value="expert"><? echo GetMessage("ESOL_IX_CRON_PERIOD_EXPERT"); ?></option>
				</select>
				</td>
				<td>&nbsp; &nbsp;</td>
				<td>
				<div id="agent_period_daily"><? echo GetMessage("ESOL_IX_CRON_PERIODVAL_AT"); ?> &nbsp; <input type="text" name="agent_period_daily_hours" value="" size="1" maxlength="2" placeholder="0"> :<?/* echo GetMessage("ESOL_IX_CRON_PERIODVAL_AT_HOURS"); */?> <input type="text" name="agent_period_daily_minutes" value="" size="1" maxlength="2" placeholder="00"> <? /*echo GetMessage("ESOL_IX_CRON_PERIODVAL_AT_MINUTES");*/ ?></div>
				<div id="agent_period_hours" style="display: none;"><? echo GetMessage("ESOL_IX_CRON_PERIODVAL_HOURS"); ?>: <input type="text" name="agent_period_hours" value="" size="2" placeholder="1"> <? /*echo GetMessage("ESOL_IX_CRON_PERIODVAL_AT_HOURS");*/ ?></div>
				<div id="agent_period_minutes" style="display: none;"><? echo GetMessage("ESOL_IX_CRON_PERIODVAL_MINUTES"); ?>: <input type="text" name="agent_period_minutes" value="" size="2" placeholder="15"> <? /*echo GetMessage("ESOL_IX_CRON_PERIODVAL_AT_MINUTES");*/ ?></div>
				<div id="agent_period_expert" style="display: none;"><? echo GetMessage("ESOL_IX_CRON_PERIODVAL_EXPERT"); ?>: <input type="text" name="agent_period_expert" value="* * * * *" size="12"></div>
				</td>
				</tr></table>
			</td>
		</tr>
		<tr>
			<td class="adm-detail-content-cell-l"><? echo GetMessage("ESOL_IX_CRON_PHP_PATH"); ?> <span id="hint_CRON_PHP_PATH"></span><script>BX.hint_replace(BX('hint_CRON_PHP_PATH'), '<?echo GetMessage("ESOL_IX_CRON_PHP_PATH_HINT"); ?>');</script></td>
			<td class="adm-detail-content-cell-r"><input type="text" name="agent_php_path" value="<?echo $phpPath;?>" size="25"></td>
		</tr>
		<tr>
			<td class="adm-detail-content-cell-l"><? echo GetMessage("ESOL_IX_CRON_AUTO_CRON"); ?> <span id="hint_CRON_AUTO_CRON"></span><script>BX.hint_replace(BX('hint_CRON_AUTO_CRON'), '<?echo GetMessage("ESOL_IX_CRON_AUTO_CRON_HINT"); ?>');</script></td>
			<td class="adm-detail-content-cell-r"><input type="hidden" name="auto_cron_tasks" value="N"><input type="checkbox" name="auto_cron_tasks" value="Y" checked></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" name="delete" value="<? echo GetMessage("ESOL_IX_CRON_UNSET"); ?>" onclick="return EProfile.SaveCron(this);">
				<input type="submit" name="add" value="<? echo GetMessage("ESOL_IX_CRON_SET"); ?>" onclick="return EProfile.SaveCron(this);">
			</td>
		</tr>
	</table>
	
	<div>&nbsp;</div>
	<div id="esol-ix-cron-records_wrap">
	<?
	$arRecords = array();
	if(preg_match_all("#^\s*(([\*/,\d]+\s+){5}).*?".preg_quote(ESOL_IX_PATH2EXPORTS).$cronFrame." +(\d[\d,]*) *>.*?$#im", $cfg_data, $m))
	{
		foreach($m[0] as $k=>$v)
		{
			$key = trim($m[1][$k]).'|'.$m[3][$k];
			$arRecords[$key] = array('time'=>trim($m[1][$k]), 'pid'=>explode(',', $m[3][$k]));
		}
	}
	if(count($arRecords) > 0)
	{
	?>
		<table width="100%" class="esol-ix-cron-records" cellspacing="8">
			<col width="30%">
			<col>
			<col width="30px">
			<tr class="heading">
				<td colspan="3">
					<? echo GetMessage("ESOL_IX_CRON_REC_TITLE"); ?>
				</td>
			</tr>
			<tr class="esol-ix-cron-records-titles">
				<td><? echo GetMessage("ESOL_IX_CRON_REC_TIME"); ?></td>
				<td><? echo GetMessage("ESOL_IX_CRON_REC_PROFILE"); ?></td>
				<td></td>
			</tr>
			<?
			foreach($arRecords as $key=>$rec)
			{
				$arRecProfiles = array();
				foreach($rec['pid'] as $pid)
				{
					$arRecProfiles[] = (array_key_exists($pid, $arProfiles) ? $arProfiles[$pid] : $pid);
				}
				$time = trim($rec['time']);
				if(preg_match('#^\*/(\d+)\s+\*\s+\*\s+\*\s+\*$#', $time, $m)) $time = '<i>'.$time.'</i> ('.GetMessage("ESOL_IX_CRON_REC_TIME_PERIOD").' '.$m[1].' '.\Bitrix\EsolImportxml\Utils::WordWithNum($m[1], GetMessage("ESOL_IX_CRON_REC_TIME_MINUTES")).')';
				elseif(preg_match('#^0\s+\*/(\d+)\s+\*\s+\*\s+\*$#', $time, $m)) $time = '<i>'.$time.'</i> ('.GetMessage("ESOL_IX_CRON_REC_TIME_PERIOD").' '.$m[1].' '.\Bitrix\EsolImportxml\Utils::WordWithNum($m[1], GetMessage("ESOL_IX_CRON_REC_TIME_HOURS")).')';
				elseif(preg_match('#^(\d+)\s+(\d+)\s+\*\s+\*\s+\*$#', $time, $m)) $time = '<i>'.$time.'</i> ('.GetMessage("ESOL_IX_CRON_REC_TIME_DAILY").' '.$m[2].':'.sprintf('%02d', $m[1]).')';
				echo '<tr>'.
					'<td>'.$time.'</td>'.
					'<td>'.implode(', ', $arRecProfiles).'</td>'.
					'<td><a class="esol-ix-cron-record-delete" href="javascript:void(0)" onclick="return EProfile.DeleteFromCron(this, \''.$key.'\');" title="'.htmlspecialcharsbx(GetMessage("ESOL_IX_CRON_UNSET")).'"></a></td>'.
				'</tr>';
			}
			?>
		</table>
	<?
	}
	?>
	</div>
	
	<?echo BeginNote();?>
		<? echo GetMessage("ESOL_IX_CRON_DESCRIPTION"); ?>
	<?echo EndNote();?>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_popup_admin.php");?>