<?php

namespace Derby\Tests\Unit\Cache;

use Derby\Cache\FastDerbyCache;

class FastDerbyCacheTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $mockDerbyCache->shouldReceive('getTtl')->andReturn(100);

        $sut = new FastDerbyCache($mockDerbyCache);

        $this->assertEquals(100, $sut->getTtl());
        $this->assertEquals($mockDerbyCache, $sut->getCacheProvider());
    }

    public function testDoesNotContains()
    {
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $mockDerbyCache->shouldReceive('getTtl')->andReturn(100);
        $mockDerbyCache->shouldReceive('contains')->andReturn(false);

        $sut = new FastDerbyCache($mockDerbyCache);

        $this->assertFalse($sut->contains('TEST', 'item1'));
    }

    public function testContains()
    {
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $mockDerbyCache->shouldReceive('getTtl')->andReturn(100);
        $mockDerbyCache->shouldReceive('save')->andReturn(true);

        // dont hit cache provider, in memory should return
        $mockDerbyCache->shouldNotReceive('contains');

        $sut = new FastDerbyCache($mockDerbyCache);
        $sut->save('TEST', 'item1', 'data1');

        $this->assertTrue($sut->contains('TEST', 'item1'));
    }

    public function testDelete()
    {
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $mockDerbyCache->shouldReceive('getTtl')->andReturn(100);
        $mockDerbyCache->shouldReceive('save')->andReturn(true);
        $mockDerbyCache->shouldReceive('delete')->andReturn(true);

        // dont hit cache provider, in memory should return
        $mockDerbyCache->shouldNotReceive('contains');

        $sut = new FastDerbyCache($mockDerbyCache);
        $sut->save('TEST', 'item1', 'data1');

        $this->assertTrue($sut->contains('TEST', 'item1'));

        $sut->delete('TEST', 'item1');

        $this->assertFalse($sut->contains('TEST', 'item1'));
    }

    public function testFetch(){
        $mockDerbyCache = \Mockery::mock('Derby\Cache\DerbyCache');
        $mockDerbyCache->shouldReceive('getTtl')->andReturn(100);
        $mockDerbyCache->shouldReceive('save')->andReturn(true);

        // dont hit cache provider, in memory should return
        $mockDerbyCache->shouldNotReceive('contains');
        $mockDerbyCache->shouldNotReceive('fetch');

        $sut = new FastDerbyCache($mockDerbyCache);
        $sut->save('TEST', 'item1', 'data1');

        $this->assertTrue($sut->contains('TEST', 'item1'));

        $this->assertEquals('data1',$sut->fetch('TEST','item1'));
    }
}