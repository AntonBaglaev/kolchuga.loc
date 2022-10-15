<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "preorder_from_list", Array(
    "SEF_MODE" => "N",
    "WEB_FORM_ID" => 1,
    "LIST_URL" => "",
    "EDIT_URL" => "",
    "SUCCESS_URL" => "",
    "CHAIN_ITEM_TEXT" => "",
    "CHAIN_ITEM_LINK" => "",
    "IGNORE_CUSTOM_TEMPLATE" => "Y",
    "USE_EXTENDED_ERRORS" => "Y",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600",
    "SEF_FOLDER" => "/",
    "VARIABLE_ALIASES" => Array(),
    "ELEMENT_ID" => $arResult["ID"],
), false, array("HIDE_ICONS" => "Y"));
?>
<?
function output_file($file, $name)
{
    $size = filesize($file);
    $name = rawurldecode($name);

    if (preg_match('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
        $UserBrowser = "Opera";
    elseif (preg_match('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
        $UserBrowser = "IE";
    else
        $UserBrowser = '';

    $mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
    @ob_end_clean();
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="'.$name.'"');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header('Accept-Ranges: bytes');
    header("Cache-control: private");
    header('Pragma: private');


    if(isset($_SERVER['HTTP_RANGE']))
    {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
        str_replace($range, "-", $range);
        $size2 = $size-1;
        $new_length = $size-$range;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range$size2/$size");
    }
    else
    {
        $size2=$size-1;
        header("Content-Length: ".$size);
    }
    $chunksize = 1*(1024*1024);
    $bytes_send = 0;
    if ($file = fopen($file, 'r'))
    {
        if(isset($_SERVER['HTTP_RANGE']))
            fseek($file, $range);
        while(!feof($file) and (connection_status()==0))
        {
            $buffer = fread($file, $chunksize);
            print($buffer);//echo($buffer); // is also possible
            flush();
            $bytes_send += strlen($buffer);
            //sleep(1);//// decrease download speed
        }
        fclose($file);
    }
    else
        die('Ошибка открытия файла!');
    if(isset($new_length))
        $size = $new_length;
    die();
}
if( !empty($_REQUEST['download']) && in_array($_REQUEST['download'], $arResult['DOWNLOAD_FILE'])){
	$rsFile = CFile::GetByID($_REQUEST['download']);
    $arFile = $rsFile->Fetch();
	$filestr="/upload/".$arFile['SUBDIR']."/".$arFile['FILE_NAME'];
	//echo "<pre style='text-align:left;'>";print_r($arFile);echo "</pre>";
	output_file($_SERVER['DOCUMENT_ROOT'].$filestr, $arFile['ORIGINAL_NAME']);
}
?>