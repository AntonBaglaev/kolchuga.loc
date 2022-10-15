<?php

namespace Kolchuga;

/**
 * Class Analytics
 * @package Kolchuga
 */
class Analytics {

	public static function includeYandexMetrika()
	{
		echo <<<HTML
<!-- Yandex.Metrika counter -->
<script type="text/javascript" data-skip-moving="true">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(36451865, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/36451865" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
HTML;
	}

	public static function includeGoogleAnalytics()
	{
		echo <<<HTML
<!-- Global site tag (gtag.js) - Google Analytics -->
	<script data-skip-moving="true" async src="https://www.googletagmanager.com/gtag/js?id=UA-177109637-1"></script>
	<script data-skip-moving="true">
	 window.dataLayer = window.dataLayer || [];
	 function gtag(){dataLayer.push(arguments);}
	 gtag('js', new Date());

	 gtag('config', 'UA-177109637-1');
	</script>
<!-- /Global site tag (gtag.js) - Google Analytics -->
HTML;
	}
	
	public static function includeGoogleTag()
	{
		echo <<<HTML
<!-- Google Tag Manager -->
		<script data-skip-moving="true">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-TTM58DK');</script>
    <!-- End Google Tag Manager -->
HTML;
	}	
	public static function includeGoogleTagNo()
	{
		echo <<<HTML
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTM58DK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
HTML;
	}
	
	public static function includeFacebookPixel()
	{
		echo <<<HTML
<!-- Facebook Pixel Code -->

<!-- End Facebook Pixel Code -->
HTML;
	}

}