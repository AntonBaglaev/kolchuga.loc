<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 13.04.2018
 * Time: 16:49
 */

namespace litebox\kassa\lib\Template\Profile;

class Profile
{
    /** @var \litebox\kassa\lib\Template\GeneralInfo $generalInfo Store basic data */
    public $generalInfo;
    /** @var \litebox\kassa\lib\Template\Profile\Account $account Store owner’s account data */
    public $account;
    /** @var \litebox\kassa\lib\Template\Products\Company $company Company info */
    public $company;
    /** @var \litebox\kassa\lib\Template\Profile\TaxSettings $taxSettings Store taxes settings */
    public $taxSettings;
}