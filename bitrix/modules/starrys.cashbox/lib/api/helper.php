<?php
namespace Starrys\Cashbox\Api;

class Helper {

	/**
	 * Return Command AddLineToDocument
	 * @param array $product [title,price,quantity]
	 * @param int $taxId (table 29)
	 * @param int $documentType (table 10)
	 * @param int $payAttribute (table 7)
	 * @param array $preText array of strings before product line
	 * @param array $afterText array of strings after product line
	 * @return array of Commands
	 */
	public static function makeProductCommands($product, $taxId = TaxId::VAT_18, $documentType = DocumentType::DEBIT, $payAttribute = PayAttribute::FULL_PAYMENT, $preText = array(), $postText = array()) {
		$commands = array();
		$commands[] = new Command("AddLineToDocument", array(
				"PayAttribute"	=> $payAttribute,
				"Description"	=> $product['name'],
				"Price"			=> round($product['price'] * 100),
				"TaxId"			=> intval($taxId),
				"Qty"			=> round($product['quantity'] * 1000),
				"DocumentType"	=> $documentType
			));
		foreach($preText as $text) {
			$commands[] = new Command("AddPreText", array('Value' => $text));
		}
		foreach($postText as $text) {
			$commands[] = new Command("AddPostText", array('Value' => $text));
		}
		return $commands;
	}

	/**
	 * Return array of Commands to batchExec for print check
	 * @param array $products AddLineToCodument Commands
	 * @param array of float $noncash [card, ecash, other] in ruble
	 * @param strint $contact email or phone
	 * @param int $taxMode Tax Mode (table 9)
	 * @param float $cash cash sum in ruble
	 * @return array of Commands
	 */
	public static function makePrintCheckCommands($products, $noncash = array(), $contact = '', $taxMode = 0, $cash = 0, $secTurnOpen = 86000, $docInTurn = 20) {
		$closeTurnCommand = new Command("CloseTurn");
		$closeTurnCommand->setOptions(array(Command::SKIP_WHEN_TRUE => "(or (= device-mode DM-TURN-CLOSE) (not (or (> sec-since-turn-open $secTurnOpen) (>= docs-in-turn $docInTurn))))"));

		$openTurnCommand = new Command("OpenTurn");
		$openTurnCommand->setOptions(array(
				Command::SKIP_WHEN_MODE_NOT_IN =>
					array(
						DeviceStatus::AFTER_START,
						DeviceStatus::CLOSE_TURN
					)
				));

		$cancelDocumentCommand = new Command('CancelDocument');
		$cancelDocumentCommand->setOptions(array(
				Command::SKIP_WHEN_MODE_NOT_IN =>
					array(
						DeviceStatus::DOCUMENT_OPEN_DEBIT,
						DeviceStatus::DOCUMENT_OPEN_CREDIT,
						DeviceStatus::DOCUMENT_OPEN_REFUND_DEBIT,
						DeviceStatus::DOCUMENT_OPEN_REFUND_CREDIT,
					)
				));

		$commands = array(
				new Command("NoOperation"),
				$closeTurnCommand,
				$openTurnCommand,
				$cancelDocumentCommand
			);

		foreach($products as $product) {
			$commands[] = $product;
		}

		$commands[] = new Command("AddPhoneOrEmailOfCustomer", array("Value" => $contact));
		if(isset($noncash[NonCashType::CARD])) {
			$noncash[NonCashType::CARD] = round($noncash[NonCashType::CARD] * 100);
		} else {
			$noncash[NonCashType::CARD] = 0;
		}

		if(isset($noncash[NonCashType::ECASH])) {
			$noncash[NonCashType::ECASH] = round($noncash[NonCashType::ECASH] * 100);
		} else {
			$noncash[NonCashType::ECASH] = 0;
		}

		if(isset($noncash[NonCashType::OTHER])) {
			$noncash[NonCashType::OTHER] = round($noncash[NonCashType::OTHER] * 100);
		} else {
			$noncash[NonCashType::OTHER] = 0;
		}
		$commands[] = new Command("CloseDocument", array(
					"TaxMode"	=> pow(2, intval($taxMode)),
					"Cash"		=> round($cash*100),
					"NonCash"	=> $noncash
				));

		return $commands;
	}


}