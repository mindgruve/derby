<?php

namespace Derby\Cache;

class PaginatedDerbyCache extends DerbyCache
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
     * @param $page
     * @param $limit
     * @return false|mixed
     */
    public function fetch($namespace, $key, $page, $limit)
    {

        return $this->cache->fetch($namespace, $key.':'.$page.':'.$limit);
    }

    /**
     * @param $namespace
     * @param $key
     * @param $page
     * @param $limit
     * @return bool
     */
    public function contains($namespace, $key, $page, $limit)
    {
        return $this->cache->contains($namespace, $key.':'.$page.':'.$limit);
    }

    /**
     * @param $namespace
     * @param $key
     * @param $page
     * @param $limit
     * @param $data
     * @return bool
     */
    public function save($namespace, $key, $page, $limit, $data)
    {
        return $this->cache->save($namespace, $key.':'.$page.':'.$limit, $data, $this->ttl);
    }

    /**
     * @param $namespace
     * @param $key
     * @param $page
     * @param $limit
     * @return bool
     */
    public function delete($namespace, $key, $page, $limit)
    {
        return $this->cache->delete($namespace, $key.':'.$page.':'.$limit);
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

}