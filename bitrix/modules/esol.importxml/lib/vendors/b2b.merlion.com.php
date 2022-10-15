<?php
namespace IX;

class B2bmerlioncom {
	public static function GetAuthParams()
	{
		return array(
			'clientNo',
			'clientLogin',
			'password'
		);
	}
	
	public static function GetDownloadFile($arParams, $maxTime=10)
	{
		if(!function_exists('json_encode')) return false;
		$postParams = json_encode($arParams['VARS']);
		$arHeaders = array(
			'User-Agent' => \Bitrix\EsolImportxml\Utils::GetUserAgent(),
			'content-type' => 'application/json',
			'authorization' => 'Bearer initial'
		);
		$ob = new \Bitrix\Main\Web\HttpClient(array('disableSslVerification'=>false));
		foreach($arHeaders as $k=>$v) $ob->setHeader($k, $v);

		$res = $ob->post('https://b2b.merlion.com/api/login', $postParams);
		$arCookies = $ob->getCookies()->toArray();
		$arRes = json_decode($res, true);
		$arHeaders['authorization'] = 'Bearer '.$arRes['csrf_token'];

		$ob = new \Bitrix\Main\Web\HttpClient(array('disableSslVerification'=>false));
		foreach($arHeaders as $k=>$v) $ob->setHeader($k, $v);
		$ob->setCookies($arCookies);
		$fContent = $ob->get($arParams['FILELINK']);
		$hcd = $ob->getHeaders()->get('content-disposition');
		$fn = '';
		if($hcd && stripos($hcd, 'filename=')!==false)
		{
			$hcdParts = preg_grep('/filename=/i', array_map('trim', explode(';', $hcd)));
			if(count($hcdParts) > 0)
			{
				$hcdParts = explode('=', current($hcdParts));
				$fn = end(explode('/', trim(end($hcdParts), '"\' ')));
			}
		}
		if(strlen($fn) > 0)
		{
			$tmpPath = \CFile::GetTempName('', $fn);
			$dir = \Bitrix\Main\IO\Path::getDirectory($tmpPath);
			\Bitrix\Main\IO\Directory::createDirectory($dir);
			file_put_contents($tmpPath, $fContent);
			return \CFile::MakeFileArray($tmpPath);
		}
		
		return false;
	}
}
?>