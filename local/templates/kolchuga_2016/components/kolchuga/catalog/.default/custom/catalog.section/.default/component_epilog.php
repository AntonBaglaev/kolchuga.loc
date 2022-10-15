<?
  if (!defined("B_PROLOG_INCLUDED") ||
      B_PROLOG_INCLUDED !== true)
  {
    die();
  }

  if (isset($arParams["GSetSectMetaProp"]) &&
      !empty($arParams["GSetSectMetaProp"]))
  {
    
    if (isset($GLOBALS[$arParams["GSetSectMetaProp"]]))
    {
      unset($GLOBALS[$arParams["GSetSectMetaProp"]]);
    }
    
    if (is_array($arResult[$arParams["GSetSectMetaProp"]]))
    {
      $GLOBALS[$arParams["GSetSectMetaProp"]] = $arResult[$arParams["GSetSectMetaProp"]];
    }
  }
?>