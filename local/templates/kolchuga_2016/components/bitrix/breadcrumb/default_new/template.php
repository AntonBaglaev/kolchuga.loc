<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";


	foreach($arResult as $key=>$ar){
		if($key==1 && ($ar["LINK"]=='/news/'|| $ar["LINK"]=='/sobytiya/')){
			$arResult_new[]=Array( 'TITLE' => 'Блог', 'LINK' => '/blog/' );
		}
		$arResult_new[]=$ar;
	}

	$arResult=$arResult_new;
	unset($arResult_new);

$strReturn = '';

$strReturn .= '<div class="container-fluid new_bread d-none d-md-block"><div class="row"><div class="col-1 bgbread">&nbsp;</div><div class="col-10">';



//$strReturn .= '<ul class="breadcrumb">';
$strReturn .= '<ul>';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<li class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"'.$child.$nextRef.'>
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					<span itemprop="title">'.$title.'</span>
				</a>
			</li><li>> </li>';
	}
	else
	{
		$strReturn .= '
			<li>
				<span>'.$title.'</span>
			</li>';
	}
}

$strReturn .= '</ul></div></div></div>';

return $strReturn;
