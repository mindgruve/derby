<?php

namespace Derby\Tests\Unit\Cache;

use Derby\Cache\DerbyCache;

class DerbyCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $mockCacheProvider = \Mockery::mock('Doctrine\Common\Cache\CacheProvider');
        $ttl = 100;
        $sut = new DerbyCache($mockCacheProvider, $ttl);

        $this->assertEquals($mockCacheProvider, $sut->getCacheProvider());
        $this->assertEquals($ttl, $sut->getTtl());
    }

    /**
     * @todo
     */
}