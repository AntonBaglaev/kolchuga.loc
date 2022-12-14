<?php

namespace Yandex\Market\Ui\Reference;

use Yandex\Market;
use Bitrix\Main;

abstract class Form extends Page
{
	public function hasRequest()
	{
		return $this->request->isPost();
	}

	abstract public function processRequest();

	protected function showFormProlog()
	{
		$postUrl = $this->request->getRequestUri();

		echo '<form method="post" action="' . htmlspecialcharsbx($postUrl) . '" enctype="multipart/form-data">';
		echo bitrix_sessid_post();
	}

	protected function showFormEpilog()
	{
		echo '</form>';
	}
}