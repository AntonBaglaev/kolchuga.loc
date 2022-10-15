<?php
namespace Starrys\Cashbox\Api;

class ProductList {
	private $items = array();
	private $resultTotal = 0;
	private $currentSum = 0;

	public function __construct($total = 0.0) {
		$this->resultTotal = intval(round($total * 100));
	}

	public function addItem($name, $price, $taxId, $quantity = 1.0, $payAttr = PayAttribute::FULL_PAYMENT) {
		if($price == 0 ) return;
		$this->items[] = array(
						"Qty"			=> intval(round($quantity * 1000)),
						"Price"			=> intval(round($price * 100)),
						"PayAttribute"	=> $payAttr,
						"TaxId"			=> intval($taxId),
						"Description"	=> $name
				);
		$this->currentSum += intval(round($price * 100 * $quantity));
	}

	private function normalize() {
		if ($this->resultTotal != 0 && $this->resultTotal != $this->currentSum) {
			$coefficient = $this->resultTotal / $this->currentSum;
			$realAmount = 0;
			$aloneId = null;
			foreach ($this->items as $index => &$item) {
				$item['Price'] = intval(round($coefficient * $item['Price']));
				$item['Subtotal'] = intval(round($item['Price']*$item['Qty']/1000));
				$realAmount += $item['Subtotal'];
				if ($aloneId === null && $item['Qty'] === 1000) {
					$aloneId = $index;
				}

			}
			unset($item);
			if ($aloneId === null) {
				foreach ($this->items as $index => $item) {
					if ($aloneId === null && $item['Qty'] > 1000) {
						$aloneId = $index;
						break;
					}
				}
			}
			if ($aloneId === null) {
				$aloneId = 0;
			}

			$diff = $this->resultTotal - $realAmount;

			if (abs($diff) >= 0.001) {
				if ($this->items[$aloneId]['Qty'] === 1000) {
					$this->items[$aloneId]['Price'] = intval(round($this->items[$aloneId]['Price']+$diff));
					$this->items[$aloneId]['Subtotal'] = $this->items[$aloneId]['Price'];
				} elseif (count($this->items) == 1){
					$this->items[$aloneId]['Subtotal'] = $this->resultTotal;
				} elseif ($this->items[$aloneId]['Qty'] > 1000) {
					$tmpItem = $this->items[$aloneId];
					$item = array(
							"Qty"			=> 1000,
							"Price"			=> intval(round($tmpItem['Price'] + $diff)),
							"PayAttribute"	=> $tmpItem['PayAttribute'],
							"TaxId"			=> $tmpItem['TaxId'],
							"Description"	=> $tmpItem['Description']
					);
					$this->items[$aloneId]['Qty'] -= 1000;
					$this->items[$aloneId]['Subtotal']  -= $tmpItem['Price'];
					array_splice($this->items, $aloneId + 1, 0, array($item));
				} else {
					$this->items[$aloneId]['Subtotal'] = intval($this->resultTotal - ($realAmount - round($this->items[$aloneId]['Price']*$this->items[$aloneId]['Qty']/1000)));
					$this->items[$aloneId]['Price'] = intval(round($this->items[$aloneId]['Price'] + $diff/($this->items[$aloneId]['Qty']/1000)));


				}
			}
		}
	}

	public function getItems() {
		$this->normalize();
		return $this->items;
	}
}
