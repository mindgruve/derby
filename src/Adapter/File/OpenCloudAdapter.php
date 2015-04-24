<?php

namespace Derby\Adapter\File;

use Derby\Adapter\CdnAdapterInterface;
use Derby\Adapter\RemoteFileAdapter;
use OpenCloud\ObjectStore\Service;
use OpenCloud\ObjectStore\Exception\ObjectNotFoundException;
use Derby\Adapter\AbstractGaufretteAdapter;

class OpenCloudAdapter extends RemoteFileAdapter implements CdnAdapterInterface
{

    const ADAPTER_OPEN_CLOUD = 'ADAPTER\FILE\OPEN_CLOUD';

    /**
     * @var Service
     */
    protected $service;

    function __construct(Service $objectStore, $containerName, $createContainer = false)
    {
        $this->service = $objectStore;
    }


    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_OPEN_CLOUD;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getUrl($key)
    {
        if ($object = $this->tryGetObject($key)) {
            return $object->getUrl();
        }

        return false;
    }

    /**
     * @param string $key
     *
     * @return \OpenCloud\ObjectStore\Resource\DataObject|false
     */
    protected function tryGetObject($key)
    {
        try {
            return $this->service->getContainer()->getObject($key);
        }
        catch (ObjectNotFoundException $objFetchError) {
            return false;
        }
    }
}
