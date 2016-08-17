<?php

namespace Derby\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;

class FastDerbyCache extends DerbyCache
{

    /**
     * @var ArrayCache
     */
    protected $inMemoryCache;

    /**
     * @var CacheProvider
     */
    protected $derbyCache;

    /**
     * @var int
     */
    protected $tt;

    public function __construct(DerbyCache $derbyCache)
    {
        $this->derbyCache = $derbyCache;
        $this->ttl = $derbyCache->getTtl();
        $this->inMemoryCache = new ArrayCache();
    }

    public function contains($namespace, $id)
    {
        $this->inMemoryCache->setNamespace($namespace);
        if ($this->inMemoryCache->contains($id)) {
            return true;
        }

        if ($this->derbyCache->contains($namespace, $id)) {
            return true;
        }

        return false;
    }

    public function delete($namespace, $id)
    {
        $this->inMemoryCache->setNamespace($namespace);
        $this->inMemoryCache->delete($id);

        return $this->derbyCache->delete($namespace, $id);
    }

    public function deleteAll($namespace)
    {
        $this->inMemoryCache->setNamespace($namespace);
        $this->inMemoryCache->deleteAll();

        return $this->derbyCache->deleteAll($namespace);
    }

    public function fetch($namespace, $id)
    {
        $this->inMemoryCache->setNamespace($namespace);
        if ($this->inMemoryCache->contains($id)) {
            return $this->inMemoryCache->fetch($id);
        }

        return $this->derbyCache->fetch($namespace, $id);
    }

    public function flushAll()
    {
        $this->inMemoryCache->flushAll();

        return $this->derbyCache->flushAll();
    }

    public function save($namespace, $id, $data)
    {
        $this->inMemoryCache->setNamespace($namespace);
        $this->inMemoryCache->save($id, $data, $this->ttl);

        return $this->derbyCache->save($namespace, $id, $data);
    }

    public function getCacheProvider()
    {
        return $this->derbyCache;
    }

    public function getTtl()
    {
        return $this->ttl;
    }
}