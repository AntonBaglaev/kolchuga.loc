<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 03.04.2018
 * Time: 0:51
 */

namespace litebox\kassa\lib\Api\Methods\v1;

use litebox\kassa\lib\Template\Orders\Files;
use litebox\kassa\lib\Template\Result;

class Base
{
    /**
     * @var \litebox\kassa\lib\Template\Result $result Результат в общем виде
     */
    public $result;

    /**
     * @var bool $needToken флаг отвечающий за доступность метода
     */
    public $needToken = true;

    /**
     * @var string $sourceStrForToken исходная строка для формирования токена
     */
    private $sourceStrForToken = SITE_SERVER_NAME . SITE_ID;

    /**
     * @var string $salt соль
     */
    private $salt = '9b520171bee';

    /**
     * Base constructor.
     * @param integer $page текущая страница
     * @param integer $pageSize количество элементов на странице
     */
    public function __construct($page, $pageSize)
    {
        $token = $_REQUEST['token'];

        $checkToken = $this->checkToken($token);

        if ((!$token || !$checkToken) && $this->needToken) {
            $this->result = [
                'error' => 'access token not valid'
            ];
            return json_encode($this->result);
        }

        $this->result = new Result();

        $offset = $_REQUEST['offset'];

        if ($offset) {
            $this->result->page = $offset/$this->result->pageSize;
            $this->result->page += 1;
        }

        if ($page) {
            $this->result->page = (int)$page;
        }
        if ($pageSize) {
            $this->result->pageSize = (int)$pageSize;
        }
    }

    /**
     * Получение элементов из инфоблока
     * @param array $arOrder
     * @param array $arFilter
     * @param array $arGroupBy
     * @param array $arNavStartParams
     * @param array $arSelectFields
     * @param array $arOptions
     * @return array
     */
    public function getList($arOrder = [], $arFilter = [], $arGroupBy = [], $arNavStartParams = [], $arSelectFields = [], $arOptions = [])
    {
        if (empty($arGroupBy)) {
            $arGroupBy = false;
        }

        $this->result->total = \CSaleOrder::GetList($arOrder, $arFilter)->SelectedRowsCount();

        $db = \CSaleOrder::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields, $arOptions);

        $this->result->count = count($db->arResult);

        $data = [];

        while ($arData = $db->Fetch()) {
            $data[] = $arData;
        }

