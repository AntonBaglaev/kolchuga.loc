<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 12.04.2018
 * Time: 9:40
 */

namespace litebox\kassa\lib\Api\Methods\v1;


class Gallery extends Base
{
    public function executePOST($externalUrl = null)
    {
        $arFile = \CFile::MakeFileArray($externalUrl);

        if ($arFile) {
            $resultUpload = \CFile::SaveFile($arFile);

            return ['id' => $resultUpload];
        }

        return ['error' => 'error loading'];
    }
}