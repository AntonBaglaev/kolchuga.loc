<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="modalMenu">
	<div class="menuBackground">
		<div class="menuWrapper">
			<div class="menuHeader">
				<div class="closeMenu">
					<span class="closeText"><?=GetMessage("CLOSE_MENU");?></span>
					<span class="materialIcons cross">&#xE5CD;</span>
				</div>
			</div>
			<div class="menuMiddle">
				<nav>
					<?php
					if (!empty($arResult))
					{
						$moreMenu = array();
						foreach ($arResult as $arItem)
						{
							if($arItem["PERMISSION"] <= "D")
								$arItem["LINK"] = "#";

							if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel)
								echo str_repeat("</ul></li></ul>", ($previousLevel - $arItem["DEPTH_LEVEL"]));

							if ($arItem["DEPTH_LEVEL"] && $arItem["IS_PARENT"])
								echo "<!----><ul>";
							else if($arItem["DEPTH_LEVEL"] == 1 && !$arItem["IS_PARENT"])
							{
								$moreMenu[] = $arItem;
								continue;
							}

							if ($arItem["IS_PARENT"])
							{
								?>
								<li>
									<a href="<?=$arItem["LINK"];?>" class="<?echo ($arItem["SELECTED"] ? "root-item-selected" : "");?>" <?echo ($arItem["PERMISSION"] > "D" ? "" : "title='".GetMessage("MENU_ITEM_ACCESS_DENIED")."'");?>>
										<?=$arItem["TEXT"];?>
									</a>
									<ul class="root-item">
								<?
							}
							else
							{
							?>
								<li>
									<a href="<?=$arItem["LINK"];?>" class="<?echo ($arItem["SELECTED"] ? "item-selected" : "");?>" <?echo ($arItem["PERMISSION"] > "D" ? "" : "title='".GetMessage("MENU_ITEM_ACCESS_DENIED")."'");?>>
										<?=$arItem["TEXT"];?>
									</a>
								</li>
							<?
							}
								$previousLevel = $arItem["DEPTH_LEVEL"];
						}

						if ($previousLevel > 1)
							echo str_repeat("<!----></ul></li>", ($previousLevel - 1) );

						if(!empty($moreMenu))
						{
						?><!--
						 --><ul class="menuMore">
								<?
								foreach ($moreMenu as $menu)
								{
									if($menu["PERMISSION"] <= "D")
										$menu["LINK"] = "#";

									if ($menu["SELECTED"])
									{
										?>
											<li class="menuMoreItem selected">
												<a href="<?=$menu["LINK"];?>"><?=$menu["TEXT"];?></a>
											</li>
										<?
									}
									else
									{
										?>
											<li class="menuMoreItem">
												<a href="<?=$menu["LINK"];?>"><?=$menu["TEXT"];?></a>
											</li>
										<?
									}
								}
								?>
							</ul>
					  <?}?>
						<ul class="menuTopInfo">
							<div>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include", "", 
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include_areas/contact/address.php",
									)
								);?>
							</div>
							<div>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include", "", 
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include_areas/contact/phone.php",
									)
								);?>
							</div>
							<div>
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include", "", 
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include_areas/contact/emailTopMenu.php",
									)
								);?>
							</div>
						</ul>
				  <?}?>
				</nav>
			</div>
		</div>
	</div>
</div>