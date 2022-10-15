<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Context;

$request = Application::getInstance()->getContext()->getRequest();

if ($request->isPost()) {

    $arResult = [];

    //Получаем товары пользователя
    $basket = Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());

    $basketItems = $basket->getBasketItems();

    //Массив с товарами для Яндекс.Доставки
    $_SESSION['ORDER_ITEMS'] = [];

    foreach ($basketItems as $item) {

        $productsId = $item->getProductId();
        $productsBasketId = $item->getId();
        $productsName = $item->getField('NAME');
        $productsPrice = number_format($item->getField('PRICE'), 2, '.', ' ');
        $productsQuantity = number_format($item->getField('QUANTITY'), 0, '.', ' ');
        $productTotalPrice = number_format(($item->getField('PRICE') * $item->getField('QUANTITY')), 2, '.', ' ');


        $arOrder = ['NAME' => 'ASC'];
        $arSelect = [
            'PREVIEW_PICTURE',
            'DETAIL_PAGE_URL',
            'PROPERTY_CML2_LINK',
            'PROPERTY_CML2_ARTICLE',
        ];
        $arFilter = [
            'ACTIVE' => 'Y',
            'ID' => $productsId,
        ];

        $res = \CIBlockElement::GetList($arOrder, $arFilter, false, ['nPageSize' => 1], $arSelect);
        while ($arRes = $res->GetNext()) {

            $elementId = $arRes['PROPERTY_CML2_LINK_VALUE'];

            //Торговое предложение
            if (!empty($elementId)) {

                $arOrder = ['NAME' => 'ASC'];
                $arSelect = [
                    'PREVIEW_PICTURE',
                    'DETAIL_PAGE_URL',
                    'PROPERTY_CML2_ARTICLE',
                ];
                $arFilter = [
                    'ACTIVE' => 'Y',
                    'ID' => $elementId,
                ];

                $res = \CIBlockElement::GetList($arOrder, $arFilter, false, ['nPageSize' => 1], $arSelect);
                while ($arRes = $res->GetNext()) {

                    //Фотография товара
                    if (!empty($arRes['PREVIEW_PICTURE'])) {

                        $productPhoto = CFile::GetPath($arRes['PREVIEW_PICTURE']);

                    } else {

                        $productPhoto = SITE_TEMPLATE_PATH . '/images_delivery/no_photo.png';

                    }

                    //Артикул товара
                    $productsCode = $arRes['PROPERTY_CML2_ARTICLE_VALUE'];

                    //Ссылка на товар
                    $productUrl = $arRes['DETAIL_PAGE_URL'];

                }

            } else {

                //Фотография товара
                if (!empty($arRes['PREVIEW_PICTURE'])) {

                    $productPhoto = CFile::GetPath($arRes['PREVIEW_PICTURE']);

                } else {

                    $productPhoto = SITE_TEMPLATE_PATH . '/images_delivery/no_photo.png';

                }

                //Артикул товара
                $productsCode = $arRes['PROPERTY_CML2_ARTICLE_VALUE'];

                //Ссылка на товар
                $productUrl = $arRes['DETAIL_PAGE_URL'];

            }

        }

        //Максимальное количество товара
        $productsQuantityMax = \CCatalogProduct::GetByID($item->getProductId())['QUANTITY'];

        $quantityStr = '';

        if ($productsQuantity < $productsQuantityMax) {

            $quantityStr = "<button class='good-item__count-button button-plus' date-basket='$productsBasketId'>+</button>";

        }

        $productsStr .= "
        
            <div class='good-item' id='$productsBasketId'>
                <div class='good-item__img'>
                    <img src='$productPhoto' alt='$productsName'>
                </div>
                <div class='good-item__desc'>
                    <a href='$productUrl' class='good-item__title' target='_blank'>$productsName</a>
                    <span class='good-item__art'>Арт. $productsCode</span>
                    <div class='good-item__info'>
                        <div class='good-item__price'>
                            <span class='good-item__price-top'>Стоимость</span>
                            <span class='good-item__price-bottom'>$productsPrice р.</span>
                        </div>
                        <div class='good-item__count'>
                            <span class='good-item__count-top'>Кол-во</span>
                            <div class='good-item__count-bottom'>
                                <button class='good-item__count-button button-minus' date-basket='$productsBasketId'>-</button>
                                <span class='good-item__count-total' date-quantity='$productsQuantity'>$productsQuantity <span>шт.</span></span>
                                $quantityStr
                            </div>
                        </div>
                        <div class='good-item__total'>
                            <span class='good-item__total-top'>Всего</span>
                            <span class='good-item__total-bottom'>$productTotalPrice р.</span>
                        </div>
                    </div>
                </div>
            </div>
        
        ";

        //Наполняем массив с товарами для Яндекс.Доставки
        $_SESSION['ORDER_ITEMS'][] = [
            'orderitem_article' => $productsCode,
            'orderitem_name' => $productsName,
            'orderitem_quantity' => $item->getField('QUANTITY'),
            'orderitem_cost' => $item->getField('PRICE'),
        ];

    }

    $arResult['BASKET_USER']['PRODUCTS'] = $productsStr;

    if (!empty($arResult['BASKET_USER']['PRODUCTS'])) {

        $arResult['BASKET_USER']['PRICE_TOTAL'] = number_format($basket->getPrice(), 2, '.', ' ') . ' р.';

        if (!empty($_SESSION['DELIVERY_PRICE'])) {

            $deliveryPrice = $_SESSION['DELIVERY_PRICE'];

        } else {

            $deliveryPrice = 0;

        }

        $arResult['BASKET_USER']['DELIVERY_TOTAL'] = number_format($deliveryPrice, 2, '.', ' ') . ' р.';
        $arResult['BASKET_USER']['ORDER_TOTAL'] = number_format(($basket->getPrice() + $deliveryPrice), 2, '.', ' ') . ' р.';

        $arResult['successes'] = 'Y';

    } else {

        $arResult['errors'] = 'N';

    }

    echo json_encode($arResult, true);

}

?>