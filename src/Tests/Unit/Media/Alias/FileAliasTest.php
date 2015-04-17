<?php

namespace Derby\Tests\Unit\Media\Alias;

use Derby\Media\Alias;
use Derby\Media\FileInterface;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\Alias\FileAlias;

class FileAliasTest extends PHPUnit_Framework_TestCase
{
    protected static $targetClass = 'Derby\Media\Alias\FileAlias';
    protected static $fileInterface = 'Derby\Media\FileInterface';
    protected static $mediaInterface = 'Derby\Media\MediaInterface';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $this->assertTrue($sut instanceof Alias);
        $this->assertTrue($sut instanceof FileInterface);
    }

    public function testType()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $this->assertEquals(FileAlias::TYPE_ALIAS_FILE, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $target   = Mockery::mock(self::$fileInterface);
        $metaData = Mockery::mock(self::$metaDataClass);

        $sut = new FileAlias($target, $metaData);

        $this->assertEquals($sut->getTarget(), $target);
        $this->assertEquals($sut->getMetaData(), $metaData);
    }

    public function testConstructorWithDefaults()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $this->assertEquals($sut->getTarget(), $target);
        $this->assertEquals($sut->getMetaData(), $metaData);
    }

    public function testGetAlias()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $this->assertEquals($target, $sut->getTarget());
    }

    public function testGetKey()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $target->shouldReceive('getKey')->andReturn('/bar');
        $this->assertEquals('/bar', $sut->getKey());
    }

    public function testRename()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $target->shouldReceive('rename')->with('/foo2')->andReturn(true);
        $this->assertEquals(true, $sut->rename('/foo2'));
    }

    public function testRead()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $target->shouldReceive('read')->andReturn('abc');
        $this->assertEquals('abc', $sut->read());
    }

    public function testRemove()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $target->shouldReceive('remove')->andReturn(true);
        $this->assertEquals(true, $sut->remove());
    }

    public function testWrite()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$fileInterface);

        $sut = new FileAlias($target, $metaData);

        $target->shouldReceive('write')->with('efg')->andReturn(true);
        $this->assertEquals(true, $sut->write('efg'));
    }
}
