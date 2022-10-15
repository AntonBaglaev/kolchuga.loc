<?php

namespace Yandex\Market\Export\Xml\Format\BeruRu;

use Yandex\Market\Export\Xml;
use Yandex\Market\Type;

class VendorModel extends Xml\Format\YandexMarket\VendorModel
{
	public function getOffer()
	{
		$tag = parent::getOffer();

		$this->overrideTags($tag->getChildren(), [
			'picture' => [ 'required' => false ],
			'model' => [ 'name' => 'name' ],
			'country_of_origin' => [ 'visible' => true ],
			'expiry' => [ 'visible' => true ],
			'dimensions' => [ 'visible' => true ],
			'weight' => [ 'visible' => true ],
		]);

		$tag->addChild(new Xml\Tag\Vat(), 'enable_auto_discounts');
		$tag->addChild(new Xml\Tag\Base(['name' => 'manufacturer', 'visible' => true]), 'manufacturer_warranty');

		$tag->addChildren([
			new Xml\Tag\ShopSku(['required' => true]),
			new Xml\Tag\Base(['name' => 'market-sku']),
			new Xml\Tag\Disabled(),
			new Xml\Tag\Count(),
		]);

		$this->removeChildTags($tag, ['condition', 'credit-template', 'purchase_price']);

		return $tag;
	}
}