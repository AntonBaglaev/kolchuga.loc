<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("oldbrands");
?><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    #grid {
        display:grid;
        grid-template-columns: 50% 50%;}
    .inner-grid {
        display:grid;
        grid-template-columns: 1fr 1fr;}
    div>img {width:400px;}
    @media (min-width:320px) and (max-width:749px){
        #grid {
        display:grid;
        grid-template-columns: 1fr}
    .inner-grid {
        display:grid;
        grid-template-columns: 1fr}
    div>img {width:400px;}
    }
</style>
</head>
<body>
<div id="grid">
        <div class="inner-grid">
            <div align="center"><img src="/brands/images/1.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
<div class="inner-grid">
            <div align="center"><img src="/brands/images/2.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
</div>
<div id="grid">
        <div class="inner-grid">
            <div align="center"><img src="/brands/images/3.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
<div class="inner-grid">
            <div align="center"><img src="/brands/images/4.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
</div>
<div id="grid">
        <div class="inner-grid">
            <div align="center"><img src="/brands/images/1.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
<div class="inner-grid">
            <div align="center"><img src="/brands/images/2.jpg"/></div>
            <div><p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic...</p></div>
           </div>
</div>
</body>
</html><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>