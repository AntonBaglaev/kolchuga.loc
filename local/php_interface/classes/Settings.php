<?php

namespace Kolchuga;

/**
 * Class Settings
 * @package Kolchuga
 */
class Settings
{
    public static $catalog_iblock = 40; // id инфоблока каталога
    public static $ps_section = 18130; // id раздела подарочных сертификатов
	
	private static $options = [
        'catalog_iblock_id' => 40,        
    ];

    public static function get($option)
    {
        return self::$options[$option];
    }
	
	public function ardt($massiv){
	
		$result=[];
		foreach($massiv['#'] as $key=>$value){
			if(empty($value[1])){
				if(!is_array($value[0]['#'])){
					$result[$key]=$value[0]['#'];
				}else{
					$result[$key]=self::ardt($value[0]);
				}
			}else{
				foreach($value as $key2=>$item){
					if(is_array($item['#'])){
						$result[$key][$key2]=self::ardt($item);
					}else{
						$result[$key][$key2]=$item['#'];
					}
				}
			}
			
		}
		
		return $result;
	}
	public function xmp($message, $user = 0, $title = false, $access = false, $color = '#008B8B')
    {
        if (intval($user) > 0) {
            global $USER;
            if (!is_object($USER)) {
                $USER = new CUser();
            }
            if ($USER->GetID() != $user) return;
        }

        ?>
		<!-- TODO: DEBUG_PRE  -->
        <div style="<?=(!$access ? 'display:none;':'')?>">
			<table border="0" cellpadding="5" cellspacing="0" style="border:1px solid <?= $color ?>;margin:2px;">
				<tr>
					<td style="padding:5px;">
						<?
						//debug_print_backtrace();

						if (strlen($title) > 0) {
							echo '<p style="color:' . $color . ';font-size:11px;font-family:Verdana;">[' . $title . ']</p>';
						}

						if (is_array($message) || is_object($message)) {
							echo '<pre style="color:' . $color . ';font-size:11px;font-family:Verdana;">';
							print_r($message);
							echo '</pre>';
						} else {
							echo '<p style="color:' . $color . ';font-size:11px;font-family:Verdana;">' . var_dump($message) . '</p>';
						}

						?></td>
				</tr>
			</table>
		</div>
		<!-- END -->
        <?
    }
}