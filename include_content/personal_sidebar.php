<aside class="sidebar__personal">
    <div class="sidebar__block">
        <div class="sidebar__menu">
            <div class="sidebar__menu--title">
                <span>Личный кабинет</span> <a href="/personal/profile/"><img src="/images/svg/login-24px-3.svg" /></a><?if($USER->GetID()=="11460" || ($_REQUEST['ps']==22 && !$USER->IsAuthorized() )){?><?}?>
            </div>
            <? $APPLICATION->IncludeComponent("bitrix:menu", "personal", Array(
                    "ROOT_MENU_TYPE" => "left",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "N",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "Y",
                    "MENU_CACHE_TIME" => "360000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => "",
                )
            ); ?>
        </div>
    </div>
</aside>

<style>
.sidebar__menu--title{
	position: absolute;
    background-color: transparent;
    top: -44px;
    color: #5c5c5c;
    border: none;
    font-size: 20px;
	right:0;
	padding-right: 0;
}
.sidebar__menu ul{
	border-left: none;
    border-right: none;
}
@media screen and (max-width: 576px) {
	.sidebar__menu--title{	position: relative;top: 0;	}
}
</style>
<?if($USER->IsAuthorized()){?>
<style>
.sidebar__menu--title{
	width:100%;	
}
</style>
<?}?>