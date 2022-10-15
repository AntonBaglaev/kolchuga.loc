<?php
namespace Starrys\Cashbox\Api;

class Client {
	const PATH = '/fr/api/v2/';

	const STRATEGY_QUEUE_LEN = "QueueLen";
	const STRATEGY_DURATION = "Duration";
	const STRATEGY_QUEUE_LENS = "QueueLens";
	const STRATEGY_DURATIONS = "Durations";


	private $server = '';
	private $lastError = '';
	private $timeout = 60;
	private $certPath = '';
	private $keyPath ='';
	private $certPassword = '';
	private $group = '';
	private $device = 'auto';
	private $strategy = array();
	private $cashierPassword = '';
	private $adminPassword = '';
	private $tryCount = 0;
	private $waitForFree = 0;
	private $ignoreActivity = false;
	private $clientId = '';
	private $data = array();
	private $cmsName = '';
	private $cmsVersion = '';
	private $fullResponse = false;

	public function __construct($server, $group = '', $device = 'auto') {
		$this->server = trim($server, " \t\n\r\0\x0B/");
		$this->group = trim($group);
		if($device) {
			$this->device = trim($device);
		} else {
			$this->device = "auto";
		}
	}

	public function setStrategy($strategy = array()) {
		$this->strategy = $strategy;
		return $this;
	}

	public function setPasswords($cashier, $admin = '') {
		$this->cashierPassword = intval($cashier);
		$this->adminPassword = intval($admin);
		return $this;
	}

	public function setCmsId($name, $version){
		$this->cmsName = trim($name);
		$this->cmsVersion = trim($version);
		return $this;
	}

	public function setTryCount($count) {
		$this->tryCount = $count;
		return $this;
	}

	public function setWaitForFree($seconds) {
		$this->waitForFree = $seconds;
		return $this;
	}

	public function setIgnoreActivity($bool) {
		$this->ignoreActivity = (bool)$bool;
		return $this;
	}

	public function setClientId($clientId) {
		$this->clientId = trim($clientId);
		return $this;
	}

	public function setFullResponse($bool) {
		$this->fullResponse = (bool)$bool;
		return $this;
	}

	private function getPassword($command) {
		if (in_array($command, array('CloseTurn', 'IntermediateTurnReport'))) {
			return $this->adminPassword;
		} else {
			return $this->cashierPassword;
		}
	}


	public function exec($command ) {
		$commandName = $command->getName();
		$params = array(
			'RequestId'		=> time().uniqid(),
			'Group'			=> $this->group,
			'Device'		=> $this->device,
			'Password'		=> $this->getPassword($commandName),
			'IgnoreActivity'=> $this->ignoreActivity,
		);

		if ($this->tryCount) {
			$params['TryCount'] = intval($this->tryCount);
		}

		if ($this->waitForFree) {
			$params['WaitForFree'] = intval($this->waitForFree);
		}


		if ($this->clientId) {
			$params['ClientId'] = $this->clientId;
		}

		if ($this->fullResponse) {
			$params['FullResponse'] = true;
		}

		$data = array_merge($params, $command->getParams());
		if($this->device == 'auto') {
			$data = array_merge($data, $this->strategy);
		}
		return $this->sendRequest($commandName, $data);
	}

	public function batchExec($commands, $requestId = false) {
		$data = array(
			'RequestId'		=> $requestId?strval($requestId):time().uniqid(),
			'Group'			=> $this->group,
			'Device'		=> $this->device,
			'IgnoreActivity'=> $this->ignoreActivity,
		);

		//TODO отрефакторить в доп массив опций и мержить с параметрами
		if($this->tryCount) {
			$data['TryCount'] = intval($this->tryCount);
		}
		if($this->waitForFree) {
			$data['WaitForFree'] = intval($this->waitForFree);
		}
		if($this->clientId) {
			$data['ClientId'] = $this->clientId;
		}

		if($this->device == 'auto') {
			$data = array_merge($data, $this->strategy);
			if(empty($this->strategy)) {
				$data[self::STRATEGY_QUEUE_LEN] = 100;
			}
		}
		foreach($commands as $command) {
			$commandName = $command->getName();
			$commandParams = array(
					"Path"		=> self::PATH.$commandName,
					"Request"	=> array_merge(array('Password' => $this->getPassword($commandName)), $command->getParams())
			);
			$commandParams = array_merge($commandParams, $command->getOptions());
			$data['Requests'][] = $commandParams;
		}
		return $this->sendRequest('Batch', $data);
	}



