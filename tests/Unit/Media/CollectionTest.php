<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\Media;
use PHPUnit_Framework_TestCase;
use Mockery;


class CollectionTest extends PHPUnit_Framework_TestCase
{
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $mediaInterface = 'Derby\Media\MediaInterface';
    protected static $collectionAdapterInterface = 'Derby\Adapter\CollectionAdapterInterface';


    public function testInterface()
    {
        $key = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new \Derby\Media\Collection($key, $adapter);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof \Derby\Media\CollectionInterface);
    }

    public function testType()
    {
        $key = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new \Derby\Media\Collection($key, $adapter);

        $this->assertEquals(\Derby\Media\Collection::MEDIA_COLLECTION, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $key = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new \Derby\Media\Collection($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }

    public function testAddAndRemove()
    {
        $key = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);
        $item1 = Mockery::mock(self::$mediaInterface);

        $sut = new \Derby\Media\Collection($key, $adapter);

        // check the counts
        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($item1));

        // add the collection
        $sut->add($item1);

        // check the counts
        $this->assertEquals(1, $sut->count());
        $this->assertTrue($sut->contains($item1));

        // remove the item
        $sut->remove($item1);

        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($item1));
    }

    public function testGetItems()
    {
        $key = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);
        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);
        $item3 = Mockery::mock(self::$mediaInterface);
        $item4 = Mockery::mock(self::$mediaInterface);
        $item5 = Mockery::mock(self::$mediaInterface);
        $item6 = Mockery::mock(self::$mediaInterface);
        $item7 = Mockery::mock(self::$mediaInterface);
        $item8 = Mockery::mock(self::$mediaInterface);
        $item9 = Mockery::mock(self::$mediaInterface);
        $item10 = Mockery::mock(self::$mediaInterface);
        $item11 = Mockery::mock(self::$mediaInterface);
        $item12 = Mockery::mock(self::$mediaInterface);
        $item13 = Mockery::mock(self::$mediaInterface);
        $item14 = Mockery::mock(self::$mediaInterface);
        $item15 = Mockery::mock(self::$mediaInterface);

        $sut = new \Derby\Media\Collection($key, $adapter);

        $sut->add($item1);
        $sut->add($item2);
        $sut->add($item3);
        $sut->add($item4);
        $sut->add($item5);
        $sut->add($item6);
        $sut->add($item7);
        $sut->add($item8);
        $sut->add($item9);
        $sut->add($item10);
        $sut->add($item11);
        $sut->add($item12);
        $sut->add($item13);
        $sut->add($item14);
        $sut->add($item15);
        $this->assertTrue(is_array($sut->getItems()));
        $this->assertEquals(10, count($sut->getItems()));
        $this->assertEquals(5, count($sut->getItems(1, 5)));
        $this->assertEquals(5, count($sut->getItems(2, 5)));
        $this->assertEquals(15, count($sut->getItems(1, 20)));
        $this->assertEquals(15, $sut->count());
    }
}
