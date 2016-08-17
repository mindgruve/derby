<?php

namespace Derby\Tests\Unit\Cache;

use Derby\Cache\PaginatedDerbyCache;

class PaginatedDerbyCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new PaginatedDerbyCache($mockDerbyCache);
    }

    /**
     * @todo
     */

}