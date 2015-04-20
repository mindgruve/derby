<?php

namespace Derby\Tests\Unit\Media\Alias;

use Derby\Media\EmbedInterface;
use Derby\Media\Alias;
use Derby\Media\FileInterface;
use PHPUnit_Framework_TestCase;
use Derby\Media\Alias\EmbedAlias;
use Mockery;
use Derby\Media\Alias\FileAlias;

class EmbedAliasTest extends PHPUnit_Framework_TestCase
{

    protected static $targetClass = 'Derby\Media\Alias\EmbedAlias';
    protected static $embedInterface = 'Derby\Media\EmbedInterface';
    protected static $fileInterface = 'Derby\Media\FileInterface';
    protected static $mediaInterface = 'Derby\MediaInterface';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $this->assertTrue($sut instanceof Alias);
        $this->assertTrue($sut instanceof EmbedInterface);
    }

    public function testType()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $this->assertEquals(EmbedAlias::TYPE_MEDIA_ALIAS_EMBED, $sut->getMediaType());
    }

    public function testConstructor()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $this->assertEquals($target, $sut->getTarget());
        $this->assertEquals($metaData, $sut->getMetaData());
    }

    public function testGetAlias()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $this->assertEquals($target, $sut->getTarget());
    }

    public function testGetOption()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $key   = 'key';
        $value = 'value';
        $target->shouldReceive('getOption')->with($key)->andReturn($value);
        $this->assertEquals($value, $sut->getOption($key));
    }

    public function testGetOptions()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $options  = array(
            'option1' => 'value1',
            'option2' => 'value2',
        );
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);
        $target->shouldReceive('getOptions')->andReturn($options);
        $this->assertEquals($options, $sut->getOptions());
    }

    public function testSetOption()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $key   = 'key';
        $value = 'value';
        $target->shouldReceive('setOption')->with($key, $value)->andReturn($target);
        $this->assertEquals($sut, $sut->setOption($key, $value));
    }

    public function testSetOptions()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $options = array(
            'option1' => 'value1',
            'option2' => 'value2',
        );
        $target->shouldReceive('setOptions')->with($options)->andReturn($target);
        $this->assertEquals($sut, $sut->setOptions($options));
    }

    public function testRender()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $target   = Mockery::mock(self::$embedInterface);

        $sut = new EmbedAlias($target, $metaData);

        $html = "HELLO WORLD";
        $target->shouldReceive('render')->andReturn($html);
        $this->assertEquals($html, $sut->render());
    }

}
