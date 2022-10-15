<?php

namespace Kolchuga;
use \Bitrix\Main\ModuleManager;
/**
 * Class Ozona
 * @package Kolchuga
 */
class Ozona
{
    private $options = [
        'API_URI' => 'https://api-seller.ozon.ru', 
		'CURL'=>[
			'URI'=>'',
			'METHOD'=>'POST',
			'PARAMS'=>[],
			'BODY'=>[],
			'KEY'=>'',
			'CID'=>'',
		],		
    ];
	function __construct($array=array())
    {
        $this->respons = ['resonse'=>'error','info'=>'']; 
		$this->requestArr = $array;		
    }
    public function getArray(){
        return $this->requestArr;
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
	
	private function toQuery($array){
		return http_build_query($array);
	}
	
	public function sendOzon($arParams=array()){
		if(empty($arParams)){return false;}
		
		$field_request=$this->options['CURL'];
		if(!empty($arParams['METHOD'])){$field_request['METHOD']=$arParams['METHOD'];}
		if(!empty($arParams['URI'])){$field_request['URI']=$arParams['URI'];}
		if(!empty($arParams['KEY'])){$field_request['KEY']=$arParams['KEY'];}
		if(!empty($arParams['CID'])){$field_request['CID']=$arParams['CID'];}
		if(!empty($arParams['PARAMS'])){$field_request['PARAMS']=$arParams['PARAMS'];}
		if(!empty($arParams['BODY'])){$field_request['BODY']=$arParams['BODY'];}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->options['API_URI'] . $field_request['URI'] . '?' . $this->toQuery($field_request['PARAMS']) );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $field_request['METHOD']);
		if(!empty($field_request['BODY'])){
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field_request['BODY'], JSON_UNESCAPED_UNICODE)	);
		}

		$headers = array();
		$headers[] = 'Authority: api-seller.ozon.ru';
		$headers[] = 'Pragma: no-cache';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Accept: application/json, text/plain, */*';
		$headers[] = 'Access-Control-Request-Method: GET';
		$headers[] = 'Content-Type: application/json;charset=utf-8';
		$headers[] = 'Api-Key: '.$field_request['KEY'];
		$headers[] = 'Client-Id: '.$field_request['CID'];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		//return $result;
		return json_decode($result, true);
	}
	
	public function getAttributeR($category_id=[0]){
		$arParams=[
			'URI'=>'/v3/category/attribute',		
			'BODY'=>[
				'attribute_type'=>"REQUIRED",
				"language"=> "DEFAULT",
				"category_id"=> $category_id,				
			]
		];
		$otvet=self::sendOzon($arParams);
		return $otvet;
    }
	
	public function getAttributeDictonaryValue($category_id=0,$attribute_id=0,$last_value_id=0,$limit=5000){
		$arParams=[
			'URI'=>'/v2/category/attribute/values',		
			'BODY'=>[
				"attribute_id"=> $attribute_id,
				"category_id"=> $category_id,
				"language"=> "DEFAULT",
				"last_value_id"=> $last_value_id,
				"limit"=> $limit			
			]
		];
		
		$otvet0=self::sendOzon($arParams);		
		$otvet=$otvet0;
		
		if($otvet0['has_next']=='1'){
			$fruit = array_pop($otvet0['result']);
			$plus=self::getAttributeDictonaryValue($category_id,$attribute_id,$fruit['id'],$limit);
			$otvet['result']=array_merge($otvet['result'],$plus['result']);
		}
		
		return $otvet;		
    }
	
	function sort_cat($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
	
	
	/*
	"result": [
        {
            "warehouse_id": 17427940973000,
            "name": "Кольчуга Люберцы",
            "is_rfbs": false
        }
    ]
	*/
	function getWareHouse(){
		$arParams=[
			'URI'=>'/v1/warehouse/list',		
			//'BODY'=>[]
		];
		
		$otvet=self::sendOzon($arParams);
		
		return $otvet;
	}
	
	
	
	
	function setWareHouseStock($offer_id,$product_id=0,$stock=0,$warehouse_id=0){
		$arParams=[
			'URI'=>'/v2/products/stocks',		
			'BODY'=>[
				"stocks"=> [
					[
						"offer_id"=> $offer_id,
						"product_id"=> intval($product_id),
						"stock"=> intval($stock),
						"warehouse_id"=> intval($warehouse_id),
					]
				]
			]
		];
		
		$otvet=self::sendOzon($arParams);
		
		return $otvet;
	}
	
	function isUfProductGroup($profuctId){
		global $USER_FIELD_MANAGER;
		\Bitrix\Main\Loader::includeModule('catalog');
		$arUserFields = $USER_FIELD_MANAGER->GetUserFields(\Bitrix\Catalog\ProductTable::getUfId(), $profuctId, LANGUAGE_ID);
		return intval($arUserFields['UF_PRODUCT_GROUP']['VALUE']);
	}
	
	public function setItemArhive($product_id=[]){
		if(empty($product_id)){return false;}
		$massiv=[];
		foreach($product_id as $item){
			$massiv[]=$item;
		}
		$arParams=[
			'URI'=>'/v1/product/archive',		
			'BODY'=>[
				"product_id"=> $massiv,						
			]
		];
		
		$otvet=self::sendOzon($arParams);		
				
		return $otvet;		
    }
	
	public function setItemFromArhive($product_id=[]){
		if(empty($product_id)){return false;}
		$massiv=[];
		foreach($product_id as $item){
			$massiv[]=$item;
		}
		$arParams=[
			'URI'=>'/v1/product/unarchive',		
			'BODY'=>[
				"product_id"=> $massiv,						
			]
		];
		
		$otvet=self::sendOzon($arParams);		
				
		return $otvet;		
    }
	
	/*
	* {
		"prices": [
			{
			"min_price": "800",
			"offer_id": "",
			"old_price": "0",
			"premium_price": "",
			"price": "1448",
			"product_id": 1386
			}
		]
	  }
	* 
	*/
	public function setNewPrice($massa=[]){
		if(empty($massa)){return false;}
		$massiv=[];
		foreach($massa as $item){
			$massiv[]=$item;
		}
		$arParams=[
			'URI'=>'/v1/product/import/prices',		
			'BODY'=>[
				"prices"=> $massiv,						
			]
		];
		//echo "<pre style='text-align:left;'>";print_r(json_encode($arParams));echo "</pre>";
		$otvet=self::sendOzon($arParams);		
				
		return $otvet;		
    }
}