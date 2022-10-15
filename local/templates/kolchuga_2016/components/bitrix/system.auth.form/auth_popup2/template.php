<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$frame = $this->createFrame()->begin();
?>
<?
//ShowMessage($arParams["~AUTH_RESULT"]);
//ShowMessage($arResult['ERROR_MESSAGE']);
?>

<? if ($USER->IsAuthorized()): ?>

    <? /*<a href="?logout=yes"><?=GetMessage('AUTH_LOGOUT')?></a><a href="/personal/profile/"><?=$USER->GetLogin()?></a>*/ ?>
    <a href="/personal/profile/">
        <svg width="27" height="27" viewBox="3 3 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 7.5V28.5C4.5 30.2 5.8 31.5 7.5 31.5H28.5C30.2 31.5 31.5 30.2 31.5 28.5V7.5C31.5 5.9 30.2 4.5 28.5 4.5H7.5C5.8 4.5 4.5 5.9 4.5 7.5ZM22.5 13.5C22.5 16 20.5 18 18 18C15.5 18 13.5 16 13.5 13.5C13.5 11 15.5 9 18 9C20.5 9 22.5 11 22.5 13.5ZM9 25.5C9 22.5 15 20.8 18 20.8C21 20.8 27 22.5 27 25.5V27H9V25.5Z"
                  fill="#21385E"/>
        </svg>
    </a>
<? else: ?>

    <!--noindex-->
    <a href="/auth/" rel="nofollow"><? //=GetMessage("AUTH_TITLE_MESS")?>
        <svg width="27" height="27" viewBox="3 3 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 7.5V28.5C4.5 30.2 5.8 31.5 7.5 31.5H28.5C30.2 31.5 31.5 30.2 31.5 28.5V7.5C31.5 5.9 30.2 4.5 28.5 4.5H7.5C5.8 4.5 4.5 5.9 4.5 7.5ZM22.5 13.5C22.5 16 20.5 18 18 18C15.5 18 13.5 16 13.5 13.5C13.5 11 15.5 9 18 9C20.5 9 22.5 11 22.5 13.5ZM9 25.5C9 22.5 15 20.8 18 20.8C21 20.8 27 22.5 27 25.5V27H9V25.5Z"
                  fill="#c4c4c4"/>
        </svg>
    </a>
    <!--/noindex-->

<? endif; ?>
