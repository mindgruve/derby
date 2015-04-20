<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\CollectionInterface;
use Derby\Media\Collection;
use Derby\Media;
use PHPUnit_Framework_TestCase;
use Mockery;


class CollectionTest extends PHPUnit_Framework_TestCase
{
    protected static $fileClass = 'Derby\Media\File';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $splObjectStorageClass = 'SplObjectStorage';
    protected static $mediaInterface = 'Derby\MediaInterface';
    protected static $metaDataClass = 'Derby\Media\MetaData';


    public function testInterface()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $items    = Mockery::mock(self::$splObjectStorageClass);

        $sut = new Collection($items, $metaData);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof CollectionInterface);
    }

    public function testType()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $items    = Mockery::mock(self::$splObjectStorageClass);

        $sut = new Collection($items, $metaData);

        $this->assertEquals(CollectionInterface::MEDIA_COLLECTION, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $items    = Mockery::mock(self::$splObjectStorageClass);

        $sut = new Collection($items, $metaData);

        $this->assertEquals($items, $sut->getItems());
        $this->assertEquals($metaData, $sut->getMetaData());
    }

    public function testAddAll()
    {
        $metaData    = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $objStorage1->attach($item1);
        $objStorage2->attach($item2);

        $sut1 = new Collection($objStorage1, $metaData);
        $sut2 = new Collection($objStorage2, $metaData);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertFalse($sut1->contains($item2));

        // add the collection
        $sut1->addAll($sut2);

        // check the counts
        $this->assertEquals(2, $sut1->count());
        $this->assertEquals(1, $sut2->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));
    }

    public function testAttachAndContainsAndCount()
    {
        $metaData    = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $sut1  = new Collection($objStorage1, $metaData);

        // check the counts
        $this->assertEquals(0, $sut1->count());
        $this->assertFalse($sut1->contains($item1));

        // add the collection
        $sut1->attach($item1);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
    }

    public function testDetach()
    {
        $metaData    = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);

        $objStorage1->attach($item1);
        $sut1 = new Collection($objStorage1, $metaData);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));

        // add the collection
        $sut1->detach($item1);

        // check the counts
        $this->assertEquals(0, $sut1->count());
        $this->assertFalse($sut1->contains($item1));
    }

    public function testGetItems()
    {
        $metaData    = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);

        $objStorage1->attach($item1);
        $sut1 = new Collection($objStorage1, $metaData);

        $this->assertEquals($objStorage1, $sut1->getItems());
    }

    public function testRemoveAll()
    {
        $metaData    = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $objStorage1->attach($item1);
        $objStorage1->attach($item2);
        $objStorage2->attach($item2);

        $sut1 = new Collection($objStorage1, $metaData);
        $sut2 = new Collection($objStorage2, $metaData);

        // check the counts
        $this->assertEquals(2, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));

        // add the collection
        $sut1->removeAll($sut2);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertFalse($sut1->contains($item2));
    }

    public function testRemoveAllExcept()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $objStorage1->attach($item1);
        $objStorage1->attach($item2);
        $objStorage2->attach($item2);

        $sut1 = new Collection( $objStorage1, $metaData);
        $sut2 = new Collection( $objStorage2, $metaData);

        // check the counts
        $this->assertEquals(2, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));

        // add the collection
        $sut1->removeAllExcept($sut2);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertFalse($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));
    }
}
