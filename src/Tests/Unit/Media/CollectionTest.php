<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\GroupInterface;
use Derby\Media\Group;
use Derby\Media;
use PHPUnit_Framework_TestCase;
use Mockery;


class CollectionTest extends PHPUnit_Framework_TestCase
{
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $mediaInterface = 'Derby\MediaInterface';
    protected static $collectionAdapterInterface = 'Derby\Adapter\CollectionAdapterInterface';


    public function testInterface()
    {
        $key     = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new Media\Collection($key, $adapter);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof Media\CollectionInterface);
    }

    public function testType()
    {
        $key     = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new Media\Collection($key, $adapter);

        $this->assertEquals(Media\Collection::MEDIA_COLLECTION, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $key     = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new Media\Collection($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }

    public function testAddAll()
    {
        $key1     = 'Foo\\';
        $adapter1 = Mockery::mock(self::$collectionAdapterInterface);

        $sut = new Media\Collection($key1, $adapter1);

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $this->assertEquals(0, $sut->count());

        // Add Items
        $sut->addAll(array($item1, $item2));

        // check the counts
        $this->assertEquals(2, $sut->count());
        $this->assertTrue($sut->contains($item1));
        $this->assertTrue($sut->contains($item2));
    }

    public function testAttachAndDetach()
    {
        $key     = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);
        $item1   = Mockery::mock(self::$mediaInterface);

        $sut = new Media\Collection($key, $adapter);

        // check the counts
        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($item1));

        // add the collection
        $sut->attach($item1);

        // check the counts
        $this->assertEquals(1, $sut->count());
        $this->assertTrue($sut->contains($item1));

        // remove the item
        $sut->detach($item1);

        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($item1));
    }

    public function testGetItems()
    {
        $key     = 'Foo\\';
        $adapter = Mockery::mock(self::$collectionAdapterInterface);
        $item1   = Mockery::mock(self::$mediaInterface);

        $sut = new Media\Collection($key, $adapter);

        $sut->attach($item1);

        $this->assertTrue($sut->getItems() instanceof \SplObjectStorage);
        $this->assertEquals(1, $sut->getItems()->count());
    }

    public function testRemoveAll()
    {
        $key         = 'Foo\\';
        $adapter     = Mockery::mock(self::$collectionAdapterInterface);
        $item1       = Mockery::mock(self::$mediaInterface);
        $item2       = Mockery::mock(self::$mediaInterface);

        $sut = new Media\Collection($key, $adapter);

        $sut->attach($item1);
        $sut->attach($item2);

        // add the collection
        $sut->removeAll(array($item2));

        // check the counts
        $this->assertEquals(1, $sut->count());
        $this->assertTrue($sut->contains($item1));
        $this->assertFalse($sut->contains($item2));
    }

    public function testRemoveAllExcept()
    {
        $key         = 'Foo\\';
        $adapter     = Mockery::mock(self::$collectionAdapterInterface);
        $item1       = Mockery::mock(self::$mediaInterface);
        $item2       = Mockery::mock(self::$mediaInterface);

        $sut = new Media\Collection($key, $adapter);
        $sut->attach($item1);
        $sut->attach($item2);

        // check the counts
        $this->assertEquals(2, $sut->count());
        $this->assertTrue($sut->contains($item1));
        $this->assertTrue($sut->contains($item2));

        // add the collection
        $sut->removeAllExcept(array($item2));

        // check the counts
        $this->assertEquals(1, $sut->count());
        $this->assertFalse($sut->contains($item1));
        $this->assertTrue($sut->contains($item2));
    }
}
