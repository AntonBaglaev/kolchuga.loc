<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(empty($arResult['ITEMS'])) return false;?>
<script type="text/javascript">
    jQuery(function() {

        $.fn.startCarousel = function() {
            var bodywidth = $('.img_block_gallery#product_top').width(),
                itemwidth = $('.menu_img li').outerWidth(true),
                mycontwidth = bodywidth > itemwidth ? bodywidth - bodywidth%itemwidth : itemwidth,
                licount = $('.menu_img li').size(),
                jscroll = 1;

            if(licount > mycontwidth/itemwidth){
                jscroll =  mycontwidth/itemwidth;
            } else {
                jscroll = 0;
                mycontwidth = licount * itemwidth;
            }

            $('.block_gallery_content').width(mycontwidth);

            $('.menu_img').jcarousel({
                scroll:jscroll,
                wrap:'circular'
            });
        };

        $(this).startCarousel();

        $(window).resize(function(){
            $(this).startCarousel();
        });
    });
</script>
<h3 class="border_circl color_blue">Новинки</h3>
<div class="img_block_gallery" id="product_top">
<div class="block_gallery_content">
    <ul class="menu_img"><?

        foreach ($arResult['ITEMS'] as $arItem)
        {
            ?><li><?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_ELEMENT_DELETE_CONFIRM')));

            if ($arItem['PREVIEW_PICTURE']['SRC'])
            {
                ?><a class="img_link" href="<?= $arItem['DETAIL_PAGE_URL']?>">
                <img src=" <?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                     id="<?= $this->GetEditAreaId($arItem['ID']); ?>" width="<?= $arItem["PICTURE"]["WIDTH"] ?>"
                     height="<?= $arItem["PICTURE"]["HEIGHT"] ?>" alt="<?= $arItem["NAME"] ?>"
                     title="<?= $arItem["NAME"] ?>"/>
                </a><?
            }
            ?><span><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME'] ?></a></span>
            <div class="price"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></div>
            </li><?
        }
        ?></ul>
    </div>
</div>
