<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\EmbedInterface;
use Derby\Media\Embed;

class EmbedTest extends PHPUnit_Framework_TestCase
{
    protected static $mediaInterface = 'Derby\MediaInterface';
    protected static $embedAdapterInterface = 'Derby\Adapter\EmbedAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$embedAdapterInterface);

        $sut = new Embed($key, $adapter);

        $this->assertTrue($sut instanceof \Derby\Media);
        $this->assertTrue($sut instanceof EmbedInterface);
    }

    public function testConstructor()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$embedAdapterInterface);

        $sut = new Embed($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$embedAdapterInterface);

        $sut = new Embed($key, $adapter);
        
        $this->assertEquals(EmbedInterface::TYPE_MEDIA_EMBED, $sut->getMediaType());
    }
}
