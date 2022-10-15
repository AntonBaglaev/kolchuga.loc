<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("Загрузка навигации");
?>

<?if($arResult["NavPageCount"] > 1):?>
	<?$plus = $arResult["NavPageNomer"]+1;?>
    <?if ($plus <= $arResult["nEndPage"]):?>
        <?
            
            $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus;

        ?>

        <div class="load_more" data-url="<?=$url?>">
            <a href="javascript:void(0);">Показать ещё</a>
			
        </div>

    <?else:?>

        

    <?endif?>

<?endif?>