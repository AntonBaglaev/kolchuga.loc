<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 09.04.2018
 * Time: 1:18
 */

namespace litebox\kassa\lib\Api\Methods\v1;

use litebox\kassa\lib\Template\Category\Category;

class Categories extends Base
{
    /**
     * Получение категорий
     * @param null $parent
     * @param null $id
     * @return array|\litebox\kassa\lib\Template\Result
     */
    public function executeGET($parent = null, $id = null)
    {
        $parentId = $parent;
        $arFilter = [
            'IBLOCK_TYPE' => 'catalog',
        ];

        $arNavParam = false;

        //реализована фильтрация по id родителю раздела
        if ($parentId) {
            $arFilter['SECTION_ID'] = $parentId;
        }

        if ($id) {
            $arFilter['ID'] = $id;
        } else {
            $arNavParam = [
                'nPageSize' => $this->result->pageSize,
                'iNumPage' => $this->result->page,
                'checkOutOfRange' => true,
            ];
        }

        $res = \CIBlockSection::GetList([], $arFilter, true, ['*'], $arNavParam);

        $categoryObj = [];

        while ($dbRes = $res->Fetch()) {
            $categoryRes = new Category($dbRes);

            $productPic = $this->getPicture($dbRes['PICTURE']);

            $srcUrl = '';
            if ($productPic['SRC']) {
                $srcUrl = $this->getBaseUrl() . $productPic['SRC'];
            }

            $categoryRes->hdThumbnailUrl = $srcUrl;
            $categoryRes->thumbnailUrl = $srcUrl;
            $categoryRes->imageUrl = $srcUrl;
            $categoryRes->originalImageUrl = $srcUrl;
            $categoryRes->originalImage = $srcUrl;

            $productsInSection = $this->getElementsList($dbRes['IBLOCK_ID'], $dbRes['CODE']);

            $categoryRes->enabledProductCount = count($productsInSection);

            foreach ($productsInSection as &$item) {
                $item = intval($item);
            }

            $categoryRes->productIds = $productsInSection;

            $categoryRes->productCount = count($this->getElementsList($dbRes['IBLOCK_ID'], $dbRes['CODE'], false));

            $categoryObj[] = $categoryRes;
        }

        if ($id) {
            if ($categoryObj) {
                $categoryObj = array_pop($categoryObj);
            } else {
                $categoryObj = (object)[];
            }
            $this->result = $categoryObj;
        } else {
            $this->result->items = $categoryObj;

            $this->result->total = \CIBlockSection::GetList([], $arFilter)->result->num_rows;
            $this->result->count = count($categoryObj);
        }

        return $this->result;
    }

    public function executePOST($id = null)
    {

        $data = json_decode(file_get_contents('php://input'));

        if ($data) {
            $decode_fields = [
                'name'=>$data->name,
                'parentId'=>$data->parentId,
                'description'=>$data->description
            ];
            foreach ($decode_fields as $key => $value){
                $decode_fields[$key] = $this->escape_win($value);
                if (strlen($decode_fields[$key]) != strlen($data->$key)) {
                    $data->$key = $decode_fields[$key];
                }
            }
        }

        $arFilter['IBLOCK_TYPE'] = 'catalog';

        $res = \CIBlockSection::GetTreeList($arFilter);
        $iblockData = $res->Fetch();

        $iblock = new \CIBlockSection();

        $arFields = [
            'ACTIVE' => 'Y',
            'IBLOCK_SECTION_ID' => $data->parentId,
            'IBLOCK_ID' => $iblockData['IBLOCK_ID'],
            'NAME' => $data->name,
            'SORT' => $data->orderBy,
            'DESCRIPTION' => $data->description,
            'DESCRIPTION_TYPE' => 'html',
            'CODE' => $this->generateCode($data->name, $data->parentId),
        ];

        if (!$id) {
            $ID = $iblock->Add($arFields);
        } else {
            $ID = $id;

            $resUpdate = $iblock->Update($ID, $arFields);
        }

        if (!$ID) {
            return json_encode(['id' => $ID]);
        }

        if ($data->productIds) {
            foreach ($data->productIds as $productId) {
                $arFields = [
                    'IBLOCK_SECTION_ID' => $ID,
                ];

                $productDataElement = new \CIBlockElement;

                $productDataElement->Update($productId, $arFields);
            }
        }

        return ['id' => $ID];
    }
}