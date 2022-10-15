<?
namespace PickPoint\DeliveryService\Bitrix;

use \Bitrix\Main\Localization\Loc;

/**
 * Class Tools
 * @package PickPoint\DeliveryService\Bitrix 
 */
class Tools
{
	protected static $MODULE_ID  = 'pickpoint.deliveryservice';
	protected static $MODULE_LBL = 'PICKPOINT_DELIVERYSERVICE_';
	
	/**
	 * Get CSS for module options 
	 */
	public static function getOptionsCss()
	{		
		echo '<style>         
			.'.self::$MODULE_LBL.'header {
				 font-size: 16px;
				 cursor: pointer;
				 display:block;
				 color:#2E569C;
			}
			 
			.'.self::$MODULE_LBL.'inst {
				display:none;
				margin-left:10px;
				margin-top: 10px;
				margin-bottom: 10px;
				color: #555;
			}
			
			.'.self::$MODULE_LBL.'smallHeader
			{
				cursor: pointer;
				display:block;
				color:#2E569C;
			}
			
			.'.self::$MODULE_LBL.'subFaq
			{
				margin-bottom:10px;
				margin-left:10px;
			}			

			.'.self::$MODULE_LBL.'warning{
                color:red !important;
            }
			
			.'.self::$MODULE_LBL.'border {
				border: 1px dotted black;
			}	

			.'.self::$MODULE_LBL.'borderBottom {
				border-bottom: 1px dotted black;
			}				
        </style>';
	}
	
	/**
	 * Return path to module option files
	 */
	public static function defaultOptionPath()
    {
        return "/bitrix/modules/".self::$MODULE_ID."/optionsInclude/";
    }
	
	/**
	 * Add FAQ block in module options
	 */
	public static function placeFAQ($code)
	{
		echo '<a class="'.self::$MODULE_LBL.'header" onclick="$(this).next().toggle(); return false;">'.Loc::getMessage(self::$MODULE_LBL.'FAQ_'.$code.'_TITLE').'</a>';
		echo '<div class="'.self::$MODULE_LBL.'inst">'.Loc::getMessage(self::$MODULE_LBL.'FAQ_'.$code.'_DESCR').'</div>';
	}	
}