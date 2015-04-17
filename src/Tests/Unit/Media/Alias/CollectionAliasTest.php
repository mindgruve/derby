<?php

namespace Derby\Tests\Unit\Media\Alias;

use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\Alias;
use Derby\Media\CollectionInterface;
use Derby\Media\Alias\CollectionAlias;

class CollectionAliasTest extends PHPUnit_Framework_TestCase
{

    protected static $aliasClass = 'Derby\Media\Alias\CollectionAlias';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $mediaInterface = 'Derby\Media\MediaInterface';
    protected static $splObjectStorageClass = 'SplObjectStorage';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $target   = Mockery::mock(self::$collectionClass);
        $metaData = Mockery::mock(self::$metaDataClass);

        $sut = new CollectionAlias($target, $metaData);

        $this->assertTrue($sut instanceof CollectionInterface);
    }

    public function testType()
    {
        $target   = Mockery::mock(self::$collectionClass);
        $metaData = Mockery::mock(self::$metaDataClass);

        $sut = new CollectionAlias($target, $metaData);

        $this->assertEquals(Alias\CollectionAlias::TYPE_ALIAS_COLLECTION, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $target   = Mockery::mock(self::$collectionClass);
        $metaData = Mockery::mock(self::$metaDataClass);

        $sut = new CollectionAlias($target, $metaData);

        $this->assertEquals($sut->getTarget(), $target);
        $this->assertEquals($sut->getMetaData(), $metaData);
    }

    public function testAddAll()
    {
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $target1 = Mockery::mock(self::$collectionClass, array($objStorage1, $metaData))->makePartial();
        $target2 = Mockery::mock(self::$collectionClass, array($objStorage2, $metaData))->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $target2->attach($item2);

        $sut1 = new CollectionAlias($target1, $metaData);
        $sut2 = new CollectionAlias($target2, $metaData);

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
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $target1     = Mockery::mock(self::$collectionClass, array($objStorage1, $metaData))->makePartial();
        $item1       = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $sut1 = new CollectionAlias($target1, $metaData);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
    }

    public function testDetach()
    {
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $target1     = Mockery::mock(self::$collectionClass, array( $objStorage1, $metaData))->makePartial();
        $item1       = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $sut1 = new CollectionAlias( $target1, $metaData);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertTrue($sut1->contains($item1));

        $sut1->detach($item1);

        // check the counts
        $this->assertEquals(0, $sut1->count());
        $this->assertFalse($sut1->contains($item1));
    }

    public function testGetItems()
    {
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $target1     = Mockery::mock(self::$collectionClass, array( $objStorage1, $metaData))->makePartial();
        $item1       = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $sut = new CollectionAlias( $target1, $metaData);

        $this->assertEquals(1, $sut->count());
        $this->assertEquals($objStorage1, $target1->getItems());
    }

    public function testRemoveAll()
    {
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $target1 = Mockery::mock(self::$collectionClass, array( $objStorage1, $metaData))->makePartial();
        $target2 = Mockery::mock(self::$collectionClass, array( $objStorage2, $metaData))->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $target1->attach($item2);
        $target2->attach($item2);

        $sut1 = new CollectionAlias( $target1, $metaData);
        $sut2 = new CollectionAlias( $target2, $metaData);

        // check the counts
        $this->assertEquals(2, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));

        // add the collection
        $sut1->removeAll($sut2);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertEquals(1, $sut2->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertFalse($sut1->contains($item2));
    }

    public function testRemoveAllExcept()
    {
        $metaData = Mockery::mock(self::$metaDataClass);

        $objStorage1 = Mockery::mock(self::$splObjectStorageClass)->makePartial();
        $objStorage2 = Mockery::mock(self::$splObjectStorageClass)->makePartial();

        $target1 = Mockery::mock(self::$collectionClass, array($objStorage1, $metaData))->makePartial();
        $target2 = Mockery::mock(self::$collectionClass, array($objStorage2, $metaData))->makePartial();

        $item1 = Mockery::mock(self::$mediaInterface);
        $item2 = Mockery::mock(self::$mediaInterface);

        $target1->attach($item1);
        $target1->attach($item2);
        $target2->attach($item2);

        $sut1 = new CollectionAlias( $target1, $metaData);
        $sut2 = new CollectionAlias( $target2, $metaData);

        // check the counts
        $this->assertEquals(2, $sut1->count());
        $this->assertTrue($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));

        // add the collection
        $sut1->removeAllExcept($sut2);

        // check the counts
        $this->assertEquals(1, $sut1->count());
        $this->assertEquals(1, $sut2->count());
        $this->assertFalse($sut1->contains($item1));
        $this->assertTrue($sut1->contains($item2));
    }
}
