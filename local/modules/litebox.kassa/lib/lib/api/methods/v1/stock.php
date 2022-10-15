<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 12.04.2018
 * Time: 17:45
 */

namespace litebox\kassa\lib\Api\Methods\v1;


class Stock extends Base
{
    public function executeGET()
    {
        $arFilter = [];
        if ($this->result->offset) {
            $arNavStartParams = [
                'nTopCount' => $this->result->offset
            ];

            $db = \CCatalogStoreProduct::GetList(['ID' => 'ASC'], [], false, $arNavStartParams);

            $categoryResult = [];

            while($dbRes = $db->Fetch()) {
                $categoryResult[] = $dbRes;
            }

            $startId = end($categoryResult)['ID'];

            $arFilter = ['>ID' => $startId];
        }

        $arNavStartParams = [
            'nTopCount' => $this->result->limit
        ];

        $db = \CCatalogStoreProduct::GetList(['ID' => 'ASC'], $arFilter, false, $arNavStartParams);

        $data = [];

        while($dbRes = $db->Fetch()) {
            $data[] = $dbRes;
        }

        $this->result->total = \CCatalogStoreProduct::GetList([], [])->SelectedRowsCount();

        $this->result->items = $data;
        $this->result->count = count($data);

        return $this->result;
    }

    public function executePOST($id = null)
    {
        $data = json_decode(file_get_contents('php://input'));

        $arFields = [
            'QUANTITY' => $data->quantity
        ];

        $result = $this->updateItemCatalog($data->productId, $arFields);

        $res = $this->updateItemInStock($id, $data->productId, $data->quantity);

        $globalResult = $res && $result;

        return ['result' => $globalResult];
    }
}