<?php

namespace DaydreamLab\Media\Traits\Service;

use DaydreamLab\JJAJ\Helpers\Helper;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

trait AzureBlob
{
    protected $azureAccountName;

    protected $azureAccountKey;

    protected $azureContainer;

    protected $baseUrl;


    public function azureInit()
    {
        $this->azureAccountName = config('daydreamlab.media.file.azure.accountname');
        $this->azureAccountKey = config('daydreamlab.media.file.azure.accountkey');
        $this->azureContainer = config('daydreamlab.media.file.azure.container');
        $this->baseUrl = "https://{$this->azureAccountName}.blob.core.windows.net/{$this->azureContainer}/";
    }

    public function getAzureConnectionString()
    {
        return "DefaultEndpointsProtocol=https;AccountName={$this->azureAccountName};AccountKey={$this->azureAccountKey}";
    }


    public function getAzureClient()
    {
        $this->azureInit();

        return BlobRestProxy::createBlobService($this->getAzureConnectionString());
    }
}