	public function getLastError(){
		return $this->lastError;
	}

	public function setTimeout($sec) {
		$this->timeout = $sec;
	}

	public function setCertificate($cert, $key, $certPassword) {
		if(strpos($cert, '-----END CERTIFICATE-----')) {
			$this->tempCrtFile = tmpfile();
			fwrite($this->tempCrtFile, trim($cert));
			$tempCrtPath = stream_get_meta_data($this->tempCrtFile);
			$this->certPath = $tempCrtPath['uri'];
		} else {
			$this->certPath = trim($cert);
		}
		if(
			strpos($key, '-----END PRIVATE KEY-----')
		||
			strpos($key, '-----END RSA PRIVATE KEY-----')
		) {
			$this->tempPemFile = tmpfile();
			fwrite($this->tempPemFile, trim($key));
			$tempPemPath = stream_get_meta_data($this->tempPemFile);
			$this->keyPath = $tempPemPath['uri'];
		} else {
			$this->keyPath = trim($key);
		}
		$this->certPassword = trim($certPassword);
	}

	public function sendRequest($command, $data) {
		$this->data = $data;
		$data = json_encode($data);
		$ch = curl_init();
		$customHeaders = array("Content-Type: application/json", "Expect:");
		if($this->cmsName) {
			$customHeaders[] = "XComepayPointID: {$this->cmsName} {$this->cmsVersion}";
		}
		$options = array(
			CURLOPT_CONNECTTIMEOUT	=> $this->timeout,
			CURLOPT_HEADER			=> true,
			CURLOPT_HTTPHEADER		=> $customHeaders,
			CURLOPT_POST			=> true,
			CURLOPT_POSTFIELDS		=> $data,
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_URL				=> $this->server.self::PATH.$command,
		);
		if($this->certPath) {
			$options[CURLOPT_SSLCERT] = $this->certPath;
			$options[CURLOPT_SSLKEY] = $this->keyPath;
			$options[CURLOPT_SSLCERTPASSWD] = $this->certPassword;
		}
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->lastError = curl_error($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

		$headers = substr($response, 0, $header_size);
		$headers = explode("\r\n",$headers);
		$result = array();
		foreach($headers as $line){
			if(!strpos($line, ":")) continue;
			list($name, $value) = explode(":", $line);
			$result[trim($name)] = trim($value);
		}
		$headers = $result;
		$response = substr($response, $header_size);


		curl_close($ch);
		$result = false;
		$error = false;
		if ($code == 200 && $response) {
			$result = json_decode($response);
			$error = false;
		} else {
			if ($code == 500 && $response) {
				$error = json_decode($response);

				if(!$error) {
					$error = $response.$this->lastError;
				} else {
					$this->lastError = $error->ErrorDescription;
					$error = isset($error->Response)?implode(",", $error->Response->ErrorMessages):$error->ErrorDescription;
				}

			} elseif($code == 400) {
				$error = $response;
			} else {
				$error = $this->lastError;
			}
		}
		$result = array(
			'code'		=> $code,
			'cache'		=> (isset($headers['X-From-Cache']) || isset($headers['X-From-FCE-Cache']))?true:false,
			'response'	=> $result,
			'error'		=> $error,
			'fullresponse'	=> $response
		);
		return (object)$result;
	}

	public function __toString(){
		return var_export($this->data,true);
	}
}