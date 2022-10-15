<?php

$MODULE_ID = 'star.comingsoon'; 
$header = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_header_".SITE_ID);
$color = COption::GetOptionString($MODULE_ID, "selectbox_theme_".SITE_ID);
$logo = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_logo_".SITE_ID);
$text = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_text_".SITE_ID);
$title = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_title_".SITE_ID);
$phone = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_phone_".SITE_ID);
$phone2 = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_phone2_".SITE_ID);
$email = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_email_".SITE_ID);
$address = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_address_".SITE_ID);
$finish_time = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_date_".SITE_ID);

$vk = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_VK_".SITE_ID);
$fb = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_FB_".SITE_ID);
$insta = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_INSTA_".SITE_ID);
$tele = COption::GetOptionString($MODULE_ID, "STAR_COMINGSOON_TELE_".SITE_ID);
$data_count = '';

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$MODULE_ID."/page.php");


if($finish_time) {
  $arTime = explode(' ', $finish_time);
  $hour = $arTime[1];
  if($hour != '') {
    $arHour = explode(':', $hour);
    if(!isset($arHour[0])) {
      $arHour[0] = '00';
    }
    if(!isset($arHour[1])) {
      $arHour[1] = '00';
    }
    if(!isset($arHour[2])){
      $arHour[2] = '00';
    }
    $hour = implode(':', $arHour);
    $hour .= '+03:00';
    $finish_time = $arTime[0].' '.$hour;
  }
  else {
    $finish_time = $finish_time.' '.'00:00:00+03:00';
  }
  
  $date_finish = DateTime::createFromFormat('d.m.Y H:i:s+O', $finish_time);

  $date_finish = $date_finish->getTimestamp();

  $data_count = 'data-counter_date="'.$date_finish.'"';
  
}
?>

<!DOCTYPE html>

<html lang="ru-RU">

<head>

<title><?=$header?></title>

<meta id="viewport" name="viewport" content="">

<script>
var meta_viewport=document.getElementById("viewport");screen.width<1100?screen.width<750?screen.width>screen.height?meta_viewport.setAttribute("content","width=760,user-scalable=0"):meta_viewport.setAttribute("content","width=360,user-scalable=0"):screen.width>screen.height?meta_viewport.setAttribute("content","width=1030,user-scalable=0"):meta_viewport.setAttribute("content","width=760,user-scalable=0"):meta_viewport.setAttribute("content","width=device-width,user-scalable=0"),window.addEventListener("resize",function(){screen.width<1100?screen.width<750?screen.width>screen.height?meta_viewport.setAttribute("content","width=760,user-scalable=0"):meta_viewport.setAttribute("content","width=360,user-scalable=0"):screen.width>screen.height?meta_viewport.setAttribute("content","width=1030,user-scalable=0"):meta_viewport.setAttribute("content","width=760,user-scalable=0"):meta_viewport.setAttribute("content","width=device-width,user-scalable=0")});
</script>

<meta name="format-detection" content="telephone=no">



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="UTF-8" />

<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&amp;subset=cyrillic" rel="stylesheet">



<link rel='stylesheet' type='text/css' href='/bitrix/themes/.default/<?=$MODULE_ID;?>/simple/css/main.css?<?php echo rand();?>' /> 
<link rel='stylesheet' type='text/css' href='/bitrix/themes/.default/<?=$MODULE_ID;?>/simple/css/adaptive.css?<?php echo rand();?>' /> 

</head>

<body <?=$data_count?> class="type3 type3_light">


<div class="main_layout">


<section>
  <div class="block">
    <div class="logo">
        <? if($logo){ ?>
         <img src="<?=$logo?>" alt="">
        <? } ?>
      </div>

    <div class="height_box">

      <div class="main height_item">

        <div class="title"><?=$title?></div>
        <? if($text){ ?>
          <div class="subtitle"><?=$text?></div>
        <? } ?>

          <div class="counter">
            <div class="counter_title"><?=GetMessage("OPENING");?></div>
            <div id="counter_wrap3" class="counter_wrap">
              <div class="counter_item item1"><i><?=GetMessage("DAYS");?></i><span>0</span></div>
              <div class="counter_separator item1"></div>
              <div class="counter_item item2"><i><?=GetMessage("HOURS");?></i><span>0</span></div>
              <div class="counter_separator item2"></div>
              <div class="counter_item item3"><i><?=GetMessage("MINUTES");?></i><span>0</span></div>
              <div class="counter_separator item3"></div>
              <div class="counter_item item4"><i><?=GetMessage("SECONDS");?></i><span>0</span></div>
            </div>
          </div>

      </div>
      
      <? if( $phone || $phone2 || $email || $vk || $fb || $insta || $tele){ ?>
        <div class="side">
          <div class="side_title"><?=GetMessage("CONTACTS_HEADER");?></div>

          <div class="pseudo_table">
            <div class="pseudo_td height_item">

              <? if($phone || $phone2){ ?>
                <ul class="phones">
                  
                  <? if($phone){ ?>
                    <li><?php include("include/phone_svg.php");?><a href="tel:<?=$phone?>" class="phone"><?=$phone?></a></li>
                  <? } ?>
                   <? if($phone2){ ?>
                    <li><?php include("include/phone_svg.php");?><a href="tel:<?=$phone2?>" class="phone"><?=$phone2?></a></li>
                  <? } ?>
                </ul>
              <? } ?>
      
              <? if($email){ ?>
                <ul class="mails">
                  
                  <li><?php include("include/mail_svg.php");?><a href="mailto:<?=$email?>" class="mail"><?=$email?></a></li>
                </ul>
              <? } ?>

            </div>
          </div>

          <div class="socials">
            <? if($vk){ ?>
              <a target="_blank" href="<?=$vk?>" class="vk"><?php include("include/vk_svg.php");?></a>
            <? } ?>
            <? if($fb){ ?>
              <a target="_blank" href="<?=$fb?>" class="fb"><?php include("include/fb_svg.php");?></a>
            <? } ?>
            <? if($insta){ ?>
              <a target="_blank" href="<?=$insta?>" class="in"><?php include("include/in_svg.php");?></a>
            <? } ?>
            <? if($tele){ ?>
              <a target="_blank" href="<?=$tele?>" class="tg"><?php include("include/tg_svg.php");?></a>
            <? } ?>
          </div>

        </div>
      <? } ?>

      <div class="spacer"></div>

    </div>

  </div>
</section>




</div>


<div id="scrollzipPoint" class="hidden"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
	strDays = '<?=GetMessage("DAYS");?>';
	strHours = '<?=GetMessage("HOURS");?>';
	strMins = '<?=GetMessage("MINUTES");?>';
	strSecs = '<?=GetMessage("SECONDS");?>';
</script>

<script src="/bitrix/themes/.default/<?=$MODULE_ID;?>/simple/js/scripts.js?<?php echo rand();?>"></script>




</body>
</html>