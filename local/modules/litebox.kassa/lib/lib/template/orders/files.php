<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 07.04.2018
 * Time: 13:03
 */

namespace litebox\kassa\lib\Template\Orders;


use litebox\kassa\lib\Template\GenerateData;

class Files extends GenerateData
{
    /** @var int $productFileId Internal unique file ID */
    public $productFileId;
    /** @var int $maxDownloads Max allowed number of file downloads. See E-goods article in Ecwid Help center for the details */
    public $maxDownloads;
    /** @var int $remainingDownloads Remaining number of download attempts */
    public $remainingDownloads;
    /** @var string $expire Date/time of the customer download link expiration */
    public $expire;
    /** @var string $name File name */
    public $name;
    /** @var string $description File description defined by the store administrator */
    public $description;
    /** @var int $size File size, bytes (64-bit integer) */
    public $size;
    /** @var string $adminUrl Link to the file. Be careful: the link contains the API access token. Make sure you do not display the link as is in your application and not give it to a customer. */
    public $adminUrl;
    /** @var string $customerUrl File download link that is sent to the customer when the order is paid */
    public $customerUrl;

    public $rules = [
        'productFileId' => 'ID',
        'name' => 'FILE_NAME',
        'description' => 'DESCRIPTION',
        'size' => 'FILE_SIZE',
        'adminUrl' => 'SRC',
        'customerUrl' => 'SRC',
    ];
}