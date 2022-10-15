<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 09.04.2018
 * Time: 13:03
 */

namespace litebox\kassa\lib\Api\Methods\v1;

use litebox\kassa\lib\Template\Products\Item;
use litebox\kassa\lib\Template\Products\Options;
use litebox\kassa\lib\Template\Products\Picture;
use Bitrix\Main\Diag\Debug;

class Products extends Base
{
    public function executeGET($id = null, $updatedFrom = null)
    {
        $offerFilter = [];
        if ($id) {
            $offerFilter = ["IBLOCK_TYPE" => 'offers', "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];

            $checkSKU = $this->getSKU($id);
            if ($checkSKU && $checkSKU['ID']) {
                $id = $checkSKU['ID'];
            }
        }

        $arFilter = [
            [
                'LOGIC' => 'OR',
                ["IBLOCK_TYPE" => 'catalog', "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"],
                $offerFilter
            ],
        ];


        if ($updatedFrom) {
            $thisDate = new \DateTime();
            $timeZone = $thisDate->getTimezone()->getName();

            $updatedFrom = str_replace('+', ' ', $updatedFrom);
            $updatedFrom = new \DateTime($updatedFrom, new \DateTimeZone('UTC'));
            $updatedFrom->setTimezone(new \DateTimeZone($timeZone));

            $offersFilter['>=TIMESTAMP_X'] = $updatedFrom->format('d.m.Y H:i:s');
        }


        $arNavParam = false;

        if ($id) {
            $arFilter['ID'] = $id;
        } else {
            $arNavParam = [
                'nPageSize' => $this->result->pageSize,
                'iNumPage' => $this->result->page,
                'checkOutOfRange' => true,
            ];
        }

        $res = \CIBlockElement::GetList([], $arFilter, false, $arNavParam);

        $dataRes = [];
        $elements_count = 0;
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $dataSKU = $this->getSKU($arFields['ID']);
            $arFields['sku'] = $dataSKU['ID'];

            $dataProduct = \CCatalogProduct::GetByID($arFields['ID']);

            $productPropsDb = \CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID']);

            $props = [];
            $photo = [];

            while ($productProps = $productPropsDb->Fetch()) {
                $props[] = $productProps;
                if ($productProps['CODE'] == 'MORE_PHOTO') {
                    $photo[] = $productProps;
                }
            }

            $arFields['QUANTITY'] = $dataProduct['QUANTITY'];

            $arFields['QUANTITY_TRACE_ORIG'] = $dataProduct['QUANTITY_TRACE_ORIG'] == 'Y';

            $arFields['WEIGHT'] = $dataProduct['WEIGHT'];

            $arFields['ENABLED'] = $arFields['ACTIVE'] == 'Y';

            $globResOptions = [];

            $offersArr = \CCatalogSKU::getOffersList($arFields['ID'], 0, $offersFilter);

            if ($offersArr) {
                $elements_count++;
                $resOptions = [];
                $props = [];
                foreach ($offersArr[$arFields['ID']] as $offer) {
                    $price = \CPrice::GetBasePrice($offer['ID']);

                    $dataItem = \CCatalogProduct::GetByIDEx($offer['ID']);
                    $dataItemProps = $dataItem['PROPERTIES'];

                    $tmpProp = [
                        'PRICE' => $price['PRICE'],
                        'ID' => $offer['ID'],
                    ];

                    $tmpProp['VAT_CODE'] = $this->getVat(\CCatalogVat::GetByID($dataItem['PRODUCT']['VAT_ID']));

                    foreach ($dataItemProps as $key => $itemProps) {
                        if ($itemProps['VALUE']
                            && $key != 'CML2_LINK'
                            && $key != 'MORE_PHOTO'
                        ) {
                            $tmpProp1 = \CIBlockElement::GetProperty($offer['IBLOCK_ID'], $offer['ID'], [], Array("CODE" => $key))->Fetch();

                            if ($tmpProp1['PROPERTY_TYPE'] == 'L') {
                                $testData = $this->getPropertyEnum($tmpProp1['IBLOCK_ID']);

                                foreach ($testData as $testKey => $testItem) {
                                    if ($testItem == $itemProps['VALUE']) {
                                        $itemProps['VALUE'] = $testKey;
                                    }
                                }
                            }

                            $tmpObj = new \stdClass();
                            $tmpObj->propcode = $key;
                            $tmpObj->type = 'TEXTFIELD';
                            $tmpObj->name = $itemProps['NAME'];
                            $tmpObj->text = (string)$itemProps['VALUE'];
                            $tmpProp['PARAMS'][] = $tmpObj;
                        }
                    }
                    $tmpResOptions = new Options($tmpProp);
                    $resOptions[] = $tmpResOptions;
                }

                $globResOptions = $resOptions;
            } else {

                $product_time_update = new \DateTime($arFields['TIMESTAMP_X']);
                if ($updatedFrom &&  $product_time_update > $updatedFrom && $dataProduct['TYPE'] != 3) {
                    $elements_count++;
                } else {
                    continue;
                }
            }

            $arFields['OPTIONS'] = $globResOptions;

            $priceProduct = \CCatalogProduct::GetOptimalPrice($arFields['ID']);

            $arFields['PRICE'] = $priceProduct['PRICE']['PRICE'];

            foreach ($arFields['OPTIONS'] as &$optionItem) {
                if (is_object($optionItem)) {
                    unset($optionItem);
                }
            }

            $productDetailPicture = $this->getPicture($arFields['DETAIL_PICTURE']);

            $imgUrl = '';
            if ($productDetailPicture['SRC']) {
                $imgUrl .= $this->getBaseUrl() . $productDetailPicture['SRC'];
            }

            $arFields['thumbnailUrl'] = $imgUrl;
            $arFields['imageUrl'] = $imgUrl;
            $arFields['smallThumbnailUrl'] = $imgUrl;
            $arFields['hdThumbnailUrl'] = $imgUrl;
            $arFields['originalImageUrl'] = $imgUrl;
            $arFields['originalImage'] = $imgUrl;
            $arFields['hdThumbnailUrl'] = $imgUrl;

            $arFields['IBLOCK_SECTION_ID'] = intval($arFields['IBLOCK_SECTION_ID']);

            $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arFields['IBLOCK_ID'], $arFields['ID']);
            $seoProperty = $ipropValues->getValues();

            $arFields['seoTitle'] = $seoProperty['ELEMENT_META_TITLE'];
            $arFields['seoDescription'] = $seoProperty['ELEMENT_META_DESCRIPTION'];

            $arFields['DETAIL_PAGE_URL'] = $this->getBaseUrl() . $arFields['DETAIL_PAGE_URL'];

            $arFields["VAT_CODE"] = $this->getVat(\CCatalogVat::GetByID($dataProduct['VAT_ID']));

            $item = new Item($arFields);


            foreach ($photo as $photoItem) {
                $dataPic = $this->getPicture($photoItem['PROPERTY_VALUE_ID']);
                if ($dataPic['SRC']) {
                    $dataPic['SRC'] = $this->getBaseUrl() . $dataPic['SRC'];
                } else {
                    $dataPic['SRC'] = '';
                }

                $picObj = new Picture($dataPic);
                $item->galleryImages[] = $picObj;
            }

            $item->dimensions->length = $dataProduct['LENGTH'];
            $item->dimensions->width = $dataProduct['WIDTH'];
            $item->dimensions->height = $dataProduct['HEIGHT'];

            $dataRes[] = $item;
        }

