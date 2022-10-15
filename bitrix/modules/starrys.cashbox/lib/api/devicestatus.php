<?php
namespace Starrys\Cashbox\Api;

class DeviceStatus {
	const AFTER_START = 0;
	const OPEN_TURN = 2;
	const OPEN_GREAT_24 = 3;
	const CLOSE_TURN = 4;
	const WAITING_DATE_APROUVE = 6;
	const DOCUMENT_OPEN_DEBIT = 8;
	const DOCUMENT_OPEN_CREDIT = 24;
	const DOCUMENT_OPEN_REFUND_DEBIT = 40;
	const DOCUMENT_OPEN_REFUND_CREDIT = 56;
	const FATAL_ERROR = 255;
}