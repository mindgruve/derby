<?php

namespace Derby\Adapter\File;

use Derby\Adapter\CdnAdapterInterface;
use Derby\Adapter\RemoteFileAdapter;
use Gaufrette\Adapter\AwsS3;
use Aws\S3\S3Client;

class AmazonS3Adapter extends RemoteFileAdapter implements CdnAdapterInterface
{
    /**
     * @var S3Client
     */
    protected $service;

    /**
     * @var string
     */
    protected $bucket;

    const ADAPTER_AMAZON_S3 = 'ADAPTER\FILE\AMAZON_S3';

    /**
     * @param S3Client $service
     * @param $bucket
     * @param array $options
     * @param bool $detectContentType
     */
    function __construct(S3Client $service, $bucket, array $options = array(), $detectContentType = false)
    {
        $this->service = $service;
        $this->bucket  = $bucket;
        $this->gaufretteAdapter = new AwsS3($service, $bucket, $options, $detectContentType);

        parent::__construct($this->gaufretteAdapter);
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_AMAZON_S3;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getUrl($key)
    {
        $this->service->getObjectUrl($this->bucket, $key);
    }
}
