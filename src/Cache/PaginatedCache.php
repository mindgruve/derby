<?php

namespace Derby\Cache;

class PaginatedCache
{

    /**
     * @var DerbyCache
     */
    protected $cache;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @param DerbyCache $cache
     */
    public function __construct(DerbyCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $namespace
     * @param $key
     * @param $limit
     * @param null $continuationToken
     * @return false|mixed
     */
    public function fetch($namespace, $key, $limit, $continuationToken = null)
    {
        return $this->cache->fetch($namespace, $this->generateCacheKey($key, $limit, $continuationToken));
    }

    /**
     * @param $namespace
     * @param $key
     * @param $limit
     * @param $continuationToken
     * @return bool
     */
    public function contains($namespace, $key, $limit, $continuationToken = null)
    {
        return $this->cache->contains($namespace, $this->generateCacheKey($key, $limit, $continuationToken));
    }

    /**
     * @param $namespace
     * @param $resultPage
     * @param $key
     * @param $limit
     * @param null $continuationToken
     * @return bool
     */
    public function save($namespace, $resultPage, $key, $limit, $continuationToken = null)
    {
        return $this->cache->save(
            $namespace,
            $this->generateCacheKey($key, $limit, $continuationToken),
            $resultPage
        );
    }

    /**
     * @param $namespace
     * @param $key
     * @param $limit
     * @param $continuationToken
     * @return bool
     */
    public function delete($namespace, $key, $limit, $continuationToken = null)
    {
        return $this->cache->delete($namespace, $this->generateCacheKey($key, $limit, $continuationToken));
    }

    /**
     * @param $namespace
     * @return bool
     */
    public function deleteAll($namespace)
    {
        return $this->cache->deleteAll($namespace);
    }

    /**
     * @return bool
     */
    public function flushAll()
    {
        return $this->cache->flushAll();
    }

    /**
     * @param $key
     * @param $limit
     * @param null $continuationToken
     * @return string
     */
    protected function generateCacheKey($key, $limit, $continuationToken = null)
    {
        return $key.':'.$limit.':'.$continuationToken;
    }

}