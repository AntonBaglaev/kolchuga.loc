<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class CNewsStockList extends CBitrixComponent
{

    var $arFilter = array(
        '=ACTIVE'           => 'Y',
        'ACTIVE_DATE'       => 'Y',
        '!=PREVIEW_PICTURE' => false,
        '!=DETAIL_PICTURE'  => false,
    );

    var $arSelect = array(
        'ID',
        'NAME',
        'CODE',
        'IBLOCK_ID',
        'PREVIEW_TEXT',
        'PREVIEW_PICTURE',
        'DETAIL_PICTURE',
        'DETAIL_PAGE_URL',
    );

    public function executeComponent()
    {

        if ($this->StartResultCache()) {

            if (!\Bitrix\Main\Loader::IncludeModule('iblock')) {
                $this->abortResultCache();
                return false;
            }

            $arFilter = $this->arFilter;
//			$arFilter['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];

            $this->arResult['ITEMS'] = array();

            $arVKLinks = [];

            $arVKSelect = array("ID", "IBLOCK_ID", "NAME", "PROPERTY_VK_LINK");
            $arVKFilter = array("IBLOCK_ID" => 56, "ACTIVE" => "Y", "!PROPERTY_VK_LINK" => false); // Из инфоблока Пост из VK
            $resVK = CIBlockElement::GetList(array("ID" => "DESC"), $arVKFilter, false, array("nPageSize" => 15), $arVKSelect);
            while ($obVK = $resVK->GetNextElement()) {
                $arFields = $obVK->GetFields();

                if ($arFields['PROPERTY_VK_LINK_VALUE']) {
                    $arVKLinks[] = str_replace('https://vk.com/wall-', '', $arFields['PROPERTY_VK_LINK_VALUE']);
                }
            }

            if (!$arVKLinks) {
                $this->abortResultCache();
                return false;
            }

            foreach ($arVKLinks as $link) {

                $records_json = file_get_contents("https://api.vk.com/method/wall.getById?posts=-" . $link . "&extended=0&v=5.81&access_token=vk1.a.igD8cSxsrkQdQJvhO_rjf1jEqD1BxtqTO2k25PSc9z164zbZY_Zip8D-VPhqXc77UNtnHqjQnewJKrV9lhBpxs5sd8MQ9_soznE10PERw23eUsq_34EBlN3KrqrrDSzeXAjsEqGaXp7p4NjPmNb8zQlaKVYgWmUhvz-_0cnM4IUhuJBMDRFF6srOIWO-g0Ry");

                $arRecords = json_decode($records_json, true);

                if (!$arRecords)
                    continue;

                $arItemRaw = current($arRecords['response']);

                $arItem['text'] = nl2br(preg_replace('/(http[s]{0,1}\:\/\/\S{4,})\s{0,}/ims', '<a href="$1" target="_blank">Ссылка&nbsp;на&nbsp;сайт</a> ', $arItemRaw['text']));
                $arItem['text'] = str_replace('kolchuga.ru ', '<a href="https://kolchuga.ru">kolchuga.ru</a> ', $arItem['text']);
                $arItem['comments'] = $arItemRaw['comments']['count'];
                $arItem['likes'] = $arItemRaw['likes']['count'];
                $arItem['reposts'] = $arItemRaw['reposts']['count'];
                $arItem['views'] = $arItemRaw['views']['count'];
                $arItem['link'] = 'https://vk.com/kolchugashop?w=wall-' . $link;
                $arItem['date'] = $arItemRaw['date'];

                $arCurPhoto = [];

                if (current($arItemRaw['attachments'])['photo']['sizes']) {
                    foreach (current($arItemRaw['attachments'])['photo']['sizes'] as $arPhoto) {

                        if ($arPhoto['type'] == 'x' && !$arCurPhoto)
                            $arCurPhoto = $arPhoto['url'];

                        if ($arPhoto['width'] > 320 && $arPhoto['width'] < 700 && !$arCurPhoto) {
                            $arCurPhoto = $arPhoto['url'];
                        }
                    }
                }

                $arItem['photo'] = $arCurPhoto;

                $arItem['video'] = [];

                $arVideoRaw = current($arItemRaw['attachments'])['video'];

                if ($arVideoRaw) {

                    $video_json = file_get_contents("https://api.vk.com/method/video.get?videos=" . $arVideoRaw['owner_id'] . "_" . $arVideoRaw['id'] . "&v=5.81&access_token=vk1.a.igD8cSxsrkQdQJvhO_rjf1jEqD1BxtqTO2k25PSc9z164zbZY_Zip8D-VPhqXc77UNtnHqjQnewJKrV9lhBpxs5sd8MQ9_soznE10PERw23eUsq_34EBlN3KrqrrDSzeXAjsEqGaXp7p4NjPmNb8zQlaKVYgWmUhvz-_0cnM4IUhuJBMDRFF6srOIWO-g0Ry");

                    $arVideos = json_decode($video_json, true);

                    if (!current($arVideos['response']['items'])['width'])
                        current($arVideos['response']['items'])['width'] = 1920;

                    if (!current($arVideos['response']['items']['height']))
                        current($arVideos['response']['items'])['height'] = 1080;

                    $arItem['video'] = current($arVideos['response']['items']);

                }

                $this->arResult['ITEMS'][] = $arItem;

            }

        }
        $this->endResultCache();

        $this->IncludeComponentTemplate();

    }

}