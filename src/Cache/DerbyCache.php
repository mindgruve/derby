<?php

namespace Derby\Cache;

use Doctrine\Common\Cache\CacheProvider;

class DerbyCache
{
    /**
     * @var CacheProvider
     */
    protected $cacheProvider;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @param CacheProvider $cacheProvider
     * @param $ttl
     */
    public function __construct(CacheProvider $cacheProvider, $ttl)
    {
        $this->cacheProvider = $cacheProvider;
        $this->ttl = $ttl;
    }

    /**
     * @param $namespace
     * @param $id
     * @return false|mixed
     */
    public function fetch($namespace, $id)
    {
        $this->cacheProvider->setNamespace($namespace);

        return $this->cacheProvider->fetch($id);
    }

    /**
     * @param $namespace
     * @param $id
     * @return bool
     */
    public function contains($namespace, $id)
    {
        $this->cacheProvider->setNamespace($namespace);

        return $this->cacheProvider->contains($id);
    }

    /**
     * @param $namespace
     * @param $id
     * @param $data
     * @return bool
     */
    public function save($namespace, $id, $data)
    {
        $this->cacheProvider->setNamespace($namespace);

        return $this->cacheProvider->save($id, $data, $this->ttl);
    }

    /**
     * @param $namespace
     * @param $id
     * @return bool
     */
    public function delete($namespace, $id)
    {
        $this->cacheProvider->setNamespace($namespace);

        return $this->cacheProvider->delete($id);
    }

    /**
     * @param $namespace
     * @return bool
     */
    public function deleteAll($namespace)
    {
        $this->cacheProvider->setNamespace($namespace);

        return $this->cacheProvider->deleteAll();
    }

    /**
     * @return bool
     */
    public function flushAll()
    {
        return $this->cacheProvider->flushAll();
    }
}