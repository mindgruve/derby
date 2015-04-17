<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\AliasInterface;
use Derby\Media\Alias;
use Derby\Media\Media;
use PHPUnit_Framework_TestCase;
use Mockery;

class AliasTest extends PHPUnit_Framework_TestCase
{
    protected static $aliasClass = 'Derby\Media\Alias';
    protected static $mediaInterface = 'Derby\Media\MediaInterface';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$mediaInterface);

        $sut = new Alias($target, $metaData);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof AliasInterface);
    }

    public function testType()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$mediaInterface);

        $sut = new Alias($target, $metaData);

        $this->assertEquals(AliasInterface::TYPE_ALIAS, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$mediaInterface);

        $sut = new Alias($target, $metaData);

        $this->assertEquals($target, $sut->getTarget());
        $this->assertEquals($metaData, $sut->getMetaData());
    }

    public function testGetTarget()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$mediaInterface);

        $sut = new Alias($target, $metaData);

        $this->assertEquals($target, $sut->getTarget());
    }

}