        if ($id) {
            $this->result = array_shift($dataRes);
            if (!$this->result) {
                $this->result = [];
            }
        } else {
            $this->result->items = $dataRes;

            $this->result->total = $elements_count;
            $this->result->count = count($this->result->items);
        }

        return $this->result;
    }

    //*****************************************************

    public function executePOST($id = null, $tmp = null)
    {
        if ( $tmp == null ) {
            $data = json_decode(file_get_contents('php://input'));
        }
        else {
            $data = json_decode($tmp);
        }
//        file_put_contents("loggernew.txt", file_get_contents('php://input'), FILE_APPEND);

//        $data->sku = null;

        $element = new \CIBlockElement;

        $parentId = end($data->categoryIds);

        $code = $this->generateCode($data->name);

        $sectionCode = 'catalog';

        if ($data->sku) {
            $sectionCode = 'offers';
        }

        $catalogRes = \CCatalog::GetList([], ['IBLOCK_TYPE_ID' => $sectionCode])->Fetch();

        $arProductArray = [
            'MODIFIED_BY' => 1,
            'IBLOCK_SECTION_ID' => $parentId,
            'IBLOCK_ID' => $catalogRes['IBLOCK_ID'],
            'NAME' => $data->name,
            'ACTIVE' => 'Y',
            'DETAIL_TEXT' => $data->description,
            'CODE' => $code,
            'DETAIL_PICTURE' => \CFile::MakeFileArray($data->picture),
            'PROPERTY_VALUES' => [
                $catalogRes['SKU_PROPERTY_ID'] => $data->sku
            ]
        ];

//        if ($data->sku && !$id) {
//            $PRODUCT_ID = $data->sku;
//        } else {
        if ($id) {
            $PRODUCT_ID = $id;
            $resUpdTmp = $element->Update($PRODUCT_ID, $arProductArray);
        } else {
            $PRODUCT_ID = $element->Add($arProductArray);

            if (!$PRODUCT_ID) {
                $arProductArray['CODE'] .= substr(time(), -4);

                $PRODUCT_ID = $element->Add($arProductArray);
            }
        }

        if (!$PRODUCT_ID) {
            return ['error' => $element->LAST_ERROR];
        }

        $arFilterAdd = [
            'ID' => $PRODUCT_ID,
            'AVAILABLE' => 'Y',
            'PURCHASING_PRICE' => $data->price,
            'PURCHASING_CURRENCY' => 'RUB',
            'WEIGHT' => $data->weight,
            'WIDTH' => $data->width,
            'LENGTH' => $data->length,
            'HEIGHT' => $data->height,
            'PRICE_TYPE' => 'S'
        ];

        if ($data->unlimited) {
            $arFilterAdd['QUANTITY_TRACE'] = 'N';
        } else {
            $arFilterAdd['QUANTITY_TRACE'] = 'Y';
        }


        $arProp = [];

        if ($data->gallery) {
            foreach ($data->gallery as $img) {
                $arProp['MORE_PHOTO'][] = $img;
            }

            $arProductArray[] = $arProp;
        }

        if ($data->sku) {
            $arProductArray['TYPE'] = \Bitrix\Catalog\ProductTable::TYPE_OFFER;
        }

        if ($id) {
            unset($arFilterAdd['ID']);
            $resUpdBaseProp = $element->Update($PRODUCT_ID, $arProductArray);
            $this->updateItemCatalog($PRODUCT_ID, $arFilterAdd);
        } else {
            $this->newItemCatalog($arFilterAdd);
        }

        if ($data->price) {
            $addPrice = \CPrice::SetBasePrice($PRODUCT_ID, $data->price, 'RUB');
        }

        if ($data->quantity) {
            $arFields = [
                'PRODUCT_ID' => $PRODUCT_ID,
                'STORE_ID' => $data->storeId,
                'AMOUNT' => $data->quantity,
            ];

            if ($id) {
                $ID = \CCatalogStoreProduct::Update($PRODUCT_ID, $arFields);
            } else {
                $ID = \CCatalogStoreProduct::Add($arFields);
            }
            $this->updateItemCatalog($PRODUCT_ID, ['QUANTITY' => $data->quantity]);
        }

        $this->updateItemCatalog($PRODUCT_ID, ['CAN_BUY_ZERO' => 'Y']);


        $data->sku = $PRODUCT_ID;
        $intOfferID = $PRODUCT_ID;
//        }

        $results = [];

        if ($PRODUCT_ID) {
            $resId = null;

            if (!$data->sku) {
                $resId = $PRODUCT_ID;
            } else {
                $resId = $intOfferID;

                $nameOptions = 'options';

                if (!$data->$nameOptions) {
                    $nameOptions = 'params';
                }

                $data->options = $data->$nameOptions;

                if ($data->options) {
                    foreach ($data->options as $option) {
                        if ($nameOptions == 'options') {
                            $tmpObj = new \stdClass();
                            $tmpObj->name = $data->name;
                            $tmpObj->categoryIds = $data->categoryIds;
                            $tmpIdElement = null;
                            if ($data->sku) {
                                $tmpIdElement = $data->sku;
                            }
                            $tmpObj->sku = ($data->sku) ? $data->sku : $resId;
                            $tmpObj->price = $option->price;
                            $tmpObj->params = $option->params;

//                            file_put_contents("loggernew.txt", json_encode($tmpObj), FILE_APPEND);
                            $tmpRes = $this->executePOST($tmpIdElement, json_encode($tmpObj));
                        }

                        if ($tmpRes['id'] || ($data->sku && $resId && $nameOptions == 'params')) {

                            if (!$tmpRes['id']) {
                                $tmpRes['id'] = $resId;
                            }

                            $tmpCatalogRes = \CCatalog::GetList([], ['IBLOCK_TYPE_ID' => 'offers'])->Fetch();
                            $arFilter = ['IBLOCK_ID' => $tmpCatalogRes['IBLOCK_ID'], 'ACTIVE' => 'Y'];
                            $productPropsDb = \CIBlockProperty::GetList(['SORT' => 'ASC'], $arFilter);

                            $propsIBlock = [];

                            while($resProp = $productPropsDb->Fetch()) {
                                if ($resProp['USER_TYPE'] == 'directory') {
                                    $resProp['list'] = $this->getDictionaryData($resProp['USER_TYPE_SETTINGS']['TABLE_NAME']);
                                }
                                $propsIBlock[$resProp['CODE']] = $resProp;
                            }

                            $propsAdd = [];

                            $tmpSpecOPtions = new \stdClass();

                            if ($nameOptions == 'params') {
                                $tmpSpecOPtions->params[] = $option;
                            } else {
                                $tmpSpecOPtions->params = $option->params;
                            }

                            foreach ($tmpSpecOPtions->params as $param) {
                                if ($propsIBlock[$param->propcode]) {
                                    $propValue = $param->value;
                                    if (isset($propsIBlock[$param->propcode]['list'])) {
                                        if (isset($propsIBlock[$param->propcode]['list'][$param->value])) {
                                            $propValue = $param->value;
                                        } else {
                                            $this->addDictionaryData($propsIBlock[$param->propcode]['USER_TYPE_SETTINGS']['TABLE_NAME'], ['UF_NAME' => $propValue, 'UF_XML_ID' => $propValue]);
                                        }
                                    }
                                    if ($propsIBlock[$param->propcode]['PROPERTY_TYPE'] == 'L') {
                                        $enums = $this->getPropertyEnum($propsIBlock[$param->propcode]['IBLOCK_ID']);
                                        if (isset($enums[$param->value])) {
                                            $propValue = $enums[$param->value];
                                        } else {
                                            $paramEnum = [
                                                'PROPERTY_ID' => $propsIBlock[$param->propcode]['ID'],
                                                'VALUE' => $param->value,
                                            ];
                                            $propValue = $this->addPropertyEnum($paramEnum);
                                        }
                                    }
                                    $propsAdd['PROPERTY_VALUES'][$propsIBlock[$param->propcode]['ID']] = $propValue;
                                } else {

                                    $addParamsProp = [
                                        'NAME' => $param->name,
                                        'ACTIVE' => 'Y',
                                        'CODE' => $param->propcode,
                                        'PROPERTY_TYPE' => 'L',
                                        'IBLOCK_ID' => $tmpCatalogRes['IBLOCK_ID'],
                                    ];
                                    $tmpPropId = $this->addProperty($addParamsProp);
                                    if ($tmpPropId) {
                                        $paramEnum = [
                                            'PROPERTY_ID' => $propsIBlock[$param->propcode]['ID'],
                                            'VALUE' => $param->value,
                                        ];
                                        $propValue = $this->addPropertyEnum($paramEnum);
                                        $propsAdd['PROPERTY_VALUES'][$propsIBlock[$param->propcode]['ID']] = $propValue;
//                                        $propsAdd['PROPERTY_VALUES'][$param->propcode] = $param->value;
                                    }
                                }
                            }

                            if ($propsAdd) {
                                $elementProp = new \CIBlockElement;

                                foreach ($propsAdd['PROPERTY_VALUES'] as $codeTmpId => $ttttmpProps) {

                                    \CIBlockElement::SetPropertyValuesEx($tmpRes['id'], $tmpCatalogRes['IBLOCK_ID'], [$codeTmpId => $ttttmpProps]);

                                    if ($option->lbid) {
                                        $results[$option->lbid] = $tmpRes['id'];
                                    }
                                }
                            }
                        }
                    }
                }
            }

//            file_put_contents("loggernew.txt", "id=". $resId . "\r\n lbid=" . implode(',',$data->lbid) . "\r\n res=" . implode(',',$results) . "\r\n", FILE_APPEND );
            return ['id' => $resId, 'lbid' => $data->lbid, 'results' => $results];
        } else {
            return ['error' => $element->LAST_ERROR, 'results' => $results];
        }
    }

    //*********************************
    private function getVat($QueryVat)
    {
        $res = null;
        if($Vat = $QueryVat->Fetch())
        {
            if($Vat["NAME"] == "Без НДС")
                $res = "Без НДС";
            else
                $res = "VAT_".intval($Vat["RATE"]);
        }
        return $res;
    }

    //**********************************

    public function ImageexecutePOST($id = null)
    {
        $data = file_get_contents('php://input'); //image

        $dbE = \CIBlockElement::GetList(Array(), Array('ID' => $id));
        $item = $dbE->Fetch();

        if (!$item) {
            return ['id' => $id];
        }

        $iblockId = $item['IBLOCK_ID'];

        $headers = getallheaders();

        $arFile['content'] = $data;
        $arFile['name'] = "tmp." . str_replace('image/', '', $headers['Content-Type']);
        $arFile['type'] = $headers['Content-Type'];

        $imageId = \CFile::SaveFile($arFile);

        if ($imageId) {
            $props = \CIBlockElement::GetProperty($iblockId, $id, [], ['CODE' => 'MORE_PHOTO']);

            while($prop = $props->Fetch()) {
                $res = \CIBlockElement::SetPropertyValuesEx($id, $iblockId, ['MORE_PHOTO' => [$prop['PROPERTY_VALUE_ID'] => ['del' => 'Y']] ]);
            }

            \CIBlockElement::SetPropertyValuesEx($id, $iblockId, ['MORE_PHOTO' => [\CFile::MakeFileArray($imageId)] ]);
        }

        return ['id' => $imageId];
    }

    /**
     * Получение данных из хайлоада
     * @param $tableName
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getDictionaryData($tableName)
    {
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['TABLE_NAME' => $tableName]])->fetch();

        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $Query = new \Bitrix\Main\Entity\Query($entity);

        $Query->setSelect(['UF_NAME', 'ID', 'UF_XML_ID']);
        $Query->setOrder([]);

        $resultHl = $Query->exec();

        $arResultHL = new \CDBResult($resultHl);

        $result = [];

        while ($resHL = $arResultHL->Fetch()) {
            $result[$resHL['UF_XML_ID']] = [
                'name' => $resHL['UF_NAME'],
                'id' => $resHL['ID']
            ];
        }

        return $result;
    }

    /**
     * Добавление элемента в хайлоад
     * @param $hlbl
     * @param $data
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function addDictionaryData($hlbl, $data)
    {
        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['TABLE_NAME' => $hlbl]])->Fetch();
        if ($hlData) {
            $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlData['ID'])->fetch();

            $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();

            $result = $entity_data_class::add($data);
        }
    }

    /**
     * Получение значений инфоблока
     * @param $IBLOCK_ID
     * @return array
     */
    private function getPropertyEnum($IBLOCK_ID)
    {
        $property_enums = \CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID));

        $results = [];

        while($enum_fields = $property_enums->Fetch()) {
            $results[$enum_fields['VALUE']] = $enum_fields['ID'];
        }

        return $results;
    }

    private function addPropertyEnum($params)
    {
        $ibpenum = new \CIBlockPropertyEnum;
        $PropID = $ibpenum->Add($params);
        return $PropID;
    }

    /**
     * Добавление нового свойства
     * @param $params
     * @return bool
     */
    private function addProperty($params)
    {
        $ibp = new \CIBlockProperty;
        $PropID = $ibp->Add($params);
        if ($PropID) {
            return $PropID;
        }
    }
}