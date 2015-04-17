<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\Media;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\EmbedInterface;
use Derby\Media\Embed;

class EmbedTest extends PHPUnit_Framework_TestCase
{
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $metaDataClass = 'Derby\Media\MetaData';
    protected static $mediaInterface = 'Derby\Media\MediaInterface';

    public function testInterface()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $options  = array();
        $sut      = new Embed($options, $metaData);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof EmbedInterface);
    }

    public function testConstructor()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $options  = array();

        $sut = new Embed($options, $metaData);

        $this->assertEquals($options, $sut->getOptions());
        $this->assertEquals($metaData, $sut->getMetaData());
    }

    public function testType()
    {
        $metaData = Mockery::mock(self::$metaDataClass);
        $options  = array();

        $sut = new Embed($options, $metaData);

        $this->assertEquals(EmbedInterface::TYPE_MEDIA_EMBED, $sut->getMediaType());
    }
}
