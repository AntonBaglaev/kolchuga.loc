<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin();
?>
	<?
	//ShowMessage($arParams["~AUTH_RESULT"]);
	//ShowMessage($arResult['ERROR_MESSAGE']);
	?>

<?if($USER->IsAuthorized()):?>
<div class="header__auth">
    <a href="?logout=yes"><?=GetMessage('AUTH_LOGOUT')?></a><a href="/personal/profile/"><?=$USER->GetLogin()?></a>
</div>
<?else:?>
    <div class="header__auth">
    	<noindex>
	       <a href="/auth/" rel="nofollow"><?=GetMessage("AUTH_TITLE_MESS")?></a>
	    </noindex>   
    </div>
<?endif;?>
