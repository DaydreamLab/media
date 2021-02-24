<?php

namespace DaydreamLab\Media\Traits\Service;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

trait AzureBlob
{
    public function getAzureConnectionString()
    {
        $accountKey = config('daydreamlab.media.file.azure.accountkey');
        $accountName = config('daydreamlab.media.file.azure.accountname');

        return "DefaultEndpointsProtocol=https;AccountName={$accountName};AccountKey={$accountKey}";
    }


    public function getAzureClient()
    {
        return  BlobRestProxy::createBlobService($this->getAzureConnectionString());
    }
}