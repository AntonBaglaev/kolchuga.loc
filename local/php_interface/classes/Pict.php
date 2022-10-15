<?
namespace Kolchuga;

class Pict {

	private static $isPng = true;

	private static function checkFormat($str)
	{
		if ($str === 'image/png')
		{
			self::$isPng = true;

			return true;
		}
		elseif ($str === 'image/jpeg')
		{
			self::$isPng = false;

			return true;
		}
		else return false;
	}

	private static function implodeSrc($arr)
	{
		$arr[count($arr) - 1] = '';

		return implode('/', $arr);
	}

	private static function generateSrc($str)
	{
		$arPath = explode('/', $str);

		if ($arPath[2] === 'resize_cache')
		{
			$arPath = self::implodeSrc($arPath);

			return str_replace('resize_cache/iblock', 'webp/resize_cache', $arPath);
		}elseif($arPath[1]!='upload'){
			$arPath = self::implodeSrc($arPath);
			
			return '/upload/webp'.$arPath;
			
		}
		else
		{
			$arPath = self::implodeSrc($arPath);

			return str_replace('upload/iblock', 'upload/webp/iblock', $arPath);
		}
	}
	/* 
	* по умолчанию передается массив полученный путем $array=\CFile::GetFileArray 
	* если нужен любой файл необходимо собрать массив
	* пример
	* $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images/banner_2.png");
	* $arFile['SRC'] = "/images/banner_2.png";
	* $arFile['CONTENT_TYPE'] = $arFile['type'];
	* $arFile['FILE_NAME'] = $arFile['name'];
	* \Kolchuga\Pict::getWebp($arFile,80);
	*
	*/
    public static function getWebp($array, $intQuality = 70)
	{
		if (self::checkFormat($array['CONTENT_TYPE']))
		{
			$array['WEBP_PATH'] = self::generateSrc($array['SRC']);

			if (self::$isPng)
			{
				$array['WEBP_FILE_NAME'] = str_replace('.png', '.webp', strtolower($array['FILE_NAME']));
			}
			else
			{
				$array['WEBP_FILE_NAME'] = str_replace('.jpg', '.webp', strtolower($array['FILE_NAME']));
				$array['WEBP_FILE_NAME'] = str_replace('.jpeg', '.webp', strtolower($array['WEBP_FILE_NAME']));
			}

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $array['WEBP_PATH']))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'] . $array['WEBP_PATH'], 0777, true);
			}

			$array['WEBP_SRC'] = $array['WEBP_PATH'] . $array['WEBP_FILE_NAME'];

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $array['WEBP_SRC']))
			{
				if (self::$isPng)
				{
					$im = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $array['SRC']);
				}
				else
				{
					$im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $array['SRC']);
				}

				imagewebp($im, $_SERVER['DOCUMENT_ROOT'] . $array['WEBP_SRC'], $intQuality);

				imagedestroy($im);

				if (filesize($_SERVER['DOCUMENT_ROOT'] . $array['WEBP_SRC']) % 2 == 1)
				{
					file_put_contents($_SERVER['DOCUMENT_ROOT'] . $array['WEBP_SRC'], "\0", FILE_APPEND);
				}
			}
		}

		return $array;
    }

	public static function resizePict($file, $width, $height, $isProportional = true, $intQuality = 70)
	{
		$file = \CFile::ResizeImageGet($file, array('width'=>$width, 'height'=>$height), ($isProportional ? BX_RESIZE_IMAGE_PROPORTIONAL : BX_RESIZE_IMAGE_EXACT), false, false, false, $intQuality);

		return $file['src'];
	}

	public static function getResizeWebp($file, $width, $height, $isProportional = true, $intQuality = 70)
	{
		$file['SRC'] = self::resizePict($file, $width, $height, $isProportional, $intQuality);

		$file = self::getWebp($file, $intQuality);

		return $file;
	}

	public static function getResizeWebpSrc($file, $width, $height, $isProportional = true, $intQuality = 70)
	{
		$file['SRC'] = self::resizePict($file, $width, $height, $isProportional, $intQuality);

		$file = self::getWebp($file, $intQuality);

		return $file['WEBP_SRC'];
	}
	public static function getWebpImgSrc($src, $intQuality = 70)
	{
		$arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$src);
		$arFile['SRC'] = $src;
		$arFile['CONTENT_TYPE'] = $arFile['type'];
		$arFile['FILE_NAME'] = $arFile['name'];
		$arFile['DETAIL_PICTURE'] = \Kolchuga\Pict::getWebp($arFile,$intQuality);
		return $arFile;
	}
	
	/* 
	* так же добавляю еще вариант для генерации картинки рядом с оригиналом	* 
	* Пример
	* $arResult['PREVIEW_PICTURE']['SRC_WEBP'] = makeWebp($file['src']);
	* <picture>
	*		<?if ($arItem["PREVIEW_PICTURE"]["SRC_WEBP"]) :?>
	*			<source type="image/webp" srcset="<?=$arItem["PREVIEW_PICTURE"]["SRC_WEBP"]?>">
	*		<?endif;?>
	*		<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" />
	*	</picture>
	*/
	public function makeWebp ($src) {
		$newImgPath = false;

		if ($src && function_exists('imagewebp')) {
			$newImgPath = str_replace(array('.jpg', '.jpeg', '.gif', '.png'), '.webp', $src);
			if (!file_exists($_SERVER['DOCUMENT_ROOT'].$newImgPath)) {
				$info = getimagesize($_SERVER['DOCUMENT_ROOT'].$src);
				if ($info !== false && ($type = $info[2])) {
					switch ($type) {
						case IMAGETYPE_JPEG:
							$newImg = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$src);
							break;
						case IMAGETYPE_GIF:
							$newImg = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'].$src);
							break;
						case IMAGETYPE_PNG:
							$newImg = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$src);
							break;
					}
					if ($newImg) {
						imagewebp($newImg, $_SERVER['DOCUMENT_ROOT'].$newImgPath, 90);
						imagedestroy($newImg);
					}
				}
			}
		}

		return $newImgPath;
	}
	/* 

		для бекграунда добавляем javascript
		// Проверяем, можно ли использовать Webp формат
		function canUseWebp() {
			// Создаем элемент canvas
			let elem = document.createElement('canvas');
			// Приводим элемент к булеву типу
			if (!!(elem.getContext && elem.getContext('2d'))) {
				// Создаем изображение в формате webp, возвращаем индекс искомого элемента и сразу же проверяем его
				return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
			}
			// Иначе Webp не используем
			return false;
		}
		window.onload = function () {
			// Получаем все элементы с дата-атрибутом data-bg
			let images = document.querySelectorAll('[data-bg]');
			// Проходимся по каждому
			for (let i = 0; i < images.length; i++) {
				// Получаем значение каждого дата-атрибута
				let image = images[i].getAttribute('data-bg');
				// Каждому найденному элементу задаем свойство background-image с изображение формата jpg
				images[i].style.backgroundImage = 'url(' + image + ')';
			}

			// Проверяем, является ли браузер посетителя сайта Firefox и получаем его версию
			let isitFirefox = window.navigator.userAgent.match(/Firefox\/([0-9]+)\./);
			let firefoxVer = isitFirefox ? parseInt(isitFirefox[1]) : 0;

			// Если есть поддержка Webp или браузер Firefox версии больше или равно 65
			if (canUseWebp() || firefoxVer >= 65) {
				// Делаем все то же самое что и для jpg, но уже для изображений формата Webp
				let imagesWebp = document.querySelectorAll('[data-bg-webp]');
				for (let i = 0; i < imagesWebp.length; i++) {
					let imageWebp = imagesWebp[i].getAttribute('data-bg-webp');
					imagesWebp[i].style.backgroundImage = 'url(' + imageWebp + ')';
				}
			}
		};

		для тега прописываем 
		style="background-image: url(<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>)" data-bg="<?=$arFile['DETAIL_PICTURE']['SRC']?>" data-bg-webp="<?=$arFile['DETAIL_PICTURE']['WEBP_SRC']?>"
		
		что делать со стилями под разные разрешения, тут вопрос, нужно думать/искать решения
	*/
}?>