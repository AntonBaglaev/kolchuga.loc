<?php
namespace Starrys\Cashbox\Api;

class Command {
	const CONTINUE_WHEN_TRANSPORT_ERROR = "ContinueWhenTransportError";
	const CONTINUE_WHEN_DEVICE_ERROR = "ContinueWhenDeviceError";

	const SKIP_WHEN_TRUE = "SkipWhenTrue";
	const STOP_WHEN_TRUE = "StopWhenTrue";
	const SKIP_WHEN_MODE_IN = "SkipWhenModeIn";
	const SKIP_WHEN_MODE_NOT_IN ="SkipWhenModeNotIn";
	const STOP_WHEN_MODE_IN ="StopWhenModeIn";
	const STOP_WHEN_MODE_NOT_IN = "StopWhenModeNotIn";
	const SKIP_WHEN_DOCS_IN_TURN_LESS_THEN ="SkipWhenDocsInTurnLessThen";
	const SKIP_WHEN_DOCS_IN_TURN_GREAT_OR_EQUAL_THEN = "SkipWhenDocsInTurnGreatOrEqualThen";
	const STOP_WHEN_DOCS_IN_TURN_LESS_THEN = "StopWhenDocsInTurnLessThen";
	const STOP_WHEN_DOCS_IN_TURN_GREAT_OR_EQUAL_THEN = "StopWhenDocsInTurnGreatOrEqualThen";



	private $name;
	private $params;
	private $options = array();

	public function __construct($commandName, $commandParams = array()) {
		$this->name = $commandName;
		$this->params = $commandParams;
	}

	public function getName() {
		return $this->name;
	}

	public function getParams() {
		return $this->params;
	}

	public function setOptions($options) {
		$this->options = $options;
	}

	public function getOptions() {
		return $this->options;
	}

}