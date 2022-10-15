<?php
namespace Roztech\Tools;

use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

/**
 * Class ItemStore
 * @package Roztech
 */
class ItemStore
{
	public $options = [
	    	
    ];
	
	function __construct($array=array())
    {
		Loader::includeModule('iblock');
        Loader::includeModule('catalog');
        		
        $this->respons = ['resonse'=>'error','info'=>'']; 
		$this->requestArr = $array;		
		$this->resultArr = [];		
    }
	
    public function getArray(){
        return $this->requestArr;
    }
	
	public function getResult(){
        return $this->resultArr;
    }
	
	public function getOption(){
        return $this->options;
    }
	public function setOption($array){
		if(empty($array)){return false;}
		if(!is_array($array)){
			$this->options[]=$array;
		}else{
			foreach($array as $key=>$val){
				$this->options[$key]=$val;
			}
		}        
    }
	
	public function getStoreList(){
		$iblock_store=$this->options['STORE_IBLOCK_ID'];
		if(empty($iblock_store)){$this->respons['info']='STORE_IBLOCK_ID is empty'; return $this->respons;}
		$res = \CIBlockElement::GetList(
			array('id' => 'asc'),
			array('IBLOCK_ID' => $iblock_store),
			false,
			false,
			array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_stores','PROPERTY_show_in_list')
		);

		while($store = $res->Fetch()){		
			$this->resultArr['STORE_LIST_ALL'][] = $store;
		}		
	}
	
	public function getStorebyProduct($PRODUCT_ID=0){
		if(intval($PRODUCT_ID)<1){$this->respons['info']='PRODUCT_ID is empty'; return $this->respons;}
		if(empty($this->resultArr['STORE_LIST_ALL'])){$this->respons['info']='STORE_LIST_ALL is empty'; return $this->respons;}
		
		$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
			'filter' => array('=PRODUCT_ID'=>$PRODUCT_ID,'STORE.ACTIVE'=>'Y','>=AMOUNT'=>1),
			'select' => array('AMOUNT','STORE_ID','STORE_TITLE' => 'STORE.TITLE','STORE_XML_ID' => 'STORE.XML_ID'),
		));
		while($arStoreProduct=$rsStoreProduct->fetch())
		{
			foreach($this->resultArr['STORE_LIST_ALL'] as $kl=>$ckld){								
				if(in_array($arStoreProduct['STORE_XML_ID'],$ckld['PROPERTY_STORES_VALUE'] )){					
					$this->resultArr['STORE_BY_PRODUCT'][$PRODUCT_ID][]=['ID'=>$ckld['ID'], 'NAME'=>$ckld['NAME'], 'ALL'=>$arStoreProduct];					
				}		
			}
		}
		
	}
	
}