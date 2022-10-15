<?php
$arUrlRewrite=array (
  35 => 
  array (
    'CONDITION' => '#^/bitrix/services/yandex.market/trading/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/yandex.market/trading/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  32 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  36 => 
  array (
    'CONDITION' => '#^/services/uslugi-nashikh-partnerov/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services/uslugi-nashikh-partnerov/index.php',
    'SORT' => 100,
  ),
  33 => 
  array (
    'CONDITION' => '#^/brands/([^/]+?)/([^/]+?)/\\??(.*)#',
    'RULE' => 'UF_LINK=$1&UF_MODEL=$2&$3',
    'ID' => '',
    'PATH' => '/brands/model.php',
    'SORT' => 100,
  ),
  34 => 
  array (
    'CONDITION' => '#^/discount/([^/]+?)/\\??(.*)#',
    'RULE' => 'CODE=$1',
    'ID' => '',
    'PATH' => '/discount/detail.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  26 => 
  array (
    'CONDITION' => '#^/brands/([^/]+?)/\\??(.*)#',
    'RULE' => 'UF_LINK=$1&$2',
    'ID' => 'maxyss:hl_brand.detail',
    'PATH' => '/brands/detail.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/m/catalog/furniture/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/m/catalog/furniture/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/internet_shop/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/internet_shop/news/index.php',
    'SORT' => 100,
  ),
  37 => 
  array (
    'CONDITION' => '#^/services_centers1/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services_centers1/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/catalog/furniture/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/furniture/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/m/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/m/personal/order/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  31 => 
  array (
    'CONDITION' => '#^/services_centers/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services_centers/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/internet_shop2/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/internet_shop/index2.php',
    'SORT' => 100,
  ),
  40 => 
  array (
    'CONDITION' => '#^/internet_shop/#',
    'RULE' => '',
    'ID' => 'kolchuga:catalog',
    'PATH' => '/internet_shop/index.php',
    'SORT' => 100,
  ),
  28 => 
  array (
    'CONDITION' => '#^/services2/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services2/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/sobytiya/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/sobytiya/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  30 => 
  array (
    'CONDITION' => '#^/articles/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
  ),
  39 => 
  array (
    'CONDITION' => '#^/discount/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/discount/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/m/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/m/news/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/ajax/#',
    'RULE' => '',
    'ID' => 'kolchuga:catalog',
    'PATH' => '/ajax/index.php',
    'SORT' => 100,
  ),
  38 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/cat/#',
    'RULE' => '',
    'ID' => 'kolchuga:catalog',
    'PATH' => '/cat/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/api/#',
    'RULE' => '',
    'ID' => 'litebox:kassa',
    'PATH' => '/api/index.php',
    'SORT' => 100,
  ),
);