        return $data;
    }

    /**
     * получение товаров из заказа
     * @param string|integer $id заказа
     * @return array
     */
    public function getItemsOrder($id)
    {
        $items = \CSaleBasket::GetList(["ID"=>"ASC"], ["ORDER_ID"=>$id]);

        $data = [];

        while ($arData = $items->Fetch()) {
            $data[] = $arData;
        }

        return $data;
    }

    /**
     * @param string|integer $id товара
     * @return array
     */
    public function getItemData($id)
    {
        $data = [];
        $item = \CCatalogProduct::GetList([], ['ID' => $id]);

        while ($arData = $item->Fetch()) {
            $data[] = $arData;
        }

        return $data;
    }

    /**
     * Получение информации о НДС
     * @param $id
     * @return array
     */
    public function getVatData($id)
    {
        $data = [];

        $dataDb = \CCatalogVat::GetByID($id);
        $data = $dataDb->GetNext();

        return $data;
    }

    /**
     * Получение информации о группе пользователя
     * @param integer|string $id группы
     * @return array
     */
    public function getGroupId($id)
    {
        $data = \CGroup::GetByID($id)->Fetch();

        return $data;
    }

    /**
     * Информация о заказе
     * @param integer|string $id заказа
     * @return array|bool
     */
    public function getDataOrder($id)
    {
        return \CSaleOrder::GetById($id);
    }

    /**
     * Получение информации о товаре
     * @param string|integer $id
     * @return array
     */
    public function getDataItem($id)
    {
        return \CIBlockElement::GetByID($id)->Fetch();
    }

    /**
     * Получение данных заказа
     * @param $orderId
     * @return array
     */
    public function getBillDataOrder($orderId)
    {
        $db = \CSaleOrderPropsValue::GetOrderProps($orderId);
        $data = [];

        while($dbRes = $db->Fetch()) {
            $data[$dbRes['CODE']] = $dbRes['VALUE'];
        }

        return $data;
    }

    /**
     * Получение информации о доставке
     * @param $id
     * @return array
     */
    public function getDelivery($id)
    {
        return \CSaleDelivery::GetByID($id);
    }

    /**
     * Получение предложений
     * @param $id
     * @return mixed
     */
    public function getSKU($id)
    {
        return \CCatalogSku::GetProductInfo($id);
    }

    /**
     * Получение информации о продукте
     * @param $iblockId
     * @param $id
     * @return array
     */
    public function getDataProduct($iblockId, $id)
    {
        $arFilter = [
            'IBLOCK_ID' => $iblockId,
            'ACTIVE_DATE' => 'Y',
            'ACTIVE' => 'Y',
            'ID' => $id
        ];
        $res = \CIBlockElement::GetList([], $arFilter);
        $data = [];
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $data[] = $arFields;
        }

        return $data;
    }

    /**
     * Получение изображения по id
     * @param string|int $pictureId изображения
     * @return array|bool
     */
    public function getPicture($pictureId)
    {
        return \CFile::GetFileArray($pictureId);
    }

    /**
     * Получение выбранных свойств
     * @param $productId
     * @return array
     */
    public function getSelectedProperties($productId)
    {
        $data = \CCatalogProduct::GetByIDEx($productId);

        $dataRes = [];

        foreach ($data['PROPERTIES'] as $mainName => $itemMainProp) {
            if ($mainName == 'MORE_PHOTO') {
                $itemMainProp['files'] = new Files($this->getPicture($itemMainProp['VALUE']));
                $itemMainProp['files']->adminUrl = $this->getBaseUrl() . $itemMainProp['files']->adminUrl;
                $itemMainProp['files']->customerUrl = $this->getBaseUrl() . $itemMainProp['files']->customerUrl;
                $dataRes[] = $itemMainProp;
            } else if ($itemMainProp['VALUE'] || $itemMainProp['VALUE_ENUM'] || $itemMainProp['VALUE_ENUM']) {
                $dataRes[] = $itemMainProp;
            }
        }

        return $dataRes;
    }

    /**
     * Получение элементов инфоблока
     * @param $iblockId
     * @param $sectionCode
     * @param bool $isActive
     * @return array
     */
    public function getElementsList($iblockId, $sectionCode, $isActive = true)
    {
        $arFilter = [
            'IBLOCK_ID' => $iblockId,
            'SECTION_CODE' => $sectionCode,
        ];

        if ($isActive) {
            $arFilter['ACTIVE_DATE'] = 'Y';
            $arFilter['ACTIVE'] = 'Y';
        }

        $res = \CIBlockElement::GetList([], $arFilter);

        $dataRes = [];

        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $dataRes[] = $arFields['ID'];
        }

        return $dataRes;
    }

    /**
     * Метод генерации символьного кода
     * @param string $name имя для генерации символьного кода
     * @return string
     */
    public function generateCode($name, $dop = null)
    {
        $paramsCode = Array(
            'max_len' => '100',
            'change_case' => 'L',
            'replace_space' => '_',
            'replace_other' => '_',
            'delete_repeat_replace' => 'true',
            'use_google' => 'false',
        );

        $result = self::translit($name, "ru", $paramsCode);

        if ($dop) {
            $result .= '_' . $dop . date('is');
        } else {
            $result .= '_' . $this->generatePassword(4);
        }

        return $result;
    }

    public function generatePassword($length = 8){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    /**
     * Создание элемента в каталоге
     * @param array $arFields массив полей
     * @return bool
     */
    public function newItemCatalog($arFields)
    {
        $resAdd = \CCatalogProduct::Add($arFields);

        return $resAdd;
    }

    /**
     * Обновление элемента каталога
     * @param $productId
     * @param $arFields
     * @return bool
     */
    public function updateItemCatalog($productId, $arFields)
    {
        $result = \CCatalogProduct::Update($productId, $arFields);

        return $result;
    }

    /**
     * Обновление товара на складе
     * @param $stockId
     * @param $productId
     * @param $amount
     * @return bool
     */
    public function updateItemInStock($stockId, $productId, $amount)
    {
        $list = \CCatalogStoreProduct::GetList([], ['=PRODUCT_ID' => $productId])->Fetch();

        $list['AMOUNT'] = $amount;

        $result = \CCatalogStoreProduct::Update($list['ID'], $list);

        return $result;
    }

    /**
     * Добавление торгового предложения
     * @param $offersId
     * @param $PRODUCT_ID
     * @param $offersPropId
     * @param $data
     * @param $arProp
     * @param $price
     * @param $compareToPrice
     * @return bool
     */
    public function addSentenseForProduct($offersId, $PRODUCT_ID, $offersPropId, $data, $arProp, $price, $compareToPrice)
    {
        $element = new \CIBlockElement;
        $props = [];

        $data->price = $price;
        $data->compareToPrice = $compareToPrice;

        $arProp[$offersPropId] = $data->sku;

        $pic = $arProp['DETAIL_PICTURE'];

        unset($arProp['DETAIL_PICTURE']);

        $arFields = array(
            'NAME' => $data->name,
            'IBLOCK_ID' => $offersId,
            'ACTIVE' => ($data->enabled) ? 'Y' : 'N',
            'DETAIL_PICTURE' => $pic,
            'PROPERTY_VALUES' => $arProp
        );
        $intOfferID = $element->Add($arFields);

        $arFilterAdd = [
            'AVAILABLE' => ($data->enabled) ? 'Y' : 'N',
            'PURCHASING_PRICE' => $data->price,
            'PURCHASING_CURRENCY' => 'RUB',
            'WEIGHT' => $data->weight,
            'WIDTH' => $data->width,
            'LENGTH' => $data->length,
            'HEIGHT' => $data->height,
            'PRICE_TYPE' => 'S'
        ];

        $arFilterAdd['ID'] = $intOfferID;

        $resAdd = $this->newItemCatalog($arFilterAdd);

        $resQuant = $this->updateItemCatalog($intOfferID, ['QUANTITY' => $data->quantity]);

        $arFields = [
            'PRODUCT_ID' => $intOfferID,
            'STORE_ID' => $data->storeId,
            'AMOUNT' => $data->quantity,
        ];

        $ID = \CCatalogStoreProduct::Add($arFields);

        $addPrice = \CPrice::SetBasePrice($intOfferID, $data->compareToPrice, 'RUB');

        return $intOfferID;
    }

    /**
     * Формирование символьного кода
     * @param string $str входная строка
     * @param string $lang язык
     * @param array $params параметры
     * @return string
     */
    public static function translit($str, $lang, $params = array())
    {
        static $search = array();

        if(!isset($search[$lang]))
        {
            $mess = IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/js_core_translit.php", $lang, true);
            $trans_from = explode(",", $mess["TRANS_FROM"]);
            $trans_to = explode(",", $mess["TRANS_TO"]);
            foreach($trans_from as $i => $from)
                $search[$lang][$from] = $trans_to[$i];
        }

        $defaultParams = array(
            "max_len" => 100,
            "change_case" => 'L', // 'L' - toLower, 'U' - toUpper, false - do not change
            "replace_space" => '_',
            "replace_other" => '_',
            "delete_repeat_replace" => true,
            "safe_chars" => '',
        );
        foreach($defaultParams as $key => $value)
            if(!array_key_exists($key, $params))
                $params[$key] = $value;

        $len = strlen($str);
        $str_new = '';
        $last_chr_new = '';

        for($i = 0; $i < $len; $i++)
        {
            $chr = mb_substr($str, $i, 1);

            if(preg_match("/[a-zA-Z0-9]/".BX_UTF_PCRE_MODIFIER, $chr) || strpos($params["safe_chars"], $chr)!==false)
            {
                $chr_new = $chr;
            }
            elseif(preg_match("/\\s/".BX_UTF_PCRE_MODIFIER, $chr))
            {
                if (
                    !$params["delete_repeat_replace"]
                    ||
                    ($i > 0 && $last_chr_new != $params["replace_space"])
                )
                    $chr_new = $params["replace_space"];
                else
                    $chr_new = '';
            }
            else
            {
                if(array_key_exists($chr, $search[$lang]))
                {
                    $chr_new = $search[$lang][$chr];
                }
                else
                {
                    if (
                        !$params["delete_repeat_replace"]
                        ||
                        ($i > 0 && $i != $len-1 && $last_chr_new != $params["replace_other"])
                    )
                        $chr_new = $params["replace_other"];
                    else
                        $chr_new = '';
                }
            }

            if(strlen($chr_new))
            {
                if($params["change_case"] == "L" || $params["change_case"] == "l")
                    $chr_new = ToLower($chr_new);
                elseif($params["change_case"] == "U" || $params["change_case"] == "u")
                    $chr_new = ToUpper($chr_new);

                $str_new .= $chr_new;
                $last_chr_new = $chr_new;
            }

            if (strlen($str_new) >= $params["max_len"])
                break;
        }

        return $str_new;
    }

    /**
     * Формирование токена
     * @return bool|string
     */
    public function generateToken()
    {
        $hash = md5($this->sourceStrForToken . $this->salt);

        return $hash;
    }

    /**
     * Проверка токена
     * @param string $token токен
     * @return bool
     */
    public function checkToken($token)
    {
        $origToken = $this->generateToken();
        $result = $origToken == $token;
        return $result;
    }

    /**
     * Получение информации по платежной системе
     * @param $id
     * @return array|bool|false
     */
    public function getPaymentSystem($id)
    {
        $result = \CSalePaySystem::GetByID($id);

        return $result;
    }

    /**
     * Получение примененных купонов к заказу
     * @param $orderId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getCouponByOrder($orderId)
    {
        $couponDb = \Bitrix\Sale\Internals\OrderCouponsTable::getList(['filter' => ['=ORDER_ID' => $orderId]]);

        $coupons = [];

        while($couponsRes = $couponDb->Fetch()) {
            $coupons[] = $couponsRes;
        }

        return $coupons;
    }

    /**
     * Получение информации о купоне
     * @param string $coupon купон
     * @return array
     */
    public function getInfoCoupon($coupon)
    {
        $arFilter = [
            '=COUPON' => $coupon
        ];
        $dbRes = \CCatalogDiscountCoupon::GetList([], $arFilter);

        $couponInnfo = [];

        while($data = $dbRes->Fetch()) {
            $couponInnfo[] = $data;
        }

        return $couponInnfo;
    }

    public function getBaseUrl()
    {
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        }
        else {
            $protocol = 'http://';
        }

        $url = $protocol . SITE_SERVER_NAME;

        return $url;
    }

    public function escape_win ($path) {
        $path = strtoupper($path);
        return strtr($path, array("\\U0430"=>"а", "\\U0431"=>"б", "\\U0432"=>"в",
            "\\U0433"=>"г", "\\U0434"=>"д", "\\U0435"=>"е", "\\U0451"=>"ё", "\\U0436"=>"ж", "\\U0437"=>"з", "\\U0438"=>"и",
            "\\U0439"=>"й", "\\U043A"=>"к", "\\U043B"=>"л", "\\U043C"=>"м", "\\U043D"=>"н", "\\U043E"=>"о", "\\U043F"=>"п",
            "\\U0440"=>"р", "\\U0441"=>"с", "\\U0442"=>"т", "\\U0443"=>"у", "\\U0444"=>"ф", "\\U0445"=>"х", "\\U0446"=>"ц",
            "\\U0447"=>"ч", "\\U0448"=>"ш", "\\U0449"=>"щ", "\\U044A"=>"ъ", "\\U044B"=>"ы", "\\U044C"=>"ь", "\\U044D"=>"э",
            "\\U044E"=>"ю", "\\U044F"=>"я", "\\U0410"=>"А", "\\U0411"=>"Б", "\\U0412"=>"В", "\\U0413"=>"Г", "\\U0414"=>"Д",
            "\\U0415"=>"Е", "\\U0401"=>"Ё", "\\U0416"=>"Ж", "\\U0417"=>"З", "\\U0418"=>"И", "\\U0419"=>"Й", "\\U041A"=>"К",
            "\\U041B"=>"Л", "\\U041C"=>"М", "\\U041D"=>"Н", "\\U041E"=>"О", "\\U041F"=>"П", "\\U0420"=>"Р", "\\U0421"=>"С",
            "\\U0422"=>"Т", "\\U0423"=>"У", "\\U0424"=>"Ф", "\\U0425"=>"Х", "\\U0426"=>"Ц", "\\U0427"=>"Ч", "\\U0428"=>"Ш",
            "\\U0429"=>"Щ", "\\U042A"=>"Ъ", "\\U042B"=>"Ы", "\\U042C"=>"Ь", "\\U042D"=>"Э", "\\U042E"=>"Ю", "\\U042F"=>"Я"));
    }
}