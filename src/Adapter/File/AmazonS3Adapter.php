<?php

namespace Derby\Adapter\File;

use Derby\Adapter\CdnAdapterInterface;
use Gaufrette\Adapter\AwsS3;
use Aws\S3\S3Client;
USE Derby\Adapter\GaufretteAdapter;

class AmazonS3Adapter extends GaufretteAdapter implements CdnAdapterInterface
{

    /**
     * @var AwsS3
     */
    protected $adapter;

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
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_AMAZON_S3;
    }

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
        $this->adapter = new AwsS3($service, $bucket, $options, $detectContentType);

        parent::__construct($this->adapter);
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
