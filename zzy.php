<script>
    width=screen.width; // ширина
    height=screen.height; // высота
    alert ("Разрешение экрана: "+width+"x"+height);

    width2=document.body.clientWidth; // ширина
    height2=document.body.clientHeight; // высота
    alert ("Разрешение окна клиента: "+width2+"x"+height2);
</script>
<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
/*use \Bitrix\Conversion\Internals\MobileDetect;

$detect = new MobileDetect;
 if($detect->isMobile())
   {
    echo 'mob';
   }*/
   
   /*$isMobile=\Bitrix\Main\Loader::includeModule('conversion') && ($md=new \Bitrix\Conversion\Internals\MobileDetect) && $md->isMobile();
   if($isMobile)
   {
    echo 'mob';
   }*/