<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 13.04.2018
 * Time: 16:39
 */

namespace litebox\kassa\lib\Api\Methods\v1;


use litebox\kassa\lib\Template\GeneralInfo;
use litebox\kassa\lib\Template\Profile\Account;
use litebox\kassa\lib\Template\Products\Company;
use litebox\kassa\lib\Template\Profile\Taxes;
use litebox\kassa\lib\Template\Profile\TaxSettings;

class Profile extends Base
{
    public function executeGET()
    {
        $profile = new \litebox\kassa\lib\Template\Profile\Profile();

        $general = [
            'url' => $this->getBaseUrl()
        ];

        $profile->generalInfo = new GeneralInfo($general);

        $user = \CUser::GetByID(1)->Fetch();

        $profile->account = new Account($user);

        $profile->company = new Company([]);

        $profile->taxSettings = new TaxSettings();

        $taxDb = \CSaleTaxRate::GetList();

        while($taxRes = $taxDb->Fetch()) {
            $profile->taxSettings->taxes[] = new Taxes($taxRes);
            $profile->taxes[] = new Taxes($taxRes);
        }

        return $profile;
    }

    public function executePOST()
    {
        $data = json_decode(file_get_contents('php://input'));

        $name = $data->company->companyName;

        if ($name) {
            \COption::SetOptionString("main","site_name",$name);
        }

        return [];
    }
